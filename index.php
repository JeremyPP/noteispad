<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link href="style7.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script type="text/javascript">
        </script>
    </head>
    <body>
	
		<!---Verificar navegador--->
		<div class="erro-navegador" id="erroNav">
			<div>
				Este site não esta otimizado para o seu navegador. Aconselhamos instalar o Google
				Chrome para uma melhor experiencia.
			</div>
		</div>
		<script>
		var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
            document.getElementById('erroNav').style.display="block";
        else
            document.getElementById('erroNav').style.display="none";
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
		
			<div id="openb">Learn more<img src="info.png"></div>
			<div id="over" class="closed">
				<div id="closeb"><span class="og-close"></span></div>
				<div id="contentOver">
					<h1>Welcome to NOT is PAD!</h1>
					<h2>Our goal</h2>
					<p>The idea behind NOT is PAD! is to provide a quick and easy way to share
					content on the clouds with others people. With the NOT is PAD!, you create a
					code for your note and share this code with your friend and/or colleagues.
					But do not worry, your original note can not be changed. If someone changes the
					content of the note, another "page" will be created and the initial content
					will be unchanged.</p>
					<h2>Fast Notes</h2>
					<p>There are two ways to use the NOT is PAD!. The first one is to create "Fast
					Notes". Fast Notes are an very good way to quickly share or registering an
					idea, a thought, or anything else. To create a new Fast Note, just choose a new
					access code and voila, your note is created automatically, just start writing.
					But keep in mind that Fast Notes can be accessed by anyone with the access code
					associated to this note. For this reason, if you don't want to share its
					content, keep the access code safe. It's also important to know that Fast Notes
					are availible on our servers for only seven (7) days.</p>
					<h2>Create an account</h2>
					<p>Creating an account and choosing between one of our subscription plans, you
					will benefit from several advantages that will allow you to fully use our
					services. Besides having access to an exclusive area on our servers to store
					all your notes, you will have access to the Note Manager. This last allows you
					to organize and manage all your notes in addition to ensure you access to
					advanced options. If you are interested, click <a href="planos.php">here</a> and check out the best plan
					for you!</p>
					<p>We hope to see you soon!</p>
					<p>Best,</p>
					<br>
					<p>The NOT is PAD! team.</p>
					<br>
					<br>
				</div>
			</div>
			<div id="b01"><img src="user.png">Log in</div>
			
			<div id="loginOver">
				<div id="topLog">
					Log in
					<div id="clos02">
					<span class="og-close" id="loginclose" style="top: 10px; left: 410px;"></span>
					</div>
				</div>
				<div id="formsLog">
					<form action="me.php" method="post">
						<input id="emailLog" autofocus="1" type="email" name="email" id="login_email" placeholder="Your email">
						<div class="form-error" id="email-error">Email invalid or nonexistent!</div>
						<br>
						<input id="senhaLog" type="password" id="login_password" name="password" placeholder="Your password">
						<div class="form-error" id="pass-error">Incorrect password!</div>
						<div id="remember-me">
							<input type="checkbox" checked="True" id="remember_me" name="remember_me" tabindex="3">
							<label style="font-size: 15px; color: #8D9BA0; font-weight: 900;" for="remember_me">Keep me logged in</label>
						</div>
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
				
				//=== Erros ===
				$( ".erro" ).click(function() {
				  $(".erro").css('opacity', '0');
				  $(".erro").css('visibility', 'hidden');
				});
				$( "#center" ).click(function() {
				  $("#center").css('background', '#333');
				   $("#center").css('color', '#ccc');
				});
				
				function erro01(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
				
				function erro02(){
				  $("#emailLog").css('background', 'rgb(245, 212, 212)');
				  $("#emailLog").css('border', '1px solid #e74c3c');
				  $("#email-error").css('display', 'block');
				}
				function erro03(){
				  $("#senhaLog").css('background', 'rgb(245, 212, 212)');
				  $("#senhaLog").css('border', '1px solid #e74c3c');
				  $("#pass-error").css('margin-top', '5px');
				  $("#pass-error").css('display', 'block');
				}
				function erro04(){
				  $("#center").css('background', '#F55B68');
				  $('#desc').fadeOut( 100 , function(){
					   var div = $('<div id="desc">The characters: \ / : * ? " < > |, cannot be used on the access code.</div>').hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
				  });
				  $("#center").css('color', '#ffffff');
				}
				
			</script>
		<script src="scrollReveal.js"></script>
        </body>
</html>
