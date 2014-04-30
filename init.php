<?php
    session_start();
    require_once("functions.php");
    
    if (!isset($_POST['email']) and isset($_SESSION['email']) and isset($_SESSION['tolken'])) {
        $verify = verifyTolken($_SESSION['email'], $_SESSION['tolken']);
        if(!$verify){
            deslogar();
        }
    } else {
        deslogar();
    }
?>