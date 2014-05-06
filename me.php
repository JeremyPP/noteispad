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
			<div id="b01p"><img src="user.png">Jeremy</div>
			
			<div id="dropDownProf">
				<div class="userName">Jeremy</div>
				<div class="userEmail">jimypougnet@gmail.com</div>
				<div class="userDataLeft">15 of 100 notes created</div>
				<div class="quotaContainer">
					<div style="width: 20%;" class="quotaBar"></div>
				</div>
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
				<a href="../notepad" class="nemuListProfLink">
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
					<form action="notpad.php" method="get">
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