<?php 
require_once("init.php");
$SERVER = "http://localhost:8888";

saveNote($_POST);

clearAuthId($_SESSION['user_id']);

unset($_SESSION['user_id']);

session_destroy();
header("Location: .");
?>
