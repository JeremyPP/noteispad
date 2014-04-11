﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    </head>
        <body id="allNotes">
		<a href="me.php" style=" text-decoration: none; ">
			<div id="openb2"><img src="back.png">Voltar</div>
		</a>
		<h1 data-scrollreveal="enter top and move -200px over 1s">Minhas notas</h1>
		
		<div id="contAllNotas" data-scrollreveal="enter bottom and move 100px over 1s">
		
			<div class="notaAllNota">
				<a href="#"><div class="allNotaContTxt" id="id-allNota">
				Alios autem dicere aiunt multo etiam inhumanius (quem locum breviter paulo ante 
				perstrinxi) praesidii adiumentique causa, non benevolentiae neque caritatis, 
				amicitias esse expetendas; itaque, ut quisque minimum firmitatis haberet minimumque 
				virium, ita amicitias appetere maxime; ex eo fieri ut mulie...
				</div></a>
				<div class="allNotaIcon" id="but-id">
					<center><img src="eye.png"></center>
					<div class="anI-txt">Ver codigo</div>
				</div>
			</div>
			
			<div class="notaAllNota">
				<a href="#"><div class="allNotaContTxt">
				Sed quid est quod in hac causa maxime homines admirentur et reprehendant meum 
				consilium, cum ego idem antea multa decreverim, que magis ad hominis dignitatem 
				quam ad rei publicae necessitatem pertinerent?
				</div></a>
				<div class="allNotaIcon">
					<center><img src="eye.png"></center>
					<div class="anI-txt">Ver codigo</div>
				</div>
			</div>
			
			<div class="notaAllNota">
				<a href="#"><div class="allNotaContTxt">
				Ac ne quis a nobis hoc ita dici forte miretur, quod alia quaedam in hoc facultas 
				sit ingeni, neque haec dicendi ratio aut disciplina, ne nos quidem huic uni studio 
				penitus umquam dediti fuimus. Etenim omnes artes, quae ad humanitatem pertinent, 
				habent quoddam commune vinculum, et quasi cognatione qu...
				</div></a>
				<div class="allNotaIcon">
					<center><img src="eye.png"></center>
					<div class="anI-txt">Ver codigo</div>
				</div>
			</div>
			
			<div class="notaAllNota">
				<a href="#"><div class="allNotaContTxt">
				Quam ob rem cave Catoni anteponas ne istum quidem ipsum, quem Apollo, ut ais, 
				sapientissimum iudicavit; huius enim facta, illius dicta laudantur. De me autem, ut
				iam cum utroque vestrum loquar, sic habetote.
				</div></a>
				<div class="allNotaIcon">
					<center><img src="eye.png"></center>
					<div class="anI-txt">Ver codigo</div>
				</div>
			</div>
			
			<div class="notaAllNota">
				<a href="#"><div class="allNotaContTxt">
				Illud autem non dubitatur quod cum esset aliquando virtutum omnium domicilium Roma.
				</div></a>
				<div class="allNotaIcon">
					<center><img src="eye.png"></center>
					<div class="anI-txt">Ver codigo</div>
				</div>
			</div>
			
			<div class="notaAllNota">
				<a href="#"><div class="allNotaContTxt">
				Sed ut tum ad senem senex de senectute, sic hoc libro ad amicum amicissimus scripsi 
				de amicitia. Tum est Cato locutus, quo erat nemo fere senior temporibus illis, nemo 
				prudentior; nunc Laelius et sapiens (sic enim est habitus) et amicitiae gloria 
				excellens de amicitia loquetur.
				</div></a>
				<div class="allNotaIcon">
					<center><img src="eye.png"></center>
					<div class="anI-txt">Ver codigo</div>
				</div>
			</div>
			
		</div>
		
		<script>
			
			$( "#but-id" ).mousedown(function() {
				  $('#id-allNota').fadeOut( 50 , function(){
					   var div = $("<div class='allNotaContTxt replacedNote' id='id-allNota'>azerty789456</div>").hide();
					   $(this).replaceWith(div);
					   $('#id-allNota').fadeIn( 50 );
					});
			});
			$( "#allNotes" ).mouseup(function() {
				  $('#id-allNota').fadeOut( 50 , function(){
					   var div = $("<div class='allNotaContTxt' id='id-allNota'>Alios autem dicere aiunt multo etiam inhumanius (quem locum breviter paulo ante perstrinxi) praesidii adiumentique causa, non benevolentiae neque caritatis, amicitias esse expetendas; itaque, ut quisque minimum firmitatis haberet minimumque virium, ita amicitias appetere maxime; ex eo fieri ut mulie...</div>").hide();
					   $(this).replaceWith(div);
					   $('#id-allNota').fadeIn( 50 );
					});
			});
		
		</script>
		
        <script src="scrollReveal.js"></script>
		</body>
</html>