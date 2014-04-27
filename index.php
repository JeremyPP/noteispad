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
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
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
	
		<!---Verificar navegador--->
		<div class="erro-navegador" id="erroNav">
			<div>
				Este site não esta otimizado para o seu navegador. Aconselhamos instalar o Google
				Chrome para uma melhor experiencia.
			</div>
		</div>
		<script>
		var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
            document.getElementById('erroNav').style.display="block";
        else
            document.getElementById('erroNav').style.display="none";
		</script>
		
		<div class="erro">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Desculpe. Aparentenente algum erro inesperado ocoreu, por favor tente novamente.
				</h2>
				<div id="voltar-pass-er-b">Voltar</div>
			</div>
		</div>
		
			<div id="openb">Saiba mais<img src="info.png"></div>
			<div id="over">
				<div id="closeb"><span class="og-close"></span></div>
				<div id="contentOver">
					<h1>Bem vindo ao NOT is PAD!</h1>
					<h2>Nosso objectivo</h2>
					<p>A idea por traz do NOT is PAD! é de proporcionar uma maneira rapida e facil 
					de compartilhar comteudo nas nuvens com outras pessoas. Com o NOT is PAD!, voce
					cria um codigo para a sua nota e compartilha esse codigo com o seus amigo e/ou cologas.
					Mais não se preocupe, a sua nota original não pode ser alterada, se uma pessoa fizer modificaçoes
					no conteudo da nota, outra "pagina" sera criada e o conteudo inicial não sera alterado.</p>
					<h2>Criar uma Nota Rapida</h2>
					<p>Existe duas maneiras de utilizar o NOT is PAD!, a primeira delas é para criar
					"Notas Rapidas". As Notas Rapidas sao uma exelente solução para compartilhar ou
					registrar rapidamente uma ideia. Para criar uma nova Nota Rapida, basta escolher um
					codigo de acesso e pronto, sua nota é automaticamente criada, basta começar a escrever.
					As Notas Rapidas podem ser acessadas por qualquer um que possua o codigo relacionado a esta
					nota. Por isso se voce não deseja compartilhar o conteudo da nota, quarde o codigo
					em segurança. E tambem importante saber que as Notas Rapidas ficam acessiveis nos
					nossos servidores somente por 7 (sete) dias.</p>
					<h2>Criar uma conta no NOT is PAD!</h2>
					<p>Criando uma conta no NOT is PAD! e escolhendo um dos nosso planos, voce
					beneficia de varias vantagens que permitem utilizar plemamente nossos serviços.
					Alem de ter acesso a um espaço esclusivo nos nossos servidores para poder armazenar suas notas,
					voçe tera acesso ao nosso gerenciador de notas. Esse ultimo permite organizar todas suas 
					notas alem de lhe garantir accesso a opçoes avançadas. Se estiver interesado, clique <a href="planos.php">aqui</a> e confira o melhor plano para voce!</p>
					<p>Esperamos lhe ver em breve no NOT is PAD!</p>
					<p>Qualquer duvida, entre em contato com a gente.</p>
					<p>Atenciosamente,</p>
					<br>
					<p>A equipe NOT is PAD!</p>
					<br>
					<br>
				</div>
			</div>
			<div id="b01"><img src="user.png">Log in</div>
			
			<div id="loginOver">
				<div id="topLog">
					Log in
					<div id="clos02">
					<span class="og-close" id="loginclose" style="top: 10px; left: 410px;"></span>
					</div>
				</div>
				<div id="formsLog">
					<form action="me.php" method="post">
						<input id="emailLog" autofocus="1" type="email" name="login_email" id="login_email" placeholder="Seu email">
						<div class="form-error" id="email-error">Email invalido ou inexistente!</div>
						<br>
						<input id="senhaLog" type="password" id="login_password" name="login_password" placeholder="Sua senha">
						<div class="form-error" id="pass-error">Senha incorreta!</div>
						<div id="remember-me">
							<input type="checkbox" checked="True" id="remember_me" name="remember_me" tabindex="3">
							<label style="font-size: 15px; color: #8D9BA0; font-weight: 900;" for="remember_me">Mantenha-me logado</label>
						</div>
						<input name="login_submit" value="Log in" type="submit" id="loginSubmit">
						<div id="forgotPassword">
							<center style=" margin-top: 10px; ">
								<a href="forgot.php">Esqueceu sua senha?</a>
							</center>
						</div>
						<center id="separaLogin">ou</center>
						<center id="createSubmit"><a href="planos.php" style="padding: 15px;color: #fafafa; text-decoration: none;text-transform: uppercase;font-weight: 700;">Crie uma conta</a></center>
					</form>
				</div>
			</div>
           
		   <div id="center" data-scrollreveal="enter bottom and move 200px over 1.3s">
				<div id="logo">
					<center><div id = "cloud"></div></center>
					<center><div class="logo-p2"></div></center>
					<div id="name">not is pad!</div>
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
				
				$( "#openb" ).click(function() {
				  $("#over").attr('class', 'open');
				  $("#center").attr('class', 'open');
				  $("#b01").attr('class', 'open');
				  $("body").css('overflow-y', 'visible');
				});
				$( "#closeb" ).click(function() {
				  $("#over").attr('class', 'closed');
				  $("#center").attr('class', 'closed');
				  $("#b01").attr('class', 'closed');
				  $("body").css('overflow-y', 'hidden');
				});
				
				$( "#b01" ).click(function() {
				  $("#loginOver").attr('class', 'open');
				  $("#center").attr('class', 'openSing');
				  $("#openb").attr('class', 'open');
				});
				$( "#clos02" ).click(function() {
				  $("#loginOver").attr('class', 'closed');
				  $("#center").attr('class', 'closedSing');
				  $("#openb").attr('class', 'closed');
				});
				
				//=== Erros ===
				$( ".erro" ).click(function() {
				  $(".erro").css('opacity', '0');
				  $(".erro").css('visibility', 'hidden');
				});
				$( "#center" ).click(function() {
				  $("#center").css('background', '#333');
				   $("#center").css('color', '#ccc');
				});
				
				function erro01(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
				
				function erro02(){
				  $("#emailLog").css('background', 'rgb(245, 212, 212)');
				  $("#emailLog").css('border', '1px solid #e74c3c');
				  $("#email-error").css('display', 'block');
				}
				function erro03(){
				  $("#senhaLog").css('background', 'rgb(245, 212, 212)');
				  $("#senhaLog").css('border', '1px solid #e74c3c');
				  $("#pass-error").css('margin-top', '5px');
				  $("#pass-error").css('display', 'block');
				}
				function erro04(){
				  $("#center").css('background', '#F55B68');
				  $('#desc').fadeOut( 100 , function(){
					   var div = $('<div id="desc">Os caracteres: \ / : * ? " < > |, não são aceitos no Código de Acesso.</div>').hide();
					   $(this).replaceWith(div);
					   $('#desc').fadeIn( 500 );
				  });
				  $("#center").css('color', '#ffffff');
				}
				
			</script>
		<script src="scrollReveal.js"></script>
        </body>
</html>