<?php 
    require_once("init.php");
    require_once("functions.php");
    $SERVER = "http://localhost:8888";
    
    if (isset($_POST['todas'])) {
	session_start();
	$_SESSION['code'] = $_POST['code'];
        header("Location: all.php");
    }
    if (isset($_POST['salvar']) || isset($_POST['sair'])) {
        if (isset($_POST['code']) and strlen($_POST['code'])>0) {
            $_POST['function'] = 'save';
            $json = json_decode(sendPost($SERVER, $_POST),true);

	// See if there's already a fast note with this name
	if(!$result = $mysql->query("select fnote_id from fastnote where fnote_name = '$_POST[code]'"))
	{
		// There is not so create a new fastnote
		$result = $mysql->query("insert into fastnote(fnote_name) values('$_POST[code]')");
		if(!$result)
		{
			die("Insert failed: " . mysql_error());
		}

		$fnote_id = $mysql->insert_id();
	}
	else
	{
		$obj = $result->fetch_object();
		$fnote_id = $obj->fnote_id;
	}


	// Now insert the line
	if($result = $mysql->query("select max(fnote_seq) as fnseq from fastnote_lines where fnote_id = $fnote_id"))
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
		
            if (isset($_POST['sair'])) {
                header("Location: .");
            } else {
                $_SESSION['salvo'] = 1;
                header("Location: notpad.php?code=".$json['document']);
            }
        }
    }
?>
<html>
    <head>
        <link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<?php
    echo "<a id='salvo' href='notpad.php'><div id='textCenter'>SALVO</div></a>";
?>
