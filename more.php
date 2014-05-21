<?php
require_once("init.php");
require_once("functions.php");
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<title>NOT is PAD!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    </head>
	<body class="moreNeP">
		<h1>Ooops! ;)</h1>
		<p id="morenoteText0">It seems that you have already used all your notes this month.</p>
<?php
	list ($d, $h, $m) = getTimeLeft($_SESSION['user_id']);
	$mn = getMaxNotes($_SESSION['user_id']);
	echo "<p>You will get $mn new ones in <b>$d</b> days <b>$h</b> hours and <b>$m</b> minutes...</p>";
	$_SESSION['code'] = $_POST['code'];
?>
		<p id="morenoteText01">Until then, all the notes you create will be treated like Fast Notes, and will only
			remain on our servers for 7 days. Also, you won't be able to see them in your note manager.</p>
		<p id="morenoteText02"><b>Do you like to upgrade your plan to get more notes?</b></p>
		<center>
			<a href="config.php"><div class="confMoreN">Yes, take me to my settings page</div></a>
			<a href="notpad.php"><div class="confMoreN" id="fastNConf">No, continue using Fast Notes</div></a>
		</center>
	</body>
</html>
