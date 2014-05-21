<?php
require_once("init.php");
require_once("functions.php");
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
<?php

	$dest = 'notpad.php';

	if(isset($_SESSION['user_id']))
	{
		$max_notes = getMaxNotes($_SESSION['user_id']);
		$used_notes = getNotesUsed($_SESSION['user_id']);

		if($used_notes == $max_notes)
		{
			$dest = 'more.php';
		}
	}

        echo "<form action='$dest' method='post'>";
?>
                            <input id="senhaNota" placeholder="Type your Access Code" type="password" name="code">
                        </form>
                    </center>
				</div>
			</div>
			<form id="noteform" action="script.php" method="post">
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

                        echo "<input type='hidden' name='loggedin' id='loggedin' value='";
			if(isset($_SESSION['user_id']))
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
			echo "'>";
?>
						<!-- <input id="botao0" type="submit" onclick="script.php" value="Save" name="salvar"> -->
						<input id="botao0" type="submit" value="Save" name="salvar">
						<div id="botao2">New Note</div>
						<input id="botao3" type="submit" onclick="script.php" value="View all" name="todas">
						<div id="botao4" class="ex-b-v2" onclick="checkExit();">Exit</div>
						<!-- Replace onClick #botao4 -->
				</div>
				<textarea id="textNote" name="content" spellcheck=false onchange="changed=true;"">
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

	echo getNoteText($code, $seq_sql);
?>
				</textarea>
				<div id="bottom"></div>
			</form>
			<div id="bottomBar"></div>
			
			<script>
				var changed=false;
				var exitVal = false;

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
				
				//=== Does the textarea have any text?
				function hasData()
				{
					return $('#textNote').val().match(/\S/);
				}

				//=== Check that we should exit
				function checkExit()
				{
					if(changed && hasData())
					{
						confEx();
					}
					else
					{
						if($('#loggedin').val() == "1")
						{
							window.location.href = "me.php";
						}
						else
						{
							window.location.href = "index.php";
						}
					}

				}
				//=== Confirm exit
				function confEx(){
				  $(".popup-modal").css('display', 'block');
				}
				$( "#close-popup-ex" ).click(function() {
				  $(".popup-modal").css('display', 'none');
				});
				$( "#pu-snex-b" ).click(function() {
				  $(".popup-modal").css('display', 'none');
				  $("#noteform").append("<input type='hidden' name='sair' value='1'>"); 
				  $("#noteform").submit();
				});
				$( "#pu-ex-b" ).click(function() {
				  $(".popup-modal").css('display', 'none');
				  window.location.href = "index.php";
				});
				$("#botao0").click(function(event) 
				{
					if(!hasData())
					{
						event.preventDefault();
					}
				});
			</script>
        </body>
</html>
