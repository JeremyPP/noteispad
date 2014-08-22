<?php
require_once("dbconfig.php");
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

$mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
if($mysql->connect_errno)
{
	echo "Failed to connect to db: " . $mysqli->connect_error;
}

date_default_timezone_set('UTC');

?>
