<?php
require_once("init.php");

if(isset($_COOKIE['authid']))
{
	$uid = validAuthId($_COOKIE['authid']);
	if($uid)
	{
		session_regenerate_id(true);
		$_SESSION['user_id'] = $uid;
	}
}

if(isset($_SESSION['user_id']))
{
	header("Location: me.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link href="style7.css" type="text/css" rel="stylesheet">
		<title>not is pad!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="erro.js"></script>
        <script type="text/javascript">
        </script>
    </head>
    <body>
		<!---Verificar navegador--->
		<div class="erro-navegador" id="erroNav">
			<div>
				This site is not optimized for your current browser. We recommend to use Google 
				Chrome for a better experience.
			</div>
		</div>
		<script>
			navigator.sayswho= (function(){
				var ua= navigator.userAgent, tem, 
				M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
				if(/trident/i.test(M[1])){
					tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
					return 'IE '+(tem[1] || '');
				}
				if(M[1]=== 'Chrome'){
					tem= ua.match(/\bOPR\/(\d+)/)
					if(tem!= null) return 'Opera '+tem[1];
				}
				M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
				if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
				return M.join(' ');
			})();

			var func = navigator.sayswho;
			var bF = func.split(' ');
			var bN = bF.shift();

			if(bN == "Safari" || bN == "Opera" || bN == "IE"){
				document.getElementById('erroNav').style.display="block";
			}else{
				document.getElementById('erroNav').style.display="none";
			}
		</script>
		
		<div class="erro">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Sorry, it seems that an unexpected error has occurred. Please, try again.
				</h2>
				<div id="voltar-pass-er-b">Back</div>
			</div>
		</div>
		
			<div id="openb">Learn more
				<div class="info-img-code">
					<div class="iic-p1"></div>
					<div class="iic-p2"></div>
				</div>
			</div>
			<div id="over" class="closed">
				<div id="closeb"><span class="og-close"></span></div>
				<div id="contentOver">
					<h1>Welcome to not is pad!</h1>
					<h2>Our goal</h2>
					<p>The idea behind not is pad! is to provide a quick and easy way to share
					content on the clouds with other people. With the not is pad!, you create a
					code for your note and share this code with your friends and colleagues. But
					don't worry, your original note can not be changed. If someone changes the
					content of the note, another "page" will be created and the initial content
					will remain unchanged.</p>
					<h2>Fast Notes</h2>
					<p>There are two ways to use the not is pad!. The first one is to create
					"Fast Notes". Fast Notes are a very good way to quickly share or registering
					an idea, a thought, or anything else. To create a new Fast Note, just choose
					a new access code and voila, your note is created automatically, just start
					writing. But keep in mind that Fast Notes can be accessed by anyone with the
					access code associated to this note. For this reason, if you don't want to
					share its content, keep the access code safe. It's also important to know
					that Fast Notes are available on our servers for only 7 (seven) days.</p>
					<h2>Create an account</h2>
					<p>Creating an account and choosing between one of our subscription plans,
					you will benefit from several advantages that will allow you to fully use our
					services. Besides having access to an exclusive area on our servers to store
					all your notes, you will have access to the Note Manager. This last allows
					you to organize and manage all your notes in addition to ensure you access
					to advanced options. If you are interested, click <a href="planos.php">here</a> and check out the best plan
					for you!</p>
					<br>
					<p>If you have any additional question or want to have more information on what
					we do, just send us an email at <a href="mailto:contact@notispad.com">contact@notispad.com</a>
					and we will be happy to talk with you.</p>
					<p>We hope to see you soon!</p>
					<p>Best,</p>
					<br>
					<p>The not is pad! team.</p>
					<br>
					<br>
				</div>
			</div>
			<div id="b01">
				<div class="user-img-code">
					<div class="uic-p1"></div>
					<div class="uic-p2"></div>
				</div>
				Log in
			</div>
			
			<div id="loginOver">
				<div id="topLog">
					Log in
					<div id="clos02">
					<span class="og-close" id="loginclose" style="top: 10px; left: 410px;"></span>
					</div>
				</div>
				<div id="formsLog">
					<form action="me.php" method="post">
						<input id="emailLog" autofocus="1" type="email" name="email" id="login_email" placeholder="Your email" required>
						<br>
						<input id="senhaLog" type="password" id="login_password" name="password" placeholder="Your password" required>
						<!--<div class="form-error" id="email-error2"></div>-->
						<div id="remember-me">
							<input type="checkbox" checked="True" id="remember_me" name="remember_me" tabindex="3">
							<label style="font-size: 15px; color: #8D9BA0; font-weight: 900;" for="remember_me">Keep me logged in</label>
						</div>
						<div class="form-error" id="email-error1">*Invalid email or wrong password!</div>
						<input name="login_submit" value="Log in" type="submit" id="loginSubmit">
						<div id="forgotPassword">
							<center style=" margin-top: 10px; ">
								<a href="forgot.php">Forgot password?</a>
							</center>
						</div>
						<center id="separaLogin">or</center>
						<center id="createSubmit"><a href="planos.php" style="padding: 15px;color: #fafafa; text-decoration: none;text-transform: uppercase;font-weight: 700;">Create an account</a></center>
					</form>
				</div>
			</div>
           
		   <div id="center" data-scrollreveal="enter bottom and move 200px over 1.3s">
				<div id="logo">
					<center><div id = "cloud"></div></center>
					<center><div class="logo-p2"></div></center>
					<div id="name">not is pad!</div>
				</div>
				<div>
					<form action="notpad.php" method="post">
						<input id="senha" placeholder="Type your Access Code" type="password" name="code">
					</form>
				</div>
				<div id="desc">
				"Enjoy the best of the cloud, make your notes anywhere at anytime."
				</div>
			</div>
			
			<script>
				var $div = $("#senha");
				//var $text = $("#desc");
				
				$($div).focus(function() {
					$('#desc').fadeOut( 100 , function(){
					   var div = $("<div id='desc'>Type a new access code or open a note that already exists.</div>").hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
					});
				});
				
				$($div).focusout(function(){
					$('#desc').fadeOut( 100 , function(){
					   var div = $("<div id='desc'>&quot;Enjoy the best of the cloud, make your notes anywhere at anytime.&quot;</div>").hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
					});
				});
				
				$( "#openb" ).click(function() {
				  $("#over").attr('class', 'open');
				  $("#center").attr('class', 'open');
				  $("#b01").attr('class', 'open');
				  $("body").css('overflow-y', 'visible');
				});
				$( "#closeb" ).click(function() {
				  $("#over").attr('class', 'closed');
				  $("#center").attr('class', 'closed');
				  $("#b01").attr('class', 'closed');
				  $("body").css('overflow-y', 'hidden');
				});
				
				$( "#b01" ).click(function() {
				  $("#loginOver").attr('class', 'open');
				  $("#center").attr('class', 'openSing');
				  $("#openb").attr('class', 'open');
				});
				$( "#clos02" ).click(function() {
				  $("#loginOver").attr('class', 'closed');
				  $("#center").attr('class', 'closedSing');
				  $("#openb").attr('class', 'closed');
				});
				
			</script>
<?php
	if(isset($_SESSION['error']))
	{
		echo '<script>$("#loginOver").attr("class", "open");$("#center").attr("class", "openSing");$("#openb").attr("class", "open");';
		echo $_SESSION['error'];
		unset($_SESSION['error']);
		echo "</script>";
	}
?>	
		<script src="scrollReveal.js"></script>
        </body>
</html>
