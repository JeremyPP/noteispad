<?php
    error_reporting(0);
    session_start();
    require_once("functions.php");
    
    if (!isset($_POST['email']) and isset($_SESSION['email']) and isset($_SESSION['tolken'])) {
        $verify = verifyTolken($_SESSION['email'], $_SESSION['tolken']);
        if(!$verify){
            unset ($_SESSION['email']);
            unset ($_SESSION['tolken']);
        }
    } else {
        if (isset($_SESSION['email'])) {unset ($_SESSION['email']);}
        if (isset($_SESSION['tolken'])){unset ($_SESSION['tolken']);}
    }
?>