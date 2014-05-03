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
		
		<div class="erro" style="margin-top: -20px;">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Sorry, it seems that an unexpected error has occurred. Please, try again.
				</h2>
				<div id="voltar-pass-er-b">Back</div>
			</div>
		</div>
		
		<div id="showmeOver">
			<div id="showme">
				<div id="closeOverPlan">
					<span class="og-close3"></span>
				</div>
				<div id="contOverPlan">
					<h1>Complete the information below</h1>
					<h2>You chose the PRO plan for $4.90 per month</h2>
					<form id="dadosUser" action="me.php">
						<input type="text" name="name" id="name-cc" placeholder="Your first name" class="u-dI" autofocus>
						<div class="form-error-conf" id="name-error" style="margin-top:-10px;margin-bottom:0px;">Type only one name.</div><br>
						<input type="email" name="email" id="email-cc" placeholder="Your email" class="u-dI">
						<div class="form-error-conf" id="email-error" style="margin-top:-10px;margin-bottom:0px;">This email already exist!</div>
						<div class="form-error-conf" id="email-error2" style="margin-top:-10px;margin-bottom:0px;">Email invalido!</div><br>
						<input type="password" name="password" id="pass-cc" placeholder="Your password" class="u-dI u-dI2">
						<div class="form-error-conf" id="pass-error" style="margin-top:-10px;margin-bottom:0px;">Invalid password. Minimum of 6 characters.</div>
						<div class="db-password-bubble db-left-arrow" style="width: 160px;position: absolute;display: none;margin-top: -115px;margin-left: 345px;">
						<div class="db-arrow-border"></div>
						<div class="db-arrow"></div>
						<div class="password-bubble-title"></div>
						<div class="password-bubble-desc">Good passwords are hard to guess. Use
							uncommon words or inside jokes, non-standard uPPercasing, creative
							spelllling, and non-obvious numbers and symbols.
						</div>
						</div>
						<br>
						<input type="submit" value="Proceed with billing" class="u-dS">
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
				<h3>It seems that we are still working on that. Please come back soon. :)</h3>
				<center>
					<img src="Preloader_3.gif"></img>
				</center>
			</div>
		</div>
		<a href="../noteispad" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">Choose your plan</h1>
			<div id="priceCards">
				<div id="card01" data-scrollreveal="enter bottom and move 200px over 1s">
					<h2 class="plan-title" style=" background: #F8F8F8; ">Basic</h2>
					<p class="plan-price">$2<span>/mo</span></p>
					<ul class="plan-features">
						<li><strong>20</strong> notes per month</li>
						<li>Basic note manager</li>
						<br>
					</ul>
					<center><a href="#" class="plan-button">Choose</a></center>
				</div>
				<div class="separa"></div>
				<div id="card02" data-scrollreveal="after .4s enter bottom and move 200px over 1s">
					<h2 class="plan-title" style=" background: #eee; ">Pro</h2>
					<p class="plan-price">$5<span>/mo</span></p>
					<ul class="plan-features">
						<li><strong>100</strong> notes per month</li>
						<li>Basic note manager</li>
						<li>Personalisation options</li>
					</ul>
					<center><a href="#" class="plan-button">Choose</a></center>
				</div>
				<div class="separa"></div>
				<div id="card03" data-scrollreveal="after .8s enter bottom and move 200px over 1s">
					<h2 class="plan-title" style=" background: #E0E0E0; ">Premium</h2>
					<p class="plan-price">$10<span>/mo</span></p>
					<ul class="plan-features">
						<li><strong>500</strong> notes per month</li>
						<li>Advanced note manager</li>
						<li>Personalisation options</li>
					</ul>
					<center><a href="#" class="plan-button2" id="wokinprog">Choose</a></center>
				</div>
				
			</div>
				<div id="duvidaPrice" data-scrollreveal="after 1.2s, ease-in 32px and reset over .66s">
					<p>Any doubt about which plan to choose? <span>Talk to us</span>!</p>
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
			
			//=== Erros ===
				$( ".erro" ).click(function() {
				  $(".erro").css('opacity', '0');
				  $(".erro").css('visibility', 'hidden');
				});
				
				function erro12(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
				function erro13(){
				  $("#name-cc").css('background', 'rgb(245, 212, 212)');
				  $("#name-cc").css('border', '1px solid #e74c3c');
				  $("#name-error").css('display', 'block');
				}
				function erro14(){
				  $("#email-cc").css('background', 'rgb(245, 212, 212)');
				  $("#email-cc").css('border', '1px solid #e74c3c');
				  $("#email-error").css('display', 'block');
				}
				function erro15(){
				  $("#email-cc").css('background', 'rgb(245, 212, 212)');
				  $("#email-cc").css('border', '1px solid #e74c3c');
				  $("#email-error2").css('display', 'block');
				}
				function erro16(){
				  $("#pass-cc").css('background', 'rgb(245, 212, 212)');
				  $("#pass-cc").css('border', '1px solid #e74c3c');
				  $("#pass-error").css('display', 'block');
				}
		</script>
		</body>
</html>