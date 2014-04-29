<?php 
    require_once("init.php");
    require_once("functions.php");
    $SERVER = "http://localhost:8888";
    
    if (isset($_POST['todas'])) {
        header("Location: all.php");
    }
    if (isset($_POST['salvar']) || isset($_POST['sair'])) {
        if (isset($_POST['code']) and strlen($_POST['code'])>0) {
            $_POST['function'] = 'save';
            $json = json_decode(sendPost($SERVER, $_POST),true);
            
            if (isset($_POST['sair'])) {
                header("Location: .");
            } else {
                $_SESSION['salvo'] = 1;
                header("Location: notpad.php?code=".$json['document']);
            }
        }
    }
?>
<html>
    <head>
        <link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<?php
    echo "<a id='salvo' href='notpad.php?code=".$json['document']."'><div id='textCenter'>SALVO</div></a>";
?>