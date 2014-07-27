<?php
	// Change this to the path on your server
	$file = '/home/www/notispad.development/admin_output/emails.txt';

	if(isset($_POST['ine']))
	{
		file_put_contents($file, $_POST['ine'] . "\n", FILE_APPEND | LOCK_EX);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html><head><title>not is pad!</title>
<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
<style>
body{background: url("bg.jpg");padding: 0;margin: 0;}#l{position: absolute;width: 540px;height: 479px;margin: auto;top: 0;bottom: 0;left: 0;right: 0;padding-top: 28px;z-index: 99;}#c{width:210px;height:75px;background:#f2f9fe;background:linear-gradient(top,#f2f9fe 5%,#d6f0fd 100%);background:-webkit-linear-gradient(top,#f2f9fe 5%,#d6f0fd 100%);background:-moz-linear-gradient(top,#f2f9fe 5%,#d6f0fd 100%);background:-ms-linear-gradient(top,#f2f9fe 5%,#d6f0fd 100%);background:-o-linear-gradient(top,#f2f9fe 5%,#d6f0fd 100%);border-radius:100px;-webkit-border-radius:100px;-moz-border-radius:100px;position:relative}#c:after,#c:before{content:'';position:absolute;background:#f2f9fe;z-index:-1}#c:before{width:100px;height:100px;top:-50px;right:35px;border-radius:200px;-webkit-border-radius:200px;-moz-border-radius:200px}#c:after{width:70px;height:70px;top:-30px;left:35px;border-radius:100px;-webkit-border-radius:100px;-moz-border-radius:100px}.u{background:0 0;height:45px;width:35px;border-top-left-radius:50%;border-top-right-radius:50%;border:11px solid #4CAED3;border-bottom:none;position:relative;top:-80px}#n{letter-spacing: 1;color: #fff;font-family: 'Open Sans', sans-serif;font-size: 40px;text-align: center;margin-top: -50px;}#mc{width: 100%;height: 299px;font-family: 'Open Sans', sans-serif;background: #4CAED3;padding-bottom: 50px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;margin-top: -20px;}h1{padding: 30px;text-align: center;color: #FFFFFF;font-size: 28px;padding-top: 30px;padding-bottom: 35px;-webkit-border-top-left-radius: 3px;-webkit-border-top-right-radius: 3px;-moz-border-radius-topleft: 3px;-moz-border-radius-topright: 3px;border-top-left-radius: 3px;border-top-right-radius: 3px;height: 99px;font-weight: 400;}#ine{width: 440px;background: #fff;border: none;margin-top: -16px;height: 65px;padding-left: 30px;font-size: 22px;-webkit-border-radius: 50px;-moz-border-radius: 50px;border-radius: 50px;}#ins{width: 470px;background: rgb(255, 0, 41);color: #fff;height: 65px;border: none;font-size: 25px;word-spacing: 2px;letter-spacing: 1;border-radius: 50px;margin-top: 15px;cursor: pointer;-webkit-transition: background 500ms ease;-moz-transition: background 500ms ease;-ms-transition: background 500ms ease;-o-transition: background 500ms ease;transition: background 500ms ease;}#ins:hover{background: #CA3CD6;}#ovrl{background: rgba(0, 0, 0, 0.5);width: 100%;height: 100%;}
</style>
</head><body><div id="ovrl"></div><div id="l">
<center><div id="c"></div></center><center><div class="u"></div></center>
<div id="mc"><h1>A new way to manage and share your notes in the cloud is coming. Stay tuned!</h1>
<center><form method='post'><input name="ine" id="ine" type="email" placeholder="My email" required></input>
<input id="ins" type="submit" value="Let me know when is out!"></input>
</form></center></div></div></body></html>
