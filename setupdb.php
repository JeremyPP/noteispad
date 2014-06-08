<?php
// Run this from the command line!
// Setup the database - complete the details below. Please note that this script
// expects the user and database to already exist.
// dbuser should have all Data and Structure grants but not Admin apart from "Super" (for the set global command)
$dbhost = '127.0.0.1';
$dbname = 'noteispad';
$dbuser = 'noteispad';
$dbpass = 'h0undd0g';

$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if($mysql->connect_errno)
{
	die("Failed to connect to db: " . $mysql->connect_error);
}

if(!$mysql->query("set global event_scheduler=on"))
{
	die("Failed to set event_scheduler on: " .  $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS fastnote(fnote_id INT(11) NOT NULL AUTO_INCREMENT, fnote_name VARCHAR(1024), fnote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(fnote_id))"))
{
	die("Failed to create fastnote: " .  $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS fastnote_lines(fnote_id INT(11) NOT NULL, fnote_seq INT NOT NULL default 1, fnote_text VARCHAR(3072), INDEX fnote_id_idx (fnote_id), FOREIGN KEY (fnote_id) REFERENCES fastnote(fnote_id) ON DELETE CASCADE)"))
{
	die("Failed to create fastnote_lines: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS fastnote_archive(fnote_name VARCHAR(1024), fnote_text VARCHAR(3072))"))
{
	die("Failed to create fastnote_archive: " . $mysql->error);
}

if(!$mysql->query("drop procedure if exists noteispad.delete_fastnote_sp"))
{
	die("Failed to drop procedure: " . $mysql->error);
}

if(!$mysql->query(" CREATE PROCEDURE noteispad.delete_fastnote_sp (fncode varchar(1024)) 
begin
insert into fastnote_archive(fnote_name, fnote_text)
select F.fnote_name, FL.fnote_text
       from fastnote F, fastnote_lines FL
        where F.fnote_name = fncode
        and FL.fnote_id = F.fnote_id
        and FL.fnote_seq = (select max(fnote_seq) from fastnote_lines where fnote_id = F.fnote_id);

delete from fastnote where fnote_name = fncode;
end"))
{
	die("Failed to create procedure: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS plans(plan_id INT not null auto_increment, name VARCHAR(256) not null, cost decimal(5,2) not null, notes_per_month smallint not null, primary key(plan_id))"))
{
	die("Failed to create plans: " . $mysql->error);
}

$res = $mysql->query("select * from plans");

if(!$res->num_rows)
{
	if(!$mysql->query("INSERT into plans(name, cost, notes_per_month) values('Basic', 2, 20)") || !$mysql->query("INSERT into plans(name, cost, notes_per_month) values('Pro', 5, 100)") || !$mysql->query("INSERT into plans(name, cost, notes_per_month) values('Premium', 10, 500)"))
	{
		die("Failed to populate plans: " . $mysql->error);
	}
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS users(user_id int not null auto_increment, user_name varchar(256) not null, email varchar(256) not null, password char(60) not null, plan_id INT not null, font_colour char(7) not null default '000', background_colour char(7) not null default 'fff', font_size smallint not null default 3, paid_date timestamp not null default '0000-00-00 00:00:00', auth_key varchar(255) default null, reset_id varchar(255) default null, reset_sent timestamp not null default '0000-00-00 00:00:00', primary key(user_id))"))
{
	die("Failed to create users: " . $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS usernote(usernote_id INT(11) NOT NULL AUTO_INCREMENT, user_id int not null, usernote_name VARCHAR(1024), usernote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, treat_as_fastnote boolean default false, PRIMARY KEY(usernote_id), INDEX user_id_idx (user_id), FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE)"))
{
	die("Failed to create usernote: " .  $mysql->error);
}

if(!$mysql->query("CREATE TABLE IF NOT EXISTS usernote_lines(usernote_id INT(11) NOT NULL, usernote_seq INT NOT NULL default 1, usernote_text VARCHAR(3072), INDEX usernote_id_idx (usernote_id), FOREIGN KEY (usernote_id) REFERENCES usernote(usernote_id) ON DELETE CASCADE)"))
{
	die("Failed to create usernote_lines: " . $mysql->error);
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
	
?>
