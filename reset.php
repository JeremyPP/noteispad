﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<title>Forgot password - not is pad!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<style>
			*{
				margin:0;
				padding:0;
			}
			body{
				background: #4caed3;
			}
			#pass_bg{
				position: fixed;
				width: 100%;
				height: 100%;
			}
			#pass{
				position: absolute;
				background: #eee;
				width: 400px;
				height: 200px;
				padding: 30px;
				top: 0;
				bottom: 0;
				right: 0;
				left: 0;
				margin: auto;
				border-radius: 5px;
				text-align: center;
				color: #949494;
				font-family: 'Open Sans', sans-serif;
				font-weight: 900;
				font-size: 22px;
				border-top: 5px solid rgb(85, 117, 160);
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}
			#pass p {
				max-width: 340px;
				margin: 0 auto;
			}
			#recoverfail, #recoverok {
				background: #e74c3c;
				height: 100%;
				width: 100%;
				position: absolute;
				z-index: 999;
				display: none;
			}
			#recoverok{
				background: #4CAED3;
			}
			.recovery-center {
				top: 0;
				bottom: 0;
				right: 0;
				left: 0;
				position: absolute;
				margin: auto;
				max-width: 800px;
				height: 400px;
			}
			.recovery-center h2 {
				font-family: 'Open Sans', sans-serif;
				color: #FFFFFF;
				text-align: center;
				font-size: 25px;
				font-weight: 800;
				margin-top: 30px;
				padding-left: 30px;
				padding-right: 30px;
			}
			#voltar-pass-er-b {
				background: #c0392b;
				width: 100px;
				height: 40px;
				line-height: 40px;
				text-align: center;
				border-radius: 3px;
				margin: 0 auto;
				margin-top: 38px;
				font-family: 'Open Sans', sans-serif;
				color: #fff;
				font-weight: 900;
				font-size: 18px;
				cursor: pointer;
			}
			#recoverfail h1, #recoverok h1 {
				font-family: 'Open Sans', sans-serif;
				color: #FFFFFF;
				text-align: center;
				font-size: 80px;
				font-weight: 800;
				margin-top: 30px;
			}
			
			#respass{
				width: 350px;
				height: 50px;
				border: none;
				background: #f9f9f9;
				padding-left: 10px;
				color: #3d464d;
				border-radius: 3px;
				outline: none;
				font-size: 18px;
				margin-top: 25px;
			}
			#respass:focus{
				background: #fff;
			}
			#submitpass{
				width: 140px;
				height: 40px;
				background: #75B0C7;
				color: #FFFFFF;
				border-radius: 3px;
				outline: none;
				font-size: 18px;
				margin-top: 25px;
				border: none;
				-webkit-transition: all 200ms ease-in-out;
				-moz-transition: all 200ms ease-in-out;
				-ms-transition: all 200ms ease-in-out;
				-o-transition: all 200ms ease-in-out;
				transition: all 200ms ease-in-out;
			}
			#submitpass:hover{
				background: #5D93A8;
				cursor: pointer;
			}
		</style>
    </head>
        <body>
		<div id="pass_bg">
			<div id="pass">
				<p>Please, type your new password below:</p>
				<input id="respass" autofocus="1" type="password" name="pass" placeholder="Your new password" required="">
				<input id="submitpass" type="submit" value="Reset" onclick="pass()"></input>
			</div>
		</div>
		<div id="recoverfail">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Sorry, it seems that this link has expired. Please try again.
				</h2>
				<a href="http://pbembid.com:8888/forgot.php" style="text-decoration: none;"><div id="voltar-pass-er-b">Ok</div></a>
			</div>
		</div>
		<div id="recoverok">
			<div class="recovery-center">
				<h1>Thank you! :)</h1>
				<h2>
					Your password have been successfully reset, from now on you can log in to your account with your new password.
				</h2>
			</div>
		</div>
		<script>
		function pass(){
			$("#recoverok").show();
		}
		function expir(){
			$("#recoverfail").show();
		}
		</script>
		</body>
</html>
