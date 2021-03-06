﻿<?php
require_once("init.php");

if(isset($_SESSION['user_id']))
{
	header("Location: 404.php");
	exit();
}
elseif(isset($_GET['email']) && !isset($_GET['password']))
{
	// ajax call
	$return['emailInUse'] = checkUser($_GET['email']);
	echo json_encode($return);
	exit;
}
elseif(isset($_GET['password']))
{
	// Return encrypted password to ajax call
	$enc_passwd = encryptPassword($_GET['password']);
	$return['ticket'] = createNewTicket($_GET['name'], $_GET['email'], $_GET['planno'], $enc_passwd);
	echo json_encode($return);
	exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<title>Plans - notispad</title>
		<meta name="description" content="not is pad! is the simplest and fastest way to save and share your notes anywhere at anytime." >
		<meta name="keywords" content="notes, file sharing, cloud storage, online notes, sharing, cloud, backup, collaboration, remote access, notepad" >
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="erro.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-54091012-1', 'auto');
		  ga('send', 'pageview');
		</script>
    </head>
        <body id="pagePrice">
		
		<script>
			var planName = new Array("Unknown");
			var planPrice = new Array("Unknown");

			function addPlan(ind, name, price)
			{
				planName[ind] = name;
				planPrice[ind] = price;
			}
		</script>

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
					<h1>Sign up</h1>
					<h2>You chose the <span id="pname">PRO</span> plan for <span>$</span><span id="pprice">0</span> per month.</h2>
					<h3>Please fill in the information below to create your account:</h3>
<?php
	if(isSandbox())
	{
		$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}
	else
	{
		$url = "https://www.paypal.com/cgi-bin/webscr";
	}

	echo "<form name='dadosUser' id='dadosUser' method='post' action='$url'>";
?>

						<input type="hidden" id="planno" name="planno" value="">
						<input type="hidden" name="cmd" value="_xclick-subscriptions">
						<input type="hidden" name="business" value="notispad@gmail.com">
						<input type="hidden" id="item_name" name="item_name" value="">
						<input type="hidden" id="a3" name="a3" value="">
						<input type="hidden" name="p3" value="1">
						<input type="hidden" name="t3" value="M">
						<input type="hidden" name="src" value="1">
						<input type="hidden" name="no_shipping" value="1">
						<input type="hidden" id="custom" name="custom" value="">
						<input type="text" name="name" id="name-cc" placeholder="Your first name" class="u-dI" onChange="nameChanged = 1;" autofocus required>
						<div class="form-error-conf" id="name-error" style="margin-top:-10px;margin-bottom:0px;">Please supply one name</div><br>
						<input type="text" name="email" id="email-cc" placeholder="Your email" class="u-dI" onChange="emailChanged=1;" required>
						<div class="form-error-conf" id="email-error" style="margin-top:-10px;margin-bottom:0px;">This email address is already registered!</div>
						<div class="form-error-conf" id="email-error2" style="margin-top:-10px;margin-bottom:0px;">Invalid email!</div><br>
						<input type="password" name="password" id="pass-cc" placeholder="Your password" class="u-dI u-dI2" onChange="passChanged=1;" required>
						<div class="form-error-conf" id="pass-error" style="margin-top:-10px;margin-bottom:0px;">Invalid password. Minimum of 6 characters.</div>
						<div class="db-password-bubble db-left-arrow" style="width: 160px;position: absolute;display: none;margin-top: -123px;margin-left: 345px;">
						<div class="db-arrow-border"></div>
						<div class="db-arrow"></div>
						<div class="password-bubble-title"></div>
						<div class="password-bubble-desc">Good passwords are hard to guess. Use
							uncommon words, with lower and uppercase characters, and non-obvious
							numbers and symbols. The minimum password length is six characters
						</div>
						</div>
						<br>
						<input type="submit" value="Proceed with billing" class="u-dS" style="margin-top:20px;border-radius:25px;height:50px;">
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
		<a href="../index.php" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
			<h1 id="titleplanpage" data-scrollreveal="enter top and move -200px over 1s">Choose your plan</h1>
			<div id="priceCards">
<?php
	echo "\n<script>\n";
	for($i=1; $i!=4; $i++)
	{
		list ($title[$i], $price[$i], $notes[$i]) = getPlan($i);

		echo "addPlan($i, '$title[$i]', $price[$i]);";
		echo 'planName[' . $i .'] = "' . $title[$i] . '";';
		echo 'planPrice[' . $i . '] = "' . $price[$i] . '";';
	}
	echo "\n</script>\n";
?>
				<div id="card01" data-scrollreveal="enter bottom and move 200px over 1s">
<?php	
					echo "<h2 class='plan-title' style=' background: #F8F8F8; '>$title[1]</h2>";
					echo "<p class='plan-price'>\$$price[1]<span>/mo</span></p>";
?>
					<ul class="plan-features">
<?php
						echo "<li><strong>$notes[1]</strong> notes per month</li>";
?>
						<li>Basic note manager</li>
						<br>
					</ul>
					<center><a href="#" onClick="setVal(1)" class="plan-button">Choose</a></center>
				</div>
				<div class="separa"></div>

				<div id="card02" data-scrollreveal="after .4s enter bottom and move 200px over 1s">
<?php
					echo "<h2 class='plan-title' style=' background: #eee; '>$title[2]</h2>";
					echo "<p class='plan-price'>\$$price[2]<span>/mo</span></p>";
?>
					<ul class="plan-features">
<?php
						echo "<li><strong>$notes[2]</strong> notes per month</li>";
?>
						<li>Basic note manager</li>
						<li>Personalisation options</li>
					</ul>
					<center><a href="#" onClick="setVal(2)" class="plan-button">Choose</a></center>
				</div>
				<div class="separa"></div>

				<div id="card03" data-scrollreveal="after .8s enter bottom and move 200px over 1s">
<?php
					echo "<h2 class='plan-title' style=' background: #E0E0E0; '>$title[3]</h2>";
					echo "<p class='plan-price'>\$$price[3]<span>/mo</span></p>";
?>
					<ul class="plan-features">
<?php
						echo "<li><strong>$notes[3]</strong> notes per month</li>";
?>
						<li>Advanced note manager</li>
						<li>Personalisation options</li>
					</ul>
					<center><a href="#" onClick="setVal(3)" class="plan-button2" id="wokinprog">Choose</a></center>
				</div>
				
			</div>
				<div id="duvidaPrice" data-scrollreveal="after 1.2s, ease-in 32px and reset over .66s">
					<p>Any doubt about which plan to choose? <span><a href="mailto:contact@notispad.com">We can help you!</a></span></p>
				</div>
        <script src="scrollReveal.js"></script>
		<script>
			var nameChanged = 0;
			var emailChanged = 0;
			var passChanged = 0;

			function setVal(ind)
			{
				$("#pname").text(planName[ind]);
				$("#pprice").text(planPrice[ind]);
				$("#planno").val(ind);
				$('#item_name').val('notispad ' + planName[ind]);
				$('#a3').val(planPrice[ind]);
			}

			$(".u-dI2").after("<div class='passwordInfo'><div class='passwordDot'>?</div></div>");
			
			$(".plan-button").click(function () {
				$("#showmeOver").fadeIn();
				$("#openb2").css({ opacity: 0 });
				$("#titleplanpage").css({ opacity: 0 });
			});
			$("#closeOverPlan").click(function () {
				$("#showmeOver").fadeOut();
				$("#openb2").css({ opacity: 1 });
				$("#titleplanpage").css({ opacity: 1 });
			});
			
			$(".plan-button2").click(function () {
				$("#work-in-prog-overlay").fadeIn();
				$("#openb2").css({ opacity: 0 });
			});
			$("#closeOverPlan2").click(function () {
				$("#work-in-prog-overlay").fadeOut();
				$("#openb2").css({ opacity: 1 });
			});

			$(document).ready(function()
			{
				$('#dadosUser').submit(function(event)
				{
					var retval = true;

					$("#name-error").fadeOut();
					$("#name-error").css({opacity: 1});

					if(!nameChanged || /\s/.test($("#name-cc").val()) || ($("#name-cc").val() === ""))
					{
						$("#name-error").fadeIn();
						$("#name-error").css({opacity: 0});
						retval = false;
					}

					$("#email-error").fadeOut();
					$("#email-error").css({opacity: 1});

					$("#email-error2").fadeOut();
					$("#email-error2").css({opacity: 1});

					if(!emailChanged || !validateEmail($("#email-cc").val()))
					{
						$("#email-error2").fadeIn();
						$("#email-error2").css({opacity: 0});
						retval = false;
					}
					else
					{
						$.ajax({ type: "get", 
							url: "signup.php", 
							dataType: "json", 
							data: {email: $("#email-cc").val() }, 
							async: false,
							success: function(data)
								{
									if(data.emailInUse)
									{
										$("#email-error").fadeIn();
										$("#email-error").css({opacity: 0});
										retval = false;
									}
								}
							});
					}

					$("#pass-error").fadeOut();
					$("#pass-error").css({opacity: 1});

					if(!passChanged || ($("#pass-cc").val().length < 5))
					{
						$("#pass-error").fadeIn();
						$("#pass-error").css({opacity: 0});
						retval = false;
					}

					if(retval)
					{
						var ticket = '';

						$.ajax({ type: "get", 
							url: "signup.php", 
							dataType: "json", 
							data: {name : $("#name-cc").val(), 
								password : $("#pass-cc").val(),
								email : $("#email-cc").val(),
								planno : $("#planno").val() }, 
							async: false,
							success: function(data)
								{
									ticket = data.ticket;
								}
							});
						$("#custom").val(ticket);
					}

					return retval;
				});
			});

			function validateEmail(email_addr)
			{
				var retval;
				var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				if(filter.test(email_addr))
				{
					retval = true;
				}
				else
				{
					retval = false;
				}

				return retval;
			}
			
		</script>
		</body>
</html>
