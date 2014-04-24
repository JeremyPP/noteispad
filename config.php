<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
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
					<center>
                        <form action="script.php" method="post" style="margin-top: 20px;">
                            <input id="novaSenha" placeholder="Senha atual" type="password" name="codigo">
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
					<div class="popUpTxtConfS">Selectione a cor da fonte</div>
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
			<a href="me.php" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Voltar</div></a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">Configurações</h1>
			
			<div id="conf-mip" class="confOp" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Modificar informações pessoais</div>
				<p>Jérémy <span id="openNomePopup">EDITAR NOME</span></p>
				<p>jeremynaka@hotmail.com <span id="openEmailPopup">EDITAR EMAIL</span></p>
				<p>••••••••••••••••<span id="openSenhaPopup">MUDAR SENHA</span></p>
			</div>
			
			<div id="conf-odc" class="confOp" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Opções da conta</div>
				<p>Plano atual: <b>PRO (R$9/mês)</b><span>MUDAR DE PLANO</span></p>
				<p>Deletar permanentemente sua conta <span id="confDel">DELETAR</span></p>
			</div>
			
			<div id="conf-odp" class="confOp" style="margin-bottom: 55px;" data-scrollreveal="enter bottom and move 100px over 1s">
				<div class="confOp-title">Opções de personalização</div>
				<p>Cor da fonte: <b>Preto</b> <span id="colorChangeFont">MUDAR COR</span></p>
				<p>Cor do fundo: <b>Branco</b> <span id="colorChangeBg">MUDAR COR</span></p>
				<p>Tamanho da fonte: <b>Normal</b><span id="tamFonteB">MUDAR TAMANHO DA FONTE</span></p>
			</div>
			
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