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
		$result = $mysql->query("select NL.note_text as ntext from notes N, note_lines NL where N.note_name = '$_SESSION[code]' and NL.note_id = N.note_id");

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
