<?php
    require_once("init.php");
    require_once("functions.php");
    
    if (!logado()) {
        redirect(".");
    }
    
    $userInfo =  getUserInfo($_SESSION['email'], $_SESSION['tolken']);
   
    $notes = $userInfo['codes'];
?>
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
			<a href="me.php" style="text-decoration: none;">
				<div id="openb2"><img src="back.png">Voltar</div>
			</a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">
				Minhas notas
			</h1>
			<h3 data-scrollreveal="enter top and move -200px over 1s">
				<?php //<span>2</span> notas de <span>20</span> criadas esse mes. ?><span><?php echo $userInfo['notes']; ?></span> notas no total
			</h3>
			
			<div id="contAllNotas" data-scrollreveal="enter bottom and move 100px over 1s">
			
                <?php for ($i = $userInfo['notes'] - 1; $i >= 0; $i --) { $code = $notes[$i]; ?>
				<div class="notaAllNota">
					<a href="notpad.php?code=<?php echo urlencode($code); ?>">
						<div class="allNotaContTxt" id="id-allNota"><?php echo "Código: ".$code."<br>".getContent($code); ?></div>
					</a>
					<div class="allNotaIcon" id="but-id">
						<center>
							<img src="eye.png">
						</center>
						<div class="anI-txt">Ver codigo</div>
					</div>
				</div>
				<?php } ?>
				
			</div>
			
			<script>
			
			$( "#but-id" ).hover(
			  function() {
				$('#id-allNota').fadeOut( 50 , function(){
						   var div = $("<div class='allNotaContTxt replacedNote' id='id-allNota'>azerty789456</div>").hide();
						   $(this).replaceWith(div);
						   $('#id-allNota').fadeIn( 50 );
						});
			  }, function() {
				 $('#id-allNota').fadeOut( 50 , function(){
						   var div = $("<div class='allNotaContTxt' id='id-allNota'>Alios autem dicere aiunt multo etiam inhumanius (quem locum breviter paulo ante perstrinxi) praesidii adiumentique causa, non benevolentiae neque caritatis, amicitias esse expetendas; itaque, ut quisque minimum firmitatis haberet minimumque virium, ita amicitias appetere maxime; ex eo fieri ut mulie...</div>").hide();
						   $(this).replaceWith(div);
						   $('#id-allNota').fadeIn( 50 );
						});
			  }
			);			
			</script>
			
			<script src="scrollReveal.js"></script>
		</body>
</html>