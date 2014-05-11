<?php
// Run this from the command line!
// Setup the databse - complete the details below. Please note that this script
// expects the user and database to already exist.
// dbuser should have all Data and Structure grants but not Admin
$dbhost = 'localhost';
$dbname = 'noteispad';
$dbuser = 'noteispad';
$dbpass = 'h0undd0g';

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

$result = mysql_query("CREATE TABLE IF NOT EXISTS fastnote(fnote_id INT(11) NOT NULL AUTO_INCREMENT, fnote_name VARCHAR(1024), fnote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(fnote_id))") or die(mysql_error());

$result = mysql_query("CREATE TABLE IF NOT EXISTS fastnote_lines(fnote_id INT(11) NOT NULL, fnote_seq INT NOT NULL, fnote_text VARCHAR(3072), INDEX fnote_id_idx (fnote_id), FOREIGN KEY (fnote_id) REFERENCES fastnote(fnote_id) ON DELETE CASCADE)") or die(mysql_error());

$result = mysql_query("CREATE TABLE IF NOT EXISTS fastnote_archive(fnote_name VARCHAR(1024), fnote_text VARCHAR(3072))") or die(mysql_error());

$result = mysql_query("drop procedure if exists noteispad.delete_fastnote_sp");

$result = mysql_query("delimiter $$

CREATE PROCEDURE noteispad.delete_fastnote_sp (fncode varchar(1024)) 
begin

declare exit handler for sqlexception
begin
rollback;
end;

declare exit handler for sqlwarning
begin
rollback;
end;

start transaction;

insert into fastnote_archive(fnote_name, fnote_text)
select F.fnote_name, FL.fnote_text
       from fastnote F, fastnote_lines FL
        where F.fnote_name = fncode
        and FL.fnote_id = F.fnote_id
        and FL.fnote_seq = (select max(fnote_seq) from fastnote_lines where fnote_id = F.fnote_id);

delete from fastnote where fnote_name = fncode;

commit;

end
$$
");
?>
