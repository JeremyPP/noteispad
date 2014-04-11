<?php session_start();
    $url='notpad.php';
    (isset($_SESSION['codigo'])&&$_SESSION['codigo']!='')?$_SESSION['codtempacess']=$_SESSION['codigo']:'';
    isset($_GET['logout'])?$_SESSION['codtempacess']='':'';
    if(isset($_SESSION['codtempacess']) && $_SESSION['codtempacess']!=''/*&& !isset($_POST['codigo'])*/){
        $_SESSION['codigo']='';
        echo '<meta http-equiv="refresh" content="0 url='.$url.'">';
        echo '<script type="text/javascript">
                location.href = "'.$url.'";
            </script>';}
    else{
        if(isset($_POST['codigo'])){
            $_SESSION['codtempacess'] = $_POST['codigo'];}
        isset($_SESSION['codigo'])?$_POST['codigo']=$_SESSION['codigo']:'';
        $_SESSION['newcd']=false;
        $newcd =& $_SESSION['newcd'];
        $del =0;
        /* Criando Pasta (codigo) para salvar os arquivos */
            !isset($_POST['codigo'])?$_POST['codigo']='':'';
            if($_POST['codigo']!='' && $_POST['codigo']!=$_SESSION['codtempacess']){#Verifica se o novo código é igual ao anterior, se não for, criar pasta e arquivos.
                $codigo=$_POST['codigo'];
                /* Verificar caracteres especiais */
                    
                /*FIM*/
                if($del!=1){
                    $_SESSION['codtempacess']=$_POST['codigo'];
                    $codigo=$_SESSION['codtempacess'];
                    $newcd=true;}
                if(!is_dir($codigo) && $del!=1){
                    mkdir("$codigo", 0777);
                    fwrite(fopen("$codigo/.1.txt", "w+"), "0");
                    fwrite(fopen("$codigo/0.txt", "w+"), "Bem vindo!\n\nGuarde bem o código, pois é com ele que você terá acesso aos arquivos.Lembre-se, se você tinha gerado outro código, os arquivos ainda estão nele, não se preocupe.\n\nNot is Pad, is a NOTePAD.\nStênio Elson");}}
        /*FIM */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link href="style7.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script type="text/javascript">
        <?php
            if(isset($_SESSION['del']) && $_SESSION['del']==1){
                echo 'alert('."'".'Os caracteres: \ / : * ? " < > |, não são aceitos no Código de Acesso.'."'".')';
                $_SESSION['del']='';}}
        ?>
        </script>
    </head>
        <body>			
			<div id="b01p"><img src="user.png">Jérémy</div>
			
			<div id="dropDownProf">
				<div class="userName">Jérémy</div>
				<div class="userEmail">jimypougnet@gmail.com</div>
				<div class="userDataLeft">27 de 100 notas criadas</div>
				<div class="quotaContainer">
					<div style="width: 27%;" class="quotaBar"></div>
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
				<a href="../notepad" class="nemuListProfLink">
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
					<div id="name">NOT is PAD!</div>
				</div>
				<div>
					<form action="notpad.php" method="post">
						<input id="senha" placeholder="Digite seu Código" type="password" name="codigo">
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