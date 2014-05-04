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
?>
