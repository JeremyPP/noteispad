<<<<<<< HEAD
﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
=======
﻿<?php
    require_once('init.php');
    require_once('functions.php');
    
    if (!logado()) {
        redirect(".");
    }
    
    $userInfo = getUserInfo($_SESSION['email'], $_SESSION['tolken']);
    
    if (!$userInfo) {
        redirect(".");    
    }
    
    $name = $userInfo['name']['first'];
    $email = s('email');
    
    $planInfo = getPlanInfo($userInfo['plan']['type']);
    
    if (!$planInfo) {
        redirect(".");    
    }
    
    $notas = array("atual" => $userInfo['notes'], "total" => $planInfo['notes']);
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
>>>>>>> 9953c711791c1e840f84d5ea26a04e09f6a2d211
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
<<<<<<< HEAD
			<div id="b01p"><img src="user.png">Jeremy</div>
			
			<div id="dropDownProf">
				<div class="userName">Jeremy</div>
				<div class="userEmail">jimypougnet@gmail.com</div>
				<div class="userDataLeft">15 de 100 notas criadas</div>
				<div class="quotaContainer">
					<div style="width: 20%;" class="quotaBar"></div>
=======
			<div id="b01p"><img src="user.png"><?php echo $name; ?></div>
			
			<div id="dropDownProf">
				<div class="userName"><?php echo $name; ?></div>
				<div class="userEmail"><?php echo $email; ?></div>
				<div class="userDataLeft"><?php echo $notas['atual']." de ".$notas['total']." notas criadas"; ?></div>
				<div class="quotaContainer">
					<div style="width: <?php echo $notas['atual']*100/$notas['total']; ?>%;" class="quotaBar"></div>
>>>>>>> 9953c711791c1e840f84d5ea26a04e09f6a2d211
				</div>
				<a href="minhasnotas.php" class="nemuListProfLink">
					<div id="notasMmenu" class="nemuListProf">
						Ver minhas notas
					</div>
				</a>
				<a href="config.php" class="nemuListProfLink">
					<div id="confMmenu" class="nemuListProf">
						Configurações
					</div>
				</a>
				<a href="command.php?sair=true" class="nemuListProfLink">
					<div id="logoffMenu" class="nemuListProf" style="margin-bottom: 17px;">
						Deslogar-se
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
						<input id="senha" placeholder="Digite seu Código" type="password" name="code">
					</form>
				</div>
				<div id="desc">
				"Aproveite o melhor da núvem, faça suas anotações e use onde quiser."
				</div>
			</div>
			<script>
				var $div = $("#senha");
				//var $text = $("#desc");
				
				$($div).focus(function() {
					$('#desc').fadeOut( 100 , function(){
					   var div = $("<div id='desc'>Crie um código para fazer uma nova nota ou accesse uma que ja foi criada.</div>").hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
					});
				});
				
				$($div).focusout(function(){
					$('#desc').fadeOut( 100 , function(){
					   var div = $("<div id='desc'>&quot;Aproveite o melhor da núvem, faça suas anotações e use onde quiser.&quot;</div>").hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
					});
				});
			</script>
		<script src="scrollReveal.js"></script>
        </body>
</html>