<?php
$dbhost = 'localhost';
$dbname = 'noteispad';
$dbuser = 'noteispad';
$dbpass = 'h0undd0g';

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
?>
