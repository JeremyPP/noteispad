<?php
require_once("init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" type="text/css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title>All pages - not is pad!</title>

    </head>
    <body>
	
	
	
        <?php
                //$codigo=$_SESSION['codtempacess'];
                $server = "http://localhost:8888";
                //$pages = json_decode(sendGet($server."?function=getInfo&code=".$codigo), true)['pages'];
                //if ($pages == 0) {
                    //$pages = json_decode(sendGet($server."?function=getInfo&code=default"), true)['pages'];
                //}
                
		if(isset($_SESSION['user_id']))
		{
			$result = $mysql->query("select UL.usernote_text as fntext from usernote U, usernote_lines UL where U.usernote_name = '$_SESSION[code]' and UL.usernote_id = U.usernote_id");
		}
		else
		{
			$result = $mysql->query("select FL.fnote_text as fntext from fastnote F, fastnote_lines FL where F.fnote_name = '$_SESSION[code]' and FL.fnote_id = F.fnote_id");
		}

		if($result->num_rows)
		{
			for ($i=0, $p=1; $i < $result->num_rows; ++$i, ++$p)
			{
				$result->data_seek($i);
				$row = $result->fetch_row();
				echo "<a href='notpad.php?page=$p' style='text-decoration: none; color: #000; '><div class='all'>
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
		}
		else
		{
			echo "<a href='notpad.php' style='text-decoration: none;'><div id='openb2'><img src='back.png'>Back</div></a>";
			echo "<div class='all'><div class='allcontent'><p>No Pages</p></div></div>";
		}

        ?>
    </body>
</html>
