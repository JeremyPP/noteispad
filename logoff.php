<?php 
require_once("init.php");
require_once("functions.php");
$SERVER = "http://localhost:8888";

saveNote($_POST);

session_start();

clearAuthId($_SESSION['user_id']);

unset($_SESSION['user_id']);

session_destroy();
header("Location: .");
?>
