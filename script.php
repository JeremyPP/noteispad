<?php 
require_once("init.php");
require_once("functions.php");
$SERVER = "http://localhost:8888";

if(isset($_POST['code']))
{
	session_start();
	$_SESSION['code'] = $_POST['code'];
}
    
if(isset($_POST['todas'])) 
{
	header("Location: all.php");
}
elseif(isset($_POST['salvar']))
{
	if(isset($_POST['code'])) 
	{
		// $_POST['function'] = 'save';
		//$json = json_decode(sendPost($SERVER, $_POST),true);

		saveNote($_POST);
		echo '<html>
		    <head>
			<link href="style.css" type="text/css" rel="stylesheet">
			<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
			<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
			<meta http-equiv="refresh" content="1;url=notpad.php">
		   </head>
		   <body>
			    <div id="salvoTextCenter">SAVED</div></a>
		   </body>
		</html>';
	}
}
elseif(isset($_POST['sair']))
{
	saveNote($_POST);

	session_start();
	unset($_SESSION['user_id']);

	session_destroy();
	header("Location: .");
}
?>
