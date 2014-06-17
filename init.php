<?php
$dbhost = '127.0.0.1';
$dbname = 'noteispad';
$dbuser = 'noteispad';
$dbpass = 'h0undd0g';

$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($mysql->connect_errno)
{
	echo "Failed to connect to db: " . $mysqli->connect_error;
}

date_default_timezone_set('UTC');
?>
