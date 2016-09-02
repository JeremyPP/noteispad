<?php
require_once("init.php");
require_once("PPfunctions.php");

if(!isset($_SESSION['user_id']))
{
	header("Location: .");
	exit();
}
elseif(isset($_GET['opt']) && $_GET['opt'])
{
	if($_GET['opt'] == 'd')
	{
		// Let the IPN script know that we're doing this cancellation
		// so it doesn't need to process it
		setCancelFlag($_SESSION['user_id']);
		cancelPayments($_SESSION['user_id']);
		deleteUser($_SESSION['user_id']);
		unset($_SESSION['user_id']);
		header("Location: index.php");
	}
	else
	{
		if(isActivePlan($_SESSION['user_id']))
		{
			updatePayments($_SESSION['user_id'], $_GET['opt']);
		}
		else
		{
			$alert_scr = 'alert("Error message here: Cannot change plan until PayPal processing is complete");';
		}
	}
}
elseif(isset($_SESSION['plan_change']))
{
	updatePlan($_SESSION['user_id'], $_SESSION['plan_change_plan']);
	unset($_SESSION['plan_change']);
	unset($_SESSION['plan_change_plan']);
}
elseif(isset($_GET['fc']) && $_GET['fc'])
{
	updateFontColour($_SESSION['user_id'], $_GET['fc']);
	$return['font_colour'] = getCurrentFontColourName($_SESSION['user_id']);
	echo json_encode($return);
	exit;
}
elseif(isset($_GET['bg']) && $_GET['bg'])
{
	updateBackgroundColour($_SESSION['user_id'], $_GET['bg']);
	$return['background_colour'] = getCurrentBackgroundColourName($_SESSION['user_id']);
	echo json_encode($return);
	exit;
}
elseif(isset($_GET['fs']) && $_GET['fs'])
{
	updateFontSize($_SESSION['user_id'], $_GET['fs']);
	$return['font_size'] = getCurrentFontSizeName($_SESSION['user_id']);
	echo json_encode($return);
	exit;
}
elseif(isset($_POST['pwCheck']))
{
	if($_POST['pwCheck'] == '')
	{
		$return['checkRes'] = false;
	}
	else
	{
		$return['checkRes'] = validPassword($_SESSION['user_id'], $_POST['pwCheck']);
	}

	echo json_encode($return);
	exit;
}
elseif(isset($_POST['emailCheck']))
{
	$return['checkRes'] = checkUser($_POST['emailCheck']);
	echo json_encode($return);
	exit;
}
elseif(isset($_POST['codigo04']))
{
	updatePassword($_SESSION['user_id'], $_POST['codigo04']);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<link href="style.css" type="text/css" rel="stylesheet">
		<title>Settings - not is pad!</title>
		<meta name="description" content="not is pad! is the simplest and fastest way to save and share your notes anywhere at anytime." >
		<meta name="keywords" content="notes, file sharing, cloud storage, online notes, sharing, cloud, backup, collaboration, remote access, notepad" >
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
                        <form id="nmForm" action="" method="post">
<?php
	if(isset($_POST['codigo01']))
	{
		updateFirstName($_SESSION['user_id'], $_POST['codigo01']);
	}

	$firstname = getFirstName($_SESSION['user_id']);
                            echo "<input id='novoEmail' placeholder='' type='text' name='codigo01' value='$firstname'>";
?>
							<div class="form-error-conf" id="name-error">Enter only one (01) name.</div>
							<br>
							<input id="valid" type="submit" value="Save" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalEmail" class="hidden">
				<div id="boxEmail">
					<span class="og-closeE"></span>
					<div class="popUpTxtConf">Type a new email</div>
					<center>
                        <form id="emailForm" action="" method="post">
<?php
	if(isset($_POST['codigo02']))
	{
		updateEmail($_SESSION['user_id'], $_POST['codigo02']);
	}

	$email = getEmail($_SESSION['user_id']);
                            echo "<input id='novoEmail02' onChange='emailChanged=1' placeholder='' type='email' name='codigo02' value='$email'>";
?>
							<div class="form-error-conf" id="email-error">Email already registered!</div>
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
                        <form action="" method="post" id="changePass" style="margin-top: 20px;">
                            <input id="novaSenha-ant" placeholder="Current password" type="password" name="codigo03">
			    <div class='form-error-conf' id='pass-error' style='margin-bottom: 0px;'>Incorrect password!</div>
			    <input id="novaSenha" placeholder="New password" type="password" name="codigo04" onChange="passChanged=1">
			    <div class='form-error-conf' id='pass-error02'>Invalid password! Needs to be at least 6 characters.</div>
			
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
<?php
	$fcscript = "";
	$colours = getColours();

	foreach($colours as &$k)
	{
		echo "<div id='fc$k' class='color-selector' style=' background: #$k'></div>";
		$fcscript .= "$('#fc$k').click(function(){ $.ajax({ type: 'get', url: 'config.php', data: { fc: '$k' }, dataType: 'json', success: function(data) { $('#fontColour').html(data.font_colour) } }); $('#modalCorFonte').attr('class', 'hidden'); $('#openb2').css('opacity', '1'); });\n";
	}
?>
					</div>
				</div>
			</div>
			<div id="modalCorBg" class="hidden">
				<div id="boxCorBg">
					<span class="og-closeE"></span>
					<div class="popUpTxtConfS">Select the background color</div>
					<div id="color-main">
<?php
	foreach($colours as &$k)
	{
		echo "<div id='bg$k' class='color-selector' style=' background: #$k'></div>";
		$fcscript .= "$('#bg$k').click(function(){ $.ajax({ type: 'get', url: 'config.php', data: { bg: '$k' }, dataType: 'json', success: function(data) { $('#backgroundColour').html(data.background_colour) } }); $('#modalCorBg').attr('class', 'hidden'); $('#openb2').css('opacity', '1'); });\n";
	}
?>

					</div>
				</div>
			</div>
			<div id="modalTmFonte" class="hidden">
				<div id="tmFonte">
					<span class="og-closeE"></span>
					<div class="popUpTxtConfS">Select the font size</div>
<?php
	$font_sizes = getFontSizes();
	$my_font_size = getCurrentFontSize($_SESSION['user_id']);
	foreach($font_sizes as $k => $v)
	{
		echo "<div id='fs$v' ";
		$style = '';
		//if($v == $my_font_size)
		//{
			//echo " class='tamSelected' ";
			//$style = 'color:#4caed3';
		//}
		echo "style='font-size:" . $v . "px;$style'>$k</div>";
		$fcscript .= "$('#fs$v').click(function(){ $.ajax({ type: 'get', url: 'config.php', data: { fs: '$v' }, dataType: 'json', success: function(data) { $('#fontSize').html(data.font_size); } }); $('#modalTmFonte').attr('class', 'hidden'); $('#openb2').css('opacity', '1'); });\n";
	}
?>
				</div>
			</div>
			<div id="modalMudarPlano" class="hidden">
				<div id="novoPlano">
					<span class="og-closeE"></span>
					<div class="mudarPlanoTitle">Select a new plan</div>
					<div id="priceCards">
<?php
	list ($pnum, $pn, $pp) = getUserPlan($_SESSION['user_id']);	
	$r = 117;
	$g = 193;
	$b = 221;
        for($i=1; $i!=4; $i++)
        {
                list ($title, $price, $notes) = getPlan($i);
		echo "<div id='card0" . $i . "m'";

		if($pnum == $i)
		{
			echo " style='opacity: .4;'";
		}
		echo ">\n";
		echo "<h2 class='plan-titleM' style=' background: rgb($r,$g,$b); '>$title</h2>\n";
		echo "<div class='plan-priceM'>\$$price<span>/mo</span></div>\n";
		echo "<ul class='plan-featuresM'>\n";
		echo "<li><strong>$notes</strong> notes per month</li>\n";
		if($i == 1)
		{
			echo "<li>Basic note manager</li>\n";
			echo "<br>\n";
		}
		elseif($i == 2)
		{
			echo "<li>Basic note manager</li>\n";
			echo "<li>Personalisation options</li>\n";
		}
		elseif($i == 3)
		{
			echo "<li>Advanced note manager</li>\n";
			echo "<li>Personalisation options</li>\n";
		}

		echo "</ul>\n";

		if($pnum == $i)
		{
			echo "<center><span class='plan-button select'>Current plan</span></center>\n";
		}
		elseif($i == 3)
		{
			echo "<center><span class='plan-button prem-plan'>Choose</span></center>\n";
		}
		else
		{
			echo "<center><a href='config.php?opt=$i' onClick='setVal($i)' class='plan-button'>Choose</a></center>\n";
		}

		echo "</div>\n";
		if($i < 3)
		{
			echo "<div class='separaM'></div>\n";
		}

		$r -= 12;
		$g -= 20;
		$b -= 23;
	}
?>
			</div>
			</div>
			</div>
		       <div id="work-in-prog-overlay">
				<div id="inprogPremium">
					<div id="closeOverPlan">
							<span class="og-close3"></span>
					</div>

					<h2>Ooops!</h2>
					<h3>It seems that we are still working on that. Please come back soon. :)</h3>
					<center>
						<img src="Preloader_3.gif"></img>
					</center>
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
						<a href='config.php?opt=d'><div id="delC-ok">Yes</div></a>
						<a href='config.php'><div id="delC-cancel">No</div></a>
					</center>
				</div>
			</div>
			<a href="me.php" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">Settings</h1>
			
			<div id="conf-mip" class="confOp" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Change Personal Information</div>
<?php
				echo "<p>$firstname <span id='openNomePopup'>EDIT NAME</span></p>";
				echo "<p>$email <span id='openEmailPopup'>EDIT EMAIL</span></p>";
?>
				<p>••••••••••••••••<span id="openSenhaPopup">CHANGE PASSWORD</span></p>
			</div>
			
			<div id="conf-odc" class="confOp" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Account options</div>
<?php
	list ($pnum, $pn, $pp) = getUserPlan($_SESSION['user_id']);	
				echo "<p>Current plan: <b>$pn (\$$pp/mo)</b><span id='mudarPlanoB'>CHANGE PLAN</span></p>";
?>
				<p>Delete your account <span id="confDel">DELETE</span></p>
			</div>
			
<?php
	if($pnum > 1)
	{
		$fc = getCurrentFontColourName($_SESSION['user_id']);
		$bg = getCurrentBackgroundColourName($_SESSION['user_id']);
		$fs = getCurrentFontSizeName($_SESSION['user_id']);
		echo <<<EOT
			<div id="conf-odp" class="confOp" style="margin-bottom: 55px;" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Personalization options</div>
				<p>Font color: <b id="fontColour">$fc</b> <span id="colorChangeFont">CHANGE COLOR</span></p>
				<p>Background color: <b id="backgroundColour">$bg</b> <span id="colorChangeBg">CHANGE COLOR</span></p>
				<p>Font Size: <b id="fontSize">$fs</b><span id="tamFonteB">CHANGE SIZE</span></p>
			</div>
EOT;
	}

	echo "<script>$fcscript</script>\n";
?>
<?php
	if(isset($alert_scr))
	{
		echo "<script>$alert_scr</script>\n";
	}
?>
			
			<script src="scrollReveal.js"></script>
			<script>
				var passChanged = 0;
				var emailChanged = 0;

				function setVal(ind)
				{
					$('#planno').val(ind);
				}
				$(document).ready(function()
				{
					$('#emailForm').submit(function(e)
					{
						var retval = true;
						if(emailChanged)
						{
							$.ajax({ type : 'post',
								url: 'config.php',
								dataType: 'json',
								data: {emailCheck: $('#novoEmail02').val() },
								async: false,
								success: function(d)
								{
									if(d.checkRes)
									{
										erro08();
										retval = false;
									}
								}
							});
						}

						return retval;
					});

					$('#nmForm').submit(function(e)
					{
						var retval = true;
						if(/\s/.test($("#novoEmail").val()) || ($("#novoEmail").val() === ""))
						{
							erro07();
							retval = false;
						}
						return retval;
					});

					$("#changePass").submit(function(e)
					{
						var retval = true;
						$.ajax({ type : 'post',
							url: 'config.php',
							dataType: 'json',
							data: {pwCheck: $('#novaSenha-ant').val() },
							async: false,
							success: function(d)
							{
								if(!d.checkRes)
								{
									erro09();
									retval = false;
								}
							}
						});

						if(!passChanged || ($('#novaSenha').val().length < 6))
						{
							erro10();
							retval = false;
						}

						return retval;
					});
				});
				$(".prem-plan").click(function()
				{
					$("#work-in-prog-overlay").fadeIn();
					$("#modalMudarPlano").css({ opacity: 0 });
				});
				$("#closeOverPlan").click(function()
				{
					$("#work-in-prog-overlay").fadeOut();
					$("#modalMudarPlano").css({ opacity: 1 });
				});
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
				function closeFC(fc)
				{
				  $.ajax({
					type: "get",
					dataType: "json",
					url: "config.php",
					data: { fc: fc }
					});
					
				  $("#modalCorFonte").attr('class', 'hidden');
				  $("#openb2").css('opacity', '1');
				}
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
				  setSelected();
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
				function setSelected()
				{
					var currFS = $('#fontSize').html();
					$('#tmFonte').children('div').each(function ()
					{
						if($(this).html() == currFS)
						{
							$(this).toggleClass('tamSelected');
							$(this).css('color', '#4caed3');
						}
						else if($(this).hasClass('tamSelected'))
						{
							$(this).toggleClass('tamSelected');
							$(this).css('color', '');
						}
					});
				}
			</script>
		</body>
</html>
