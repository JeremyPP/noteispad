<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link href="style7.css" type="text/css" rel="stylesheet">
		<title>notispad</title>
		<meta name="description" content="notispad is the simplest and fastest way to save and share your notes anywhere at anytime." >
		<meta name="keywords" content="notes, file sharing, cloud storage, online notes, sharing, cloud, backup, collaboration, remote access, notepad" >
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="erro.js"></script>

    </head>
    <body>
		<!--- Check client browser --->
		<div class="erro-navegador" id="erroNav">
			<div>
				This site is not optimized for your current browser. We recommend to use Google 
				Chrome for a better experience.
			</div>
		</div>
	
		
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
					<h1>Welcome to notispad!</h1>
					<h2>Our goal</h2>
					<p>The idea behind notispad is to provide a quick and easy way to save and
					share content in the clouds with other people. With notispad, you create an
					access code for your note that, if you wish, you can share with your friends
					and colleagues. But don't worry, your original note can not be changed. If
					someone changes the content of the note, another "page" will be created and
					the initial content will remain unchanged.</p>
					<h2>Fast Notes</h2>
					<p>There are two ways to use notispad. The first one is to create "Fast
					Notes". Fast Notes are a very good way to quickly share or save an idea, a
					thought, or anything else. To create a new Fast Note, just choose a new access
					code and voila, your note is created automatically. But keep in mind that Fast
					Notes can be accessed by anyone with the access code associated with it. For
					this reason, if you don't want to share its content, keep the access code safe.
					It's also important to know that Fast Notes are available on our servers for
					only 7 (seven) days.</p>
					<h2>Create an account</h2>
					<p>Creating an account and choosing between one of our subscription plans you
					will benefit from several advantages that will allow you to fully use our
					services. Besides having access to an exclusive area on our servers to store
					all your notes, you will have access to the Note Manager. This last one allows
					you to organize and manage all your notes in one place. And the most important,
					your notes will never be deleted and their content will never be lost. If you
					are interested, click <a href="signup.php">here</a> and check out the best plan
					for you!</p>
					<br>
					<p>If you have any additional question or want to have more information on what
					we do, just send us an email at <a href="mailto:contact@notispad.com">contact@notispad.com</a>
					and we will be happy to talk with you.</p>
					<p>We hope to see you soon!</p>
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
						<center id="createSubmit"><a href="signup.php" style="padding: 15px;color: #fafafa; text-decoration: none;text-transform: uppercase;font-weight: 700;">Create an account</a></center>
					</form>
				</div>
			</div>
           
		   <div id="center" data-scrollreveal="enter bottom and move 200px over 1.3s">
				<div id="logo">
					<center><div id = "cloud"></div></center>
					<center><div class="logo-p2"></div></center>
					<div id="name">not.is.pad</div>
				</div>
				<div>
					<form action="notpad.php" method="post">
						<input id="senha" placeholder=" Access Code" type="password" name="code">
					</form>
				</div>
				<div id="desct">
				Create a new note by typing a new Access Code, or open a note that already exist typing the correct Access Code above.
				</div>
			</div>
			
			<script>
				/*var $div = $("#senha");
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
				});*/
				
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
		</script>
		<script src="scrollReveal.js"></script>
        </body>
</html>