<?php 
    require_once("../notispad/init.php");
    require_once("../notispad/functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" type="text/css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title>Todas as Notas</title>

    </head>
    <body>
        <?php
                $codigo=$_SESSION['codtempacess'];
                $server = "http://localhost:8888";
                $pages = json_decode(sendGet($server."?function=getInfo&code=".$codigo), true)['pages'];
                if ($pages == 0) {
                    $pages = json_decode(sendGet($server."?function=getInfo&code=default"), true)['pages'];
                }
                
                for ($i=$pages - 1; $i>=0; $i--){
                    echo "<a href='notpad.php?code=$codigo&page=$i' style='text-decoration: none; color: #000; '><div class='all'>
                            <div class='allnum'>
                                Pagina $i
                            </div>
                            <div class='allcontent'><p>".
                                json_decode(sendGet($server."?code=$codigo&page=$i"), true)['content']
                                ."
                            </p></div>
                            <br>
                          </div></a>";
                }
        ?>
    </body>
</html>