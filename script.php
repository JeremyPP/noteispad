<?php 
require_once("init.php");
require_once("functions.php");
$SERVER = "http://localhost:8888";

if(isset($_POST['code']))
{
	session_start();
	$_SESSION['code'] = $_POST['code'];
}
    
if(isset($_POST['todas'])) 
{
	header("Location: all.php");
}
elseif(isset($_POST['salvar']))
{
	if(isset($_POST['code']) and strlen($_POST['code'])>0) 
	{
		// $_POST['function'] = 'save';
		//$json = json_decode(sendPost($SERVER, $_POST),true);

		// See if there's already a fast note with this name
		$result = $mysql->query("select fnote_id from fastnote where fnote_name = '$_POST[code]'");
		if(!$result->num_rows)
		{
			// There is not so create a new fastnote
			$result = $mysql->query("insert into fastnote(fnote_name) values('$_POST[code]')");
			if(!$result)
			{
				die("Insert failed: " . mysql_error());
			}

			$fnote_id = $mysql->insert_id;
		}
		else
		{
			$obj = $result->fetch_object();
			$fnote_id = $obj->fnote_id;
		}

		// Now insert the line
		$result = $mysql->query("select max(fnote_seq) as fnseq from fastnote_lines where fnote_id = $fnote_id");
		if($result->num_rows)
		{
			$obj = $result->fetch_object();
			$fnote_seq = $obj->fnseq;
		}
		else
		{
			$fnote_seq = 0;
		}

		++$fnote_seq;

		$mysql->query("insert into fastnote_lines(fnote_id, fnote_seq, fnote_text) values($fnote_id, $fnote_seq, '$_POST[content]')");
		echo '<html>
		    <head>
			<link href="style.css" type="text/css" rel="stylesheet">
			<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
			<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
			<meta http-equiv="refresh" content="1;url=notpad.php">
		   </head>
		   <body>
			    <div id="salvoTextCenter">SAVED</div></a>
		   </body>
		</html>';
	}
}
elseif(isset($_POST['sair']))
{
	// Exit - see if the text is the same as the last one in the db...
	$result = $mysql->query("select FL.fnote_id as fnote_id, FL.fnote_text as fnote_text, FL.fnote_seq as fnote_seq from fastnote_lines FL, fastnote F where F.fnote_name = '" . $_POST['code'] . "' and FL.fnote_id = F.fnote_id and FL.fnote_seq = (select max(fnote_seq) from fastnote_line where fnore_id = F.fnote_id)");
	if($result)
	{
		$obj = $result->fetch_object();
		if(strcmp($_POST['content'], $obj->fnote_text))
		{
			// Strings differ - for now just add the new row into the db
			// Jeremy - you need to add the pop-up asking if they want to save
			$seq = $obj->fnote_seq;
			++$seq;
			$mysql->query("insert into fastnote_lines(fnote_id, fnote_seq, fnote_text) values($obj->fnote_id, $seq, '$_POST[content]')");
		}
	}	

	session_destroy();
	header("Location: .");
}
?>
