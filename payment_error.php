<?php
require_once("functions.php");

clearAuthId($_SESSION['user_id']);

unset($_SESSION['user_id']);

session_destroy();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Payment error!</title>
<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<style>
body {
margin:0;
padding:0;
}
.erro {
visibility: hidden;
opacity: 0;
-webkit-transition: all 0.3s;
-moz-transition: all 0.3s;
transition: all 0.3s;
cursor: default;
background: #e74c3c;
height: 100%;
width: 100%;
position: absolute;
z-index: 999999;
}
.recovery-center {
top: 0;
bottom: 0;
right: 0;
left: 0;
position: absolute;
margin: auto;
max-width: 800px;
height: 700px;
}
.recovery-center h1 {
font-family: 'Open Sans', sans-serif;
color: #FFFFFF;
text-align: center;
font-size: 80px;
font-weight: 800;
margin-top: 30px;
}
.recovery-center h2 {
font-family: 'Open Sans', sans-serif;
color: #FFFFFF;
text-align: center;
font-size: 25px;
font-weight: 400;
margin-top: 30px;
padding-left: 30px;
padding-right: 30px;
}
#voltar-pass-er-b {
background: #c0392b;
color: #fff;
width: 300px;
height: 40px;
line-height: 40px;
text-align: center;
border-radius: 3px;
margin: 0 auto;
margin-top: 38px;
font-family: 'Open Sans', sans-serif;
font-weight: 900;
font-size: 18px;
cursor: pointer;
}
a{
text-decoration: none;
}
span{
font-weight: 800;
}
</style>
</head>
<body>
<div class="erro" style="visibility: visible; opacity: 1;">
	<div class="recovery-center">
		<h1>Ooops! :(</h1>
		<h2>
			It seems that an error has occurred with your PayPal account.<br><br>
Either you have canceled the payment manually on PayPal's website and you are trying to login on
notisdpad.com, or some internal error has occurred with PayPal and your payment hasn't been successful.<br><br>
Please fix the situation and try to log in again.<br><br>
If you keep seeing this error and you don't know why, contact us at <span>contact@notispad.com</span><br><br>
		</h2>
		<a href="index.php"><div id="voltar-pass-er-b">Go back to the home page</div></a>
	</div>
</div>
</body>
</html>
