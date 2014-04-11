<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
        
<?php
    if(!$_SESSION['codtempacess']){
        echo '<meta http-equiv="refresh" content="0 url=.">';
            echo '<script type="text/javascript">
                    location.href = ".";
                  </script>';}
    else{
?>
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" type="text/css" rel="stylesheet">
    <title>Todas as Notas</title>

    </head>
    <body>
        <?php
                $codigo=$_SESSION['codtempacess'];
                $s=fread(fopen("$codigo/.1.txt", "r"), filesize("$codigo/.1.txt"));
                for ($i=$s; $i>=0; $i--){
                    $k=1+$i;
                    echo "<a href='notpad.php?arquivo=$k' style='text-decoration: none; color: #000; '><div class='all'>
                            <div class='allnum'>
                                Nota $k
                            </div>
                            <div class='allcontent'><p>".
                                fread(fopen("$codigo/$i.txt", "r"), 800)
                                ."
                            </p></div>
                            <br>
                          </div></a>";}}
        ?>
    </body>
</html>