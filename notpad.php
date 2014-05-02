<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<title>NOT is PAD!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    </head>
        <body id="pagNot">
		
		<div class="erro">
			<div class="recovery-center">
				<h1>Oops! :(</h1>
				<h2>
					Desculpe. Aparentenente algum erro inesperado ocoreu, por favor tente novamente.
				</h2>
				<div id="voltar-pass-er-b">Voltar</div>
			</div>
		</div>
		
			<div id="modal" class="hidden">
				<div id="box">
					<span class="og-close"></span>
					<p>Crie um código para fazer uma nova nota ou accesse uma que ja foi criada.</p>
					<center>
                        <form action="notpad.php" method="get">
                            <input id="senhaNota" placeholder="Digite seu Código" type="password" name="code">
                        </form>
                    </center>
				</div>
			</div>
			<form action="script.php" method="post">
				<div id="top">
                        <input type="hidden" name="code" value="">
						<input id="botao0" type="submit" onclick="script.php" value="Salvar" name="salvar">
						<!--<input id="botao1" type="submit" onclick="script.php" value="Adicionar" name="nova">-->
						<div id="botao2">Nova Nota</div>
						<input id="botao3" type="submit" onclick="script.php" value="Ver todas" name="todas">
						<input id="botao4" type="submit" onclick="script.php" value="Sair" name="sair">
						<!---->
				</div>
				<textarea id="textNote" name="content" spellcheck=false>Some content...</textarea>
				<div id="bottom"></div>
			</form>
			<div id="bottomBar"></div>
			
			<script>
				$( "#botao2" ).click(function() {
				  $("#modal").attr('class', 'visible');
				});
				$( ".og-close" ).click(function() {
				  $("#modal").attr('class', 'hidden');
				});
				
				//=== Erros ===
				$( ".erro" ).click(function() {
				  $(".erro").css('opacity', '0');
				  $(".erro").css('visibility', 'hidden');
				});
				
				function erroSaveN(){
				  $(".erro").css('visibility', 'visible');
				  $(".erro").css('opacity', '1');
				}
			</script>
        </body>
</html>