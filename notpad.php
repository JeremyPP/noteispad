<?php
require_once("init.php");
session_start();
?>
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
					Sorry, it seems that an unexpected error has occurred. Please, try again.
				</h2>
				<div id="voltar-pass-er-b">Back</div>
			</div>
		</div>
		
		<div class="popup-modal">
			<div class="popup">
				<span id="close-popup-ex" class="og-close"></span>
				<h5>The changes you've made will not be saved!</h5>
				<div id="pu-snex-b">Save and exit</div>
				<div id="pu-ex-b">Exit</div>
			</div>
		</div>
		
			<div id="modal" class="hidden">
				<div id="box">
					<span class="og-close"></span>
					<p>Create your Access Code for a new note, or go to one that already exist.</p>
					<center>
                        <form action="notpad.php" method="get">
                            <input id="senhaNota" placeholder="Type your Access Code" type="password" name="code">
                        </form>
                    </center>
				</div>
			</div>
			<form action="script.php" method="post">
				<div id="top">
<?php
			if(isset($_POST['code']))
			{
				$code = $_POST['code'];
			}
			else
			{
				$code = $_SESSION['code'];
			}

                        echo "<input type='hidden' name='code' value='$code'>";
?>
						<input id="botao0" type="submit" onclick="script.php" value="Save" name="salvar">
						<div id="botao2">New Note</div>
						<input id="botao3" type="submit" onclick="script.php" value="View all" name="todas">
						<input id="botao4" type="submit" onclick="script.php" value="Exit" name="sair">
						<!---->
				</div>
				<textarea id="textNote" name="content" spellcheck=false>
<?php
	if(isset($_GET['page']))
	{
		$seq_sql = $_GET[page];
		$code = $_SESSION[code];
	}
	else
	{
		$seq_sql = "(select max(fnote_seq) from fastnote_lines where fnote_id = F.fnote_id)";
		if(isset($_POST['code']))
		{
			$code = $_POST['code'];
		}
		else
		{
			$code = $_SESSION['code'];
		}
	}

	// Is this a new note or an existing one?
	if($result = $mysql->query("select FL.fnote_text as fntext from fastnote_lines FL, fastnote F where F.fnote_name = '$code' and FL.fnote_id = F.fnote_id and FL.fnote_seq = " . $seq_sql))
	{
		if($result->num_rows)
		{
			$obj = $result->fetch_object();
			echo $obj->fntext;
		}
		else
		{
			echo <<<'EOR'
Welcome!

You have just created a nonexistent code, so a new note has been created.
Once saved, this note will be associated to this code.
Save this code to access your notes again, or to share it with others people.
If you share the code, don't worry, the original content of your note will cannot be changed.
Once the note saved, any changes made will be saved to another 'page'.
You can access all existing pages by clicking on 'View all'.
Also, you can create a new note with a brand new code or access another existing note by clicking on 'New Note' in the upper right corner.
We hope you enjoy our services.
We are here if you have any question.
Regards,

The NOT is PAD! team.
EOR;
		}
	}
?>
				</textarea>
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
				
				//=== Confirm exit
				function confEx(){
				  $(".popup-modal").css('display', 'block');
				}
				$( "#close-popup-ex" ).click(function() {
				  $(".popup-modal").css('display', 'none');
				});
			</script>
        </body>
</html>
