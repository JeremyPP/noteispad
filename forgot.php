<?php
require_once("init.php");

if(isset($_SESSION['user_id']))
{
	header("Location: 404.php");
	exit();
}
elseif(isset($_POST['email']))
{
	$uid = checkUser($_POST['email']);
	if($uid)
	{
		$key = generateKey();
		$subject = "Password reset";
		$text = "Hello from notispad\r\nA request has been made to reset your password\r\nIf you did not make this request then please ignore this email, otherwise go to this url and reset your password:\r\nhttp://notispad.selfip.com/reset.php?$key\r\nPlease note that this url is only valid for 24 hours and if you have any questions about this email then please contact us at info@notispad.com\r\n";
		mail($_POST['email'], $subject, $text, null, '-fdo-not-reply@notispad.com');
		updateReset($uid, $key);
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<title>Forgot password - not is pad!</title>
		<meta name="description" content="not is pad! is the simplest and fastest way to save and share your notes anywhere at anytime." >
		<meta name="keywords" content="notes, file sharing, cloud storage, online notes, sharing, cloud, backup, collaboration, remote access, notepad" >
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    </head>
        <body id="allNotes">
		<div id="recoverok">
			<div class="recovery-center">
				<h1>Thank you! :)</h1>
				<h2>
					A link to reset your password has been sent to your email.
				</h2>
				<a href="/index.php" style="text-decoration: none;"><div id="voltar-pass-b">Ok</div></a>
			</div>
		</div>
		<div id="recoverfail">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Sorry, it seems that an unexpected error has occurred. Please, try again.
				</h2>
				<a href="" style="text-decoration: none;"><div id="voltar-pass-er-b">Voltar</div></a>
			</div>
		</div>
		<a href="." style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
		<h1 data-scrollreveal="enter top and move -200px over 1s">Recover password</h1>
		<p style="margin-top: 40px; max-width: 750px;">If you are a registered user, a link to reset your password will be sent to your email address.</p>
		<form id="dadosUser" method="POST">
			<input type="email" name="email" placeholder="Your email" class="u-dI" autofocus required><br>
			<input type="submit" value="Send" class="recupPass">
		</form>
        <script src="scrollReveal.js"></script>
		<script>
			function ok(){
				$("#recoverok").show();
				return true;
			}
			function errorRP(){
				$("#recoverfail").show();
			}
		</script>
<?php
	if(isset($_POST['email']))
	{
		echo "<script>ok();</script>";
	}
?>
		</body>
</html>
