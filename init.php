<?php
require_once("functions.php");

session_start();

if(isset($_SESSION['user_id']) && ($_SERVER['REQUEST_URI'] != '/payment_error.php') && ($_SERVER['REQUEST_URI'] != '/me.php'))
{
	if(!isValidUser($_SESSION['user_id']) || failedPayment($_SESSION['user_id']))
	{
		header("Location: payment_error.php");
		exit();
	}
}

$dbhost = '127.0.0.1';
$dbname = 'notispad_dev';
$dbuser = 'notispad_dev';
$dbpass = 'h0undd0g';

$mysql = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($mysql->connect_errno)
{
	echo "Failed to connect to db: " . $mysqli->connect_error;
}

date_default_timezone_set('UTC');

?>
