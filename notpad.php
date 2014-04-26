<?php session_start();
    if($_SESSION['codtempacess']){
        $codigo=$_SESSION['codtempacess'];
        $del=explode(' ', '\ / : * ? " < > |');
            for ($i=0; $i<sizeof($del);$i++){
                $ex= explode($del[$i], $codigo);
                if(isset($ex[1])){
                    echo "Achado ".$del[$i]."<br>";
                    $_SESSION['codtempacess']='';
                    $del=1;
                    $_SESSION['del']= $del;
                    $_SESSION['codtempacess']='';
                    break;}}}
                            
    if(!$_SESSION['codtempacess'] || $del==1){
        if($del==1){$url='.?logout';}else{ $url="."; }
        echo '<meta http-equiv="refresh" content="0 url='.$url.'">';
        echo '<script type="text/javascript">
                location.href = "'.$url.'";
            </script>';}
    $codtemp='';
    if(isset($_POST['codigo'])&& $_POST['codigo']!=''){
        $_SESSION['codtempacess']=$_POST['codigo'];}
    /* Criando Pasta (codigo) para salvar os arquivos */
        if(!isset($_SESSION['codtempacess'])){#Verifica se Já o usário esta logado.
            $_SESSION['codtempacess']='';
            for ($k=0; $k<8; $k++){
                $_SESSION['codtempacess'] .= rand(0,9);}
                $codtemp=$_SESSION['codtempacess'];}
        $codigo=$_SESSION['codtempacess'];
        if(!is_dir($codigo)){
            mkdir("./$codigo", 0777);
            fwrite(fopen("$codigo/.1.txt", "w+"), "0");
            fwrite(fopen("$codigo/0.txt", "w+"), "Bem vindo!\n\nVoce acabou de gerar um codigo inexistente, logo uma nova nota foi criada.\nUma vez salva, essa nota sera asociada a esse codigo.\nGuarde esse codigo para poder acessar sua nota novamente, ou para poder compartilhar-la com outras pessoas.\nSe voce compartilhar o codigo, não se preocupe, a conteudo original da sua nota não podera ser alterado.\nUma vez a nota salva, qualquer alteração feita sera guardade em uma outra pagina.\nVoce pode acessar todas as paginas existentes clicando em 'Ver todas'.\nVoce pode criar uma nova nota com um novo codigo ou acessar outra nota ja existente clicando em 'Nova Nota' no canto superior direito.\nEsperamos que goste dos nossos serviços.\nQualquer duvida estamos a disposição.\nAtenciosamente,\n\nA equipe NOT is PAD!");} 
    /*FIM*/
    $s=fread(fopen("$codigo/.1.txt", "r"), filesize("$codigo/.1.txt"));
    $i=$s;
    $sample='';
    /* Abrindo Arquivo a ser exibido, e caso não seja escolhido, abrir último. */
        if(isset($_GET['arquivo'])){
            $i=$_GET['arquivo'];
            $i--;
            if($_GET['arquivo']>$s || $_GET['arquivo']<1){
                $i=$s;}}
    /*FIM*/
    $ultimo="$codigo/$i.txt";
    $fo=fopen($ultimo, "r");
    if(filesize($ultimo)>0){
        $sample=fread($fo, filesize($ultimo));}
    $visitas=fread(fopen("visitas.txt", "r"), filesize("visitas.txt"));
    $visitas++;
    fwrite(fopen("visitas.txt", "w+"), $visitas);
    $i++;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<title><?php echo "Arquivo $i"; ?>! NOT is PAD!</title>
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
                        <form action="script.php" method="post">
                            <input id="senhaNota" placeholder="Digite seu Código" type="password" name="codigo">
                        </form>
                    </center>
				</div>
			</div>
			<form action="script.php" method="post">
				<div id="top">
						<input id="botao0" type="submit" onclick="script.php" value="Salvar" name="salvar">
						<!--<input id="botao1" type="submit" onclick="script.php" value="Adicionar" name="nova">-->
						<div id="botao2">Nova Nota</div>
						<input id="botao3" type="submit" onclick="script.php" value="Ver todas" name="todas">
						<input id="botao4" type="submit" onclick="script.php" value="Sair" name="sair">
						<!---->
				</div>
				<textarea id="textNote" name="conteudo" spellcheck=false><?php echo $sample; ?></textarea>
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