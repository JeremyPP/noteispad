<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script type="text/javascript" src="colorpicker.js"></script>
    </head>
        <body id="conf" style="overflow: visible;">
			<div id="modalNome" class="hidden">
				<div id="boxNome">
					<span class="og-closeE"></span>
					<div class="popUpTxtConf">Digite um novo nome</div>
					<center>
                        <form action="script.php" method="post">
                            <input id="novoEmail" placeholder="" type="text" name="codigo" value="Jérémy">
							<br>
							<input id="valid" type="submit" onclick="" value="Salvar" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalEmail" class="hidden">
				<div id="boxEmail">
					<span class="og-closeE"></span>
					<div class="popUpTxtConf">Digite um novo email</div>
					<center>
                        <form action="script.php" method="post">
                            <input id="novoEmail" placeholder="" type="email" name="codigo" value="jeremynaka@hotmail.com">
							<br>
							<input id="valid" type="submit" onclick="" value="Salvar" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalSenha" class="hidden">
				<div id="boxSenha">
					<span class="og-closeE"></span>
					<div class="popUpTxtConfS">Digite sua senha atual</div>
					<center>
                        <form action="script.php" method="post">
                            <input id="novaSenha" placeholder="Senha atual" type="password" name="codigo">
							<div class="popUpTxtConfS" style="color: #4CAED3;">Digite uma nova senha</div>
							<input id="novaSenha" placeholder="Nova senha" type="password" name="codigo">
							<br>
							<input id="valid" type="submit" onclick="" value="Salvar" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<div id="modalCorFonte" class="hidden">
				<div id="boxCorFonte">
					<span class="og-closeE"></span>
					<div class="popUpTxtConf" style="margin-bottom:15px;margin-top:30px;">Selectione uma cor</div>
					<center>
						<div id="picker"></div>
						<div id="slide"></div>
                        <form action="script.php" method="post">
							<input id="valid2" type="submit" onclick="" value="Salvar" name="salvar">
                        </form>
                    </center>
				</div>
			</div>
			<a href="me.php" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Voltar</div></a>
			<h1>Configurações</h1>
			
			<div id="conf-mip" class="confOp">
				<div class="confOp-title">Modificar informações pessoais</div>
				<p>Jérémy <span id="openNomePopup">EDITAR NOME</span></p>
				<p>jeremynaka@hotmail.com <span id="openEmailPopup">EDITAR EMAIL</span></p>
				<p>********<span id="openSenhaPopup">MUDAR SENHA</span></p>
			</div>
			
			<div id="conf-odc" class="confOp">
				<div class="confOp-title">Opções da conta</div>
				<p>Plano atual: PRO (R$9/mês)<span>MUDAR DE PLANO</span></p>
				<p>Deletar permanentemente sua conta <span id="confDel">DELETAR</span></p>
			</div>
			
			<div id="conf-odp" class="confOp" style="margin-bottom: 55px;">
				<div class="confOp-title">Opções de personalização</div>
				<p>Cor da fonte <span id="colorChangeFont" style="background: #000;"></span></p>
				<p>Cor do fundo <span id="colorChangeBg"></span></p>
				<p>Tamanho da fonte: 22px<span id="tamFonteB">MUDAR TAMANHO DA FONTE</span></p>
			</div>
			
			<script type="text/javascript">
			  ColorPicker(
				document.getElementById('slide'),
				document.getElementById('picker'),
				function(hex, hsv, rgb) {
				  document.getElementById("colorChangeFont").style.backgroundColor = hex;
				  document.getElementById("valid2").style.backgroundColor = hex;
				});
			</script>
			
			<script src="scrollReveal.js"></script>
			<script>
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
			</script>
		</body>
</html>