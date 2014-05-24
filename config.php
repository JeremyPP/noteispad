<?php
require_once("init.php");
require_once("functions.php");
session_start();

if(!isset($_SESSION['user_id']))
{
	header("Location: .");
}
elseif(isset($_GET['opt']) && $_GET['opt'])
{
	if($_GET['opt'] == 'd')
	{
		deleteUser($_SESSION['user_id']);
		header("Location: index.php");
	}
	else
	{
		updatePlan($_SESSION['user_id'], $_GET['opt']);
	}
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
<?php
	if(isset($_POST['codigo02']))
	{
		updateEmail($_SESSION['user_id'], $_POST['codigo02']);
	}

	$email = getEmail($_SESSION['user_id']);
                            echo "<input id='novoEmail02' placeholder='' type='email' name='codigo02' value='$email'>";
?>
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
                            <input id="novaSenha-ant" placeholder="Current password" type="password" name="codigo03">
<?php
	if(isset($_POST['codigo03']))
	{
		if(!validPassword($_SESSION['user_id'], $_POST['codigo03']))	
		{
			echo "<div class='form-error-conf' id='pass-error' style='margin-bottom: 0px;'>Incorrect password!</div>";
			echo "<script>alert('Invalid password');</script>";
		}
	}
?>
							<input id="novaSenha" placeholder="New password" type="password" name="codigo04">
<?php
	if((isset($_POST['codigo03']) && !isset($_POST['codigo04'])) || (isset($_POST['codigo04']) && strlen($_POST['codigo04']) < 6))
	{
			echo "<div class='form-error-conf' id='pass-error02'>Invalid password! Need to be at least 6 characters.</div>";
			//echo "<script>alert('Invalid password! Need to be at least 6 characters.');</script>";
	}
	elseif((isset($_POST['codigo03']) && validPassword($_SESSION['user_id'], $_POST['codigo03']))  && isset($_POST['codigo04']))
	{
		updatePassword($_SESSION['user_id'], $_POST['codigo04']);
	}
?>
			
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
			echo "<center><a href='config.php?opt=0' class='plan-button select'>Current plan</a></center>\n";
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
				<div class="confOp-title">Change Personal Informations</div>
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
		echo <<<EOT
			<div id="conf-odp" class="confOp" style="margin-bottom: 55px;" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Personalization options</div>
				<p>Font color: <b>Black</b> <span id="colorChangeFont">CHANGE COLOR</span></p>
				<p>Background color: <b>White</b> <span id="colorChangeBg">CHANGE COLOR</span></p>
				<p>Font Size: <b>Normal</b><span id="tamFonteB">CHANGE SIZE</span></p>
			</div>
EOT;
	}
?>
			
			<script src="scrollReveal.js"></script>
			<script>
				function setVal(ind)
				{
					$('#planno').val(ind);
				}
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
