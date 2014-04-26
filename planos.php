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
        <body id="pagePrice">
		<div id="showmeOver">
			<div id="showme">
				<div id="closeOverPlan">
					<span class="og-close3"></span>
				</div>
				<div id="contOverPlan">
					<h1>Complete as informações abaixo</h1>
					<h2>Voce escolheu o plano PRO de R$9/mês.</h2>
					<form id="dadosUser" action="me.php">
						<input type="text" name="name" placeholder="Seu nome" class="u-dI" autofocus><br>
						<input type="email" name="email" placeholder="Seu email" class="u-dI"><br>
						<input type="password" name="password" placeholder="Uma senha" class="u-dI u-dI2">
						<div class="db-password-bubble db-left-arrow" style="width: 160px;position: absolute;display: none;margin-top: -115px;margin-left: 345px;">
						  <div class="db-arrow-border"></div>
						  <div class="db-arrow"></div>
						  <div class="password-bubble-title"></div>
						  <div class="password-bubble-desc">Boas senhas são difíceis de adivinhar. Use palavras incomuns, com maiúsculas escritas aleatoriamente, erros de ortografia criativos e com números e símbolos.</div>
						</div>
						<br>
						<input type="submit" value="Prosseguir com o pagamento" class="u-dS">
					</form>
				</div>
			</div>
		</div>
		<div id="work-in-prog-overlay">
			<div id="inprogPremium">
				<div id="closeOverPlan2">
						<span class="og-close3"></span>
				</div>
				
				<h2>Ooops!</h2>
				<h3>Pareçe que ainda estamos trabalhando nessa parte. Por favor, volte em breve. :)</h3>
				<center>
					<img src="Preloader_3.gif"></img>
				</center>
			</div>
		</div>
		<a href="../notepad" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Voltar</div></a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">Escolha o seu plano</h1>
			<div id="priceCards">
				<div id="card01" data-scrollreveal="enter bottom and move 200px over 1s">
					<h2 class="plan-title" style=" background: #F8F8F8; ">Basico</h2>
					<p class="plan-price">R$2<span>/mês</span></p>
					<ul class="plan-features">
						<li><strong>20</strong> notas por mês</li>
						<li>Gerenciador de notas basico</li>
						<br>
					</ul>
					<center><a href="#" class="plan-button">Selectionar</a></center>
				</div>
				<div class="separa"></div>
				<div id="card02" data-scrollreveal="after .4s enter bottom and move 200px over 1s">
					<h2 class="plan-title" style=" background: #eee; ">Pro</h2>
					<p class="plan-price">R$9<span>/mês</span></p>
					<ul class="plan-features">
						<li><strong>100</strong> notas por mês</li>
						<li>Gerenciador de notas basico</li>
						<li>Opções de perçonalização</li>
					</ul>
					<center><a href="#" class="plan-button">Selectionar</a></center>
				</div>
				<div class="separa"></div>
				<div id="card03" data-scrollreveal="after .8s enter bottom and move 200px over 1s">
					<h2 class="plan-title" style=" background: #E0E0E0; ">Premium</h2>
					<p class="plan-price">R$19<span>/mês</span></p>
					<ul class="plan-features">
						<li><strong>500</strong> notas por mês</li>
						<li>Gerenciador de notas avançado</li>
						<li>Opções de perçonalização</li>
					</ul>
					<center><a href="#" class="plan-button2" id="wokinprog">Selectionar</a></center>
				</div>
				
			</div>
				<div id="duvidaPrice" data-scrollreveal="after 1.2s, ease-in 32px and reset over .66s">
					<p>Alguma duvida sobre qual plano escolher? <span>Fale com a gente</span>!</p>
				</div>
        <script src="scrollReveal.js"></script>
		<script>
			$(".u-dI2").after("<div class='passwordInfo'><div class='passwordDot'></div><div class='passwordDot'></div><div class='passwordDot'></div><div class='passwordDot'></div></div>");
			$(".plan-button").click(function () {
				$("#showmeOver").fadeIn();
				$("#openb2").css({ opacity: 0 });
			});
			$("#closeOverPlan").click(function () {
				$("#showmeOver").fadeOut();
				$("#openb2").css({ opacity: 1 });
			});
			
			$(".plan-button2").click(function () {
				$("#work-in-prog-overlay").fadeIn();
				$("#openb2").css({ opacity: 0 });
			});
			$("#closeOverPlan2").click(function () {
				$("#work-in-prog-overlay").fadeOut();
				$("#openb2").css({ opacity: 1 });
			});
		</script>
		</body>
</html>