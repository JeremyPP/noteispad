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
        <body id="allNotes">
		<div id="recoverok">
			<div class="recovery-center">
				<h1>Thank you! :)</h1>
				<h2>
					A new default password has been sent to your email. <br>
					Don't forget to change it once logged by going to Settings > Change Password.
				</h2>
				<a href="/notepad" style="text-decoration: none;"><div id="voltar-pass-b">Ok</div></a>
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
		<a href="../notepad" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
		<h1 data-scrollreveal="enter top and move -200px over 1s">Recover password</h1>
		<p style="margin-top: 40px; max-width: 750px;">Once your identity verified, a new default password will be sent to your email. You will be able to change it once logged by going to "Settings".</p>
		<form id="dadosUser">
			<input type="email" name="email" placeholder="Your email" class="u-dI" autofocus><br>
			<div class="recupPass" onClick="ok()">Send</div>
		</form>
        <script src="scrollReveal.js"></script>
		<script>
			function ok(){
				$("#recoverok").show();
			}
			function errorRP(){
				$("#recoverfail").show();
			}
		</script>
		</body>
</html>