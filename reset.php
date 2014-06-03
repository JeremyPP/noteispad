<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
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
				background: #4CAED3;
			}
			#title_main{
				font-family: 'Open Sans', sans-serif;
				color: #FFFFFF;
				text-align: center;
				font-size: 80px;
				font-weight: 800;
				padding-top: 100px;
				padding-bottom: 50px;
			}
			#desc{
				font-family: 'Open Sans', sans-serif;
				color: #FFFFFF;
				text-align: center;
				font-size: 25px;
				font-weight: 800;
				margin-top: -20px;
				padding-left: 30px;
				padding-right: 30px;
			}
			#buttom_conf{
				height: 50px;
				border: none;
				background: rgb(52, 128, 172);
				color: #eee;
				font-family: 'Open Sans', sans-serif;
				font-weight: 900;
				font-size: 22px;
				border-radius: 3px;
				margin-top: 70px;
				padding-left: 20px;
				padding-right: 20px;
				-webkit-transition: all 200ms ease-in-out;
				-moz-transition: all 200ms ease-in-out;
				-ms-transition: all 200ms ease-in-out;
				-o-transition: all 200ms ease-in-out;
				transition: all 200ms ease-in-out;
			}
			#buttom_conf:hover{
				background: #4C91BE;
				cursor:pointer;
			}
			#pass_bg{
				position: fixed;
				background: rgba(0, 0, 0, 0.7);
				width: 100%;
				height: 100%;
				display:none;
			}
			#pass{
				position: absolute;
				background: #fff;
				width: 400px;
				height: 100px;
				line-height: 100px;
				padding: 20px;
				top: 0;
				bottom: 0;
				right: 0;
				left: 0;
				margin: auto;
				border-radius: 3px;
				text-align: center;
				color: #4CAED3;
				font-family: 'Open Sans', sans-serif;
				font-weight: 900;
				font-size: 20px;
			}
			#pass span{
				color: rgb(52, 128, 172);
			}
			
			#recoverfail {
				background: #e74c3c;
				height: 100%;
				width: 100%;
				position: absolute;
				z-index: 999;
				display: none;
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
			#recoverfail h1 {
				font-family: 'Open Sans', sans-serif;
				color: #FFFFFF;
				text-align: center;
				font-size: 80px;
				font-weight: 800;
				margin-top: 30px;
			}
		</style>
    </head>
        <body>
		<div id="pass_bg">
			<div id="pass">Your new password is: <span>7c52DA9s</span></div>
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
		<h1 id="title_main">Hello Keith</h1>
		<p id="desc">Click on the button below to generate a new random password for your account.<br>
		Don't forget to change it once logged by going to Settings > Change Password.</p>
		<center>
			<input id="buttom_conf" type="button" value="Generate new password" onclick="pass()"></input>
		</center>
		<script>
		function pass(){
			$("#pass_bg").show();
			$("#title_main").hide();
			$("#desc").hide();
			$("#buttom_conf").hide();
		}
		function expir(){
			$("#recoverfail").show();
		}
		</script>
		</body>
</html>
