<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<link href="style.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="erro.js"></script>
    </head>
        <body id="conf" style="overflow: visible;">
		
		<div class="erro" style="margin-top: -20px;">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Sorry, it seems that an unexpected error has occurred. Please, try again.
				</h2>
				<div id="voltar-pass-er-b">Back</div>
			</div>
		</div>
		
			<div id="modalNome" class="hidden">
				<div id="boxNome">
					<span class="og-closeE"></span>
					<div class="popUpTxtConf">Type a new name</div>
					<center>
                        <form action="" method="post">
                            <input id="novoEmail" placeholder="" type="text" name="codigo" value="Jérémy">
							<div class="form-error-conf" id="name-error">Enter only one (01) name.</div>
							<br>
							<input id="valid" type="submit" onclick="" value="Save" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalEmail" class="hidden">
				<div id="boxEmail">
					<span class="og-closeE"></span>
					<div class="popUpTxtConf">Type a new email</div>
					<center>
                        <form action="" method="post">
                            <input id="novoEmail02" placeholder="" type="email" name="codigo" value="jeremynaka@hotmail.com">
							<div class="form-error-conf" id="email-error">Invalid email or incorrect password!</div>
							<br>
							<input id="valid" type="submit" onclick="" value="Save" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalSenha" class="hidden">
				<div id="boxSenha">
					<span class="og-closeE"></span>
					<center>
                        <form action="" method="post" style="margin-top: 20px;">
                            <input id="novaSenha-ant" placeholder="Current password" type="password" name="codigo">
							<div class="form-error-conf" id="pass-error" style="margin-bottom: 0px;">Incorrect password!</div>
							<input id="novaSenha" placeholder="New password" type="password" name="codigo">
							<div class="form-error-conf" id="pass-error02">Invalid password! Need to be at least 6 characters.</div>
							<br>
							<input id="valid" type="submit" onclick="" value="Save" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalCorFonte" class="hidden">
				<div id="boxCorFonte">
					<span class="og-closeE"></span>
					<div class="popUpTxtConfS">Select the font color</div>
					<div id="color-main">
						<div class="color-selector" style=" background: #000; "></div>
						<div class="color-selector" style=" background: #777; "></div>
						<div class="color-selector" style=" background: #ccc; "></div>
						<div class="color-selector" style=" background: #FFF; "></div>
						<div class="color-selector" style=" background: #771696; "></div>
						<div class="color-selector" style=" background: #A148BD; "></div>
						<div class="color-selector" style=" background: #C371DD; "></div>
						<div class="color-selector" style=" background: #DDA9EE; "></div>
						<div class="color-selector" style=" background: #227492; "></div>
						<div class="color-selector" style=" background: #48B1F7; "></div>
						<div class="color-selector" style=" background: #8DD7FA; "></div>
						<div class="color-selector" style=" background: #C5F1FF; "></div>
						<div class="color-selector" style=" background: #17A82F; "></div>
						<div class="color-selector" style=" background: #2CD347; "></div>
						<div class="color-selector" style=" background: #63F57B; "></div>
						<div class="color-selector" style=" background: #99F6A8; "></div>
						<div class="color-selector" style=" background: #FF8718; "></div>
						<div class="color-selector" style=" background: #FFAC18; "></div>
						<div class="color-selector" style=" background: #F7D757; "></div>
						<div class="color-selector" style=" background: #FFF46F; "></div>
						<div class="color-selector" style=" background: #DD0F0F; "></div>
						<div class="color-selector" style=" background: #F14B4B; "></div>
						<div class="color-selector" style=" background: #FF9494; "></div>
						<div class="color-selector" style=" background: #FFBBBB; "></div>
					</div>
				</div>
			</div>
			<div id="modalCorBg" class="hidden">
				<div id="boxCorBg">
					<span class="og-closeE"></span>
					<div class="popUpTxtConfS">Select the background color</div>
					<div id="color-main">
						<div class="color-selector" style=" background: #000; "></div>
						<div class="color-selector" style=" background: #777; "></div>
						<div class="color-selector" style=" background: #ccc; "></div>
						<div class="color-selector" style=" background: #FFF; "></div>
						<div class="color-selector" style=" background: #771696; "></div>
						<div class="color-selector" style=" background: #A148BD; "></div>
						<div class="color-selector" style=" background: #C371DD; "></div>
						<div class="color-selector" style=" background: #DDA9EE; "></div>
						<div class="color-selector" style=" background: #227492; "></div>
						<div class="color-selector" style=" background: #48B1F7; "></div>
						<div class="color-selector" style=" background: #8DD7FA; "></div>
						<div class="color-selector" style=" background: #C5F1FF; "></div>
						<div class="color-selector" style=" background: #17A82F; "></div>
						<div class="color-selector" style=" background: #2CD347; "></div>
						<div class="color-selector" style=" background: #63F57B; "></div>
						<div class="color-selector" style=" background: #99F6A8; "></div>
						<div class="color-selector" style=" background: #FF8718; "></div>
						<div class="color-selector" style=" background: #FFAC18; "></div>
						<div class="color-selector" style=" background: #F7D757; "></div>
						<div class="color-selector" style=" background: #FFF46F; "></div>
						<div class="color-selector" style=" background: #DD0F0F; "></div>
						<div class="color-selector" style=" background: #F14B4B; "></div>
						<div class="color-selector" style=" background: #FF9494; "></div>
						<div class="color-selector" style=" background: #FFBBBB; "></div>
					</div>
				</div>
			</div>
			<div id="modalTmFonte" class="hidden">
				<div id="tmFonte">
					<span class="og-closeE"></span>
					<div class="popUpTxtConfS">Select the font size</div>
					<h4>Small</h4>
					<h3 class="tamSelected">Normal</h3>
					<h2>Large</h2>
					<h1>Huge</h1>
				</div>
			</div>
			<div id="modalMudarPlano" class="hidden">
				<div id="novoPlano">
					<span class="og-closeE"></span>
					<div class="mudarPlanoTitle">Select a new plan</div>
					<div id="priceCards">
					
						<div id="card01m">
							<h2 class="plan-titleM" style=" background: #75C1DD; ">Basic</h2>
							<div class="plan-priceM">$2<span>/mo</span></div>
							<ul class="plan-featuresM">
								<li><strong>20</strong> notes per month</li>
								<li>Basic note manager</li>
								<br>
							</ul>
							<center><a href="#" class="plan-button">Choose</a></center>
						</div>
						<div class="separaM"></div>
						<div id="card02m" style="opacity: .4;">
							<h2 class="plan-titleM" style=" background: #5C99AF; ">Pro</h2>
							<div class="plan-priceM">$5<span>/mo</span></div>
							<ul class="plan-featuresM">
								<li><strong>100</strong> notes per month</li>
								<li>Basic note manager</li>
								<li>Personalisation options</li>
							</ul>
							<center><a href="#" class="plan-button select">Current plan</a></center>
						</div>
						<div class="separaM"></div>
						<div id="card03m">
							<h2 class="plan-titleM" style=" background: #56899C; ">Premium</h2>
							<div class="plan-priceM">$10<span>/mo</span></div>
							<ul class="plan-featuresM">
								<li><strong>500</strong> notes per month</li>
								<li>Advanced note manager</li>
								<li>Personalisation options</li>
							</ul>
							<center><a href="#" class="plan-button">Choose</a></center>
						</div>
				
					</div>
				</div>
			</div>
			<div id="modaldelConta" class="hidden">
				<div id="dellConta">
					<span class="og-closeD"></span>
					<h2>Attention!</h2>
					<h3>This action cannot be undone.</h3>
					<h3>Your account, with all your notes will be permanently deleted from our servers.</h3>
					<h4>Do you really want to delete your account?</h4>
					<center>
						<div id="delC-ok">Yes</div>
						<div id="delC-cancel">No</div>
					</center>
				</div>
			</div>
			<a href="me.php" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">Settings</h1>
			
			<div id="conf-mip" class="confOp" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Change Personal Informations</div>
				<p>Jérémy <span id="openNomePopup">EDIT NAME</span></p>
				<p>jeremynaka@hotmail.com <span id="openEmailPopup">EDIT EMAIL</span></p>
				<p>••••••••••••••••<span id="openSenhaPopup">CHANGE PASSWORD</span></p>
			</div>
			
			<div id="conf-odc" class="confOp" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Account options</div>
				<p>Current plan: <b>PRO ($5/mo)</b><span id="mudarPlanoB">CHANGE PLAN</span></p>
				<p>Delete your account <span id="confDel">DELETE</span></p>
			</div>
			
			<div id="conf-odp" class="confOp" style="margin-bottom: 55px;" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Personalization options</div>
				<p>Font color: <b>Black</b> <span id="colorChangeFont">CHANGE COLOR</span></p>
				<p>Background color: <b>White</b> <span id="colorChangeBg">CHANGE COLOR</span></p>
				<p>Font Size: <b>Normal</b><span id="tamFonteB">CHANGE SIZE</span></p>
			</div>
			
			<script src="scrollReveal.js"></script>
			<script>
				$( "#openNomePopup" ).click(function() {
				  $("#modalNome").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalNome").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
			
				$( "#openEmailPopup" ).click(function() {
				  $("#modalEmail").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalEmail").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				
				$( "#openSenhaPopup" ).click(function() {
				  $("#modalSenha").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalSenha").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				
				$( "#colorChangeFont" ).click(function() {
				  $("#modalCorFonte").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalCorFonte").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				
				$( "#colorChangeBg" ).click(function() {
				  $("#modalCorBg").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalCorBg").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				
				$( "#tamFonteB" ).click(function() {
				  $("#modalTmFonte").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalTmFonte").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				
				$( "#mudarPlanoB" ).click(function() {
				  $("#modalMudarPlano").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeE" ).click(function() {
				  $("#modalMudarPlano").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				
				$( "#confDel" ).click(function() {
				  $("#modaldelConta").attr('class', 'visible');
				  $("#openb2").css('opacity', '0');
				});
				$( ".og-closeD" ).click(function() {
				  $("#modaldelConta").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
				$( "#delC-cancel" ).click(function() {
				  $("#modaldelConta").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				});
			</script>
		</body>
</html>
