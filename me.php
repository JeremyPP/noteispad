<?php
require_once("init.php");
require_once("functions.php");
require_once("PPfunctions.php");

session_start();

if(isset($_POST['planno']))
{
	// We're adding a new user
	if(checkUser($_POST['email']))
	{
		// User already exists
		$_SESSION['error'] = "erro14();";
	}
	else
	{
		$_SESSION['preauth_name'] = $_POST['name'];
		$_SESSION['preauth_password'] = $_POST['password'];
		$_SESSION['preauth_email'] = $_POST['email'];
		$_SESSION['preauth_planno'] = $_POST['planno'];
		if(isset($_POST['remember_me']))
		{
			$_SESSION['remember_me'] = 1;
		}

		// Paypal processing....
		// Set up payment authorisation
		list ($title, $price, $notes) = getPlan($_POST['planno']);
		$desc = "NotIsPad $title";

		$cancelUrl = 'http://pbembid.com:8888';
		$returnUrl = 'http://pbembid.com:8888/processpayment.php';

		$ret = SetExpressCheckout($desc, $cancelUrl, $returnUrl, $_POST['email'], $price);
		// Check that we're successful and call with token if we are
		if(isset($ret['ACK']) && ($ret['ACK'] == "SUCCESS"))
		{
			redirectToPayPal($ret['TOKEN']);
		}
		exit();
	}
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
		<title>Home - not is pad!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="erro.js"></script>
        <script type="text/javascript">
        </script>
    </head>
        <body>			
<?php
if(isset($_POST['email']))
{
	// Existing user logging in
	$uid = checkUser($_POST['email']);
	if(!$uid || !validPassword($uid, $_POST['password']))
	{
		$_SESSION['error'] =  "erro02();";
	}
	else
	{
		session_regenerate_id(true);
		$_SESSION['user_id'] = $uid;

		if(isset($_POST['remember_me']))
		{
			addAuthId($uid);
		}
	}
}
else
{
	// Check for authid cookie
	if(isset($_COOKIE['authid']))
	{
		$uid = validAuthId($_COOKIE['authid']);
		if($uid)
		{
			session_regenerate_id(true);
			$_SESSION['user_id'] = $uid;
		}
	}
}

if(isset($_SESSION['user_id']))
{
	$fname = getFirstName($_SESSION['user_id']);
	$email = getEmail($_SESSION['user_id']);
	echo "<div id='b01p'><div class='user-img-code'><div class='uic-p1'></div><div class='uic-p2'></div></div>$fname</div>";
	echo "<div id='dropDownProf'>";
	echo "<div class='userName'>$fname</div>";
	echo "<div class='userEmail'>$email</div>";
	$notes_used = getNotesUsed($_SESSION['user_id']);
	$note_max = getMaxNotes($_SESSION['user_id']);

	echo "<div class='userDataLeft'>$notes_used of $note_max notes created</div>";

	$pcnt_used = $notes_used / $note_max * 100;
	echo "<div class='quotaContainer'>";
	$pcnt_used = intval($pcnt_used);
	echo "<div style='width: $pcnt_used%;' class='quotaBar'></div>";
	echo "</div>";
}
else
{
	header("Location: index.php");
}
?>
				<a href="minhasnotas.php" class="nemuListProfLink">
					<div id="notasMmenu" class="nemuListProf">
						All my notes
					</div>
				</a>
				<a href="config.php" class="nemuListProfLink">
					<div id="confMmenu" class="nemuListProf">
						Settings
					</div>
				</a>
				<a href="../logoff.php" class="nemuListProfLink">
					<div id="logoffMenu" class="nemuListProf" style="margin-bottom: 17px;">
						Log out
					</div>
				</a>
				<div class="arrow-border"></div>
				<div class="bubble-arrow"></div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){  
					$("html").click(function(){ 
						$("#dropDownProf").hide(); 
					}); 
					$("#b01p").click(function(event){
						event.stopPropagation(); 
						$("#dropDownProf").show(); 
					});
				}); 
			</script>
		   <div id="center" data-scrollreveal="enter bottom and move 200px over 1.3s">
			
				<div id="logo">
					<center><div id = "cloud"></div></center>
					<center><div class="logo-p2"></div></center>
					<div id="name">not is pad!</div>
				</div>
				<div>
<?php
	$max_notes = getMaxNotes($_SESSION['user_id']);
	$used_notes = getNotesUsed($_SESSION['user_id']);

	if($used_notes == $max_notes)
	{
		$dest = 'more.php';
	}
	else
	{
		$dest = 'notpad.php';
	}
		
	echo "<form action='$dest' method='post'>";
?>
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
			</script>
		<script src="scrollReveal.js"></script>
        </body>
</html>
