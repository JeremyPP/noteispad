<?php
require_once("init.php");
session_start();
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
                //$codigo=$_SESSION['codtempacess'];
                $server = "http://localhost:8888";
                //$pages = json_decode(sendGet($server."?function=getInfo&code=".$codigo), true)['pages'];
                //if ($pages == 0) {
                    //$pages = json_decode(sendGet($server."?function=getInfo&code=default"), true)['pages'];
                //}
                
		$result = mysql_query("select FL.fnote_text from fastnote F, fastnote_lines FL where F.fnote_name = '$_SESSION[code]' and FL.fnote_id = F.fnote_id");
		$num_rows = mysql_num_rows($result);
		for ($i=0, $p=1; $i < $num_rows; ++$i, ++$p)
		{
			$row = mysql_fetch_row($result);
			echo "<a href='notpad.php?code=$codigo&page=$i' style='text-decoration: none; color: #000; '><div class='all'>
			<div class='allnum'>
				Page $p
			</div>
			<div class='allcontent'><p>".
			$row[0]
			."
			</p></div>
			<br>
			</div></a>";
		}
        ?>
    </body>
</html>
