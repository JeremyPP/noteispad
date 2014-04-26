<?php 
session_start(); ?>
<html>
    <head>
        <link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<?php
    $url=".";
    $redirecionar = false;
    isset($_POST['sair'])?$_SESSION['codtempacess']='':'';
    if (isset($_POST['todas'])) {
        $url = "./all.php";
        $redirecionar = true;
    }
    if($redirecionar == true || !isset($_POST['conteudo']) || (isset($_POST['codigo']) || !$_SESSION['codtempacess']) && (!isset($_POST['salvar']) && !isset($_POST['nova']))){
        isset($_POST['codigo'])?$_SESSION['codigo']=$_POST['codigo']:'';
        echo '<meta http-equiv="refresh" content="0 url='.$url.'">';
        echo '<script type="text/javascript">
                location.href = "'.$url.'";
            </script>';}
            
    if(isset($_POST['salvar']) || isset($_POST['nova'])){
        $newcd=&$_SESSION['newcd'];
        $codigo=$_SESSION['codtempacess'];
        if($newcd){echo "Código de Acesso: $codigo <br>";}
            $conteudo=$_POST['conteudo'];
            $i=fread(fopen("$codigo/.1.txt", "r"), filesize("$codigo/.1.txt"));
            if(isset($_POST['nova'])){
                $i++;}
            $arquivo=fopen("$codigo/$i.txt", "w+");
            fwrite($arquivo, $conteudo);
            fwrite(fopen("$codigo/.1.txt", "w+"), $i++);
            fclose($arquivo);
            echo "<a id='salvo' href='notpad.php'><div id='textCenter'>SALVANDO</div></a>";
            $_SESSION['salvo']=1;
           echo '<meta http-equiv="refresh" content="0 url='.$url.'">';
            echo '<script type="text/javascript">
                    location.href = "'.$url.'";
                </script>';
           }
echo '<br><a href="notpad.php">VOLTAR</a>';
?>