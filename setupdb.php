<?php
// Run this from the command line!
// Setup the database - complete the details below. Please note that this script
// expects the user and database to already exist.
// dbuser should have all Data and Structure grants but not Admin apart from "Super" (for the set global command)
require_once("dbconfig.php");

$mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($mysql->connect_errno)
{
	die("Failed to connect to db: " . $mysql->connect_error);
}

if(!$mysql->query("set global event_scheduler=on"))
{
	die("Failed to set event_scheduler on: " .  $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS fastnote_archive(note_id INT(11), note_name VARCHAR(1024), note_text VARCHAR(3072), PRIMARY KEY(note_id))"))
{
	die("Failed to create fastnote_archive: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS notes(note_id INT(11) NOT NULL AUTO_INCREMENT, user_id int default null, note_name VARCHAR(1024), note_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(note_id), INDEX user_id_idx (user_id), FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE)"))
{
	die("Failed to create notes: " .  $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS note_lines(note_id INT(11) NOT NULL, note_seq INT(11) NOT NULL AUTO_INCREMENT, note_text VARCHAR(3072), PRIMARY KEY(note_seq), INDEX note_id_idx (note_id, note_seq), FOREIGN KEY (note_id) REFERENCES notes(note_id) ON DELETE CASCADE)"))
{
	die("Failed to create note_lines: " . $mysql->error);
}

if(!$mysql->query("drop procedure if exists " . DBNAME . ".delete_note_sp"))
{
	die("Failed to drop procedure: " . $mysql->error);
}

if(!$mysql->query(" CREATE PROCEDURE " . DBNAME . ".delete_note_sp (IN nid INT(11)) 
MODIFIES SQL DATA
begin
insert into fastnote_archive(note_id, note_name, note_text)
select concat(curdate()+0,N.note_id), N.note_name, NL.note_text
       from notes N, note_lines NL
        where N.note_id = nid
        and NL.note_seq = (select max(note_seq) from note_lines where note_id = nid);

delete from notes where note_id = nid;
end"))
{
	die("Failed to create procedure: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS plans(plan_id INT not null, name VARCHAR(256) not null, cost decimal(5,2) not null, notes_per_month smallint not null, paypal_code varchar(255) not null, primary key(plan_id))"))
{
	die("Failed to create plans: " . $mysql->error);
}

if(!$mysql->query("delete from plans"))
{
	die("Failed to clear plans: " . $mysql->error);
}

if(!$mysql->query("INSERT into plans(plan_id, name, cost, notes_per_month) values(1, 'Basic', 2, 20)") || !$mysql->query("INSERT into plans(plan_id, name, cost, notes_per_month) values(2,'Pro', 5, 100)") || !$mysql->query("INSERT into plans(plan_id, name, cost, notes_per_month) values(3, 'Premium', 10, 500)"))
{
	die("Failed to populate plans: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS users(user_id int not null auto_increment, user_name varchar(256) not null, email varchar(256) not null, password char(60) not null, plan_id INT not null, font_colour char(7) not null default '000', background_colour char(7) not null default 'fff', font_size smallint not null default 22, payment_date timestamp not null default '0000-00-00 00:00:00', subscr_id varchar(255) default null, payer_id varchar(255) default null, cancel_in_progress boolean default false not null, plan_change boolean default false not null, subscr_failed boolean default false not null, auth_key varchar(255) default null, reset_id varchar(255) default null, reset_sent timestamp not null default '0000-00-00 00:00:00', primary key(user_id))"))
{
	die("Failed to create users: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS colours(hashvalue char(6) NOT NULL, name VARCHAR(255))"))
{
	die("Failed to create colours: " . $mysql->error);
}

$mysql->query("delete from colours");

$colour = [
                        "000" => "Black",
                        "777" => "Dark gray",
                        "ccc" => "Light gray",
                        "fff" => "White",
                        "771696" => "Dark magenta",
                        "A148BD" => "Moderate magenta",
                        "C371DD" => "Soft magenta",
                        "DDA9EE" => "Very soft magenta",
                        "227492" => "Dark blue",
                        "48B1F7" => "Bright blue",
                        "8DD7FA" => "Very soft blue",
                        "C5F1FF" => "Very pale cyan",
                        "17A82F" => "Dark lime green",
                        "2CD347" => "Strong lime green",
                        "63F57B" => "Soft lime green",
                        "99F6A8" => "Very soft lime green",
                        "FF8718" => "Vivid orange",
                        "FFAC18" => "Vivid orange",
                        "F7D757" => "Soft yellow",
                        "FFF46F" => "Very soft yellow",
                        "DD0F0F" => "Vivid red",
                        "F14B4B" => "Soft red",
                        "FF9494" => "Very light red",
                        "FFBBBB" => "Pale red"
                ];

foreach($colour as $k => $v)
{
	$mysql->query("insert into colours value('$k', '$v')");
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS font_size(size_name char(6) NOT NULL, size_px smallint not null)"))
{
	die("Failed to create font_size: " . $mysql->error);
}

$mysql->query("delete from font_size");

$font_sizes = [
                        "Small" => 18,
                        "Normal" => 22,
                        "Large" => 28,
                        "Huge" => 33
                ];

foreach($font_sizes as $k => $v)
{
	$mysql->query("insert into font_size value('$k', $v)");
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS paypal(user varchar(255) NOT NULL, pwd varchar(255) not null, signature varchar(255) not null, sandbox boolean default true, total_income decimal(7,2) default 0.0 not null)"))
{
	die("Failed to create paypal: " . $mysql->error);
}

$mysql->query("delete from paypal");
$mysql->query("insert into paypal(user, pwd, signature, sandbox) values('notispad_api1.gmail.com', '1402489348', 'AFcWxV21C7fd0v3bYYYRCpSSRl31Ab9.jE5LVWPHdMnGj7Nw.cv6nqr6', true)");

if(!$mysql->query("CREATE TABLE IF NOT EXISTS ticket(token varchar(100) NOT NULL, name varchar(255) default null, pwd varchar(255) default null, email varchar(255) default null, planno int default null, subscr_id varchar(255) default null, processed boolean not null default false, primary key(token))"))
{
	die("Failed to create ticket: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS paypal_transactions(txn_id varchar(100) NOT NULL, date_done timestamp default now(), primary key(txn_id))"))
{
	die("Failed to create ticket: " . $mysql->error);
}
?>
