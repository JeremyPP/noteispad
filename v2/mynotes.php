<?php
require_once("init.php");

if(!isset($_SESSION['user_id']))
{
        header("Location: index.php");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<title>My notes - not is pad!</title>
		<meta name="description" content="not is pad! is the simplest and fastest way to save and share your notes anywhere at anytime." >
		<meta name="keywords" content="notes, file sharing, cloud storage, online notes, sharing, cloud, backup, collaboration, remote access, notepad" >
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    </head>
        <body id="allNotes">
			<a href="me.php" style="text-decoration: none;">
				<div id="openb2"><img src="back.png">Back</div>
			</a>
			<h1 data-scrollreveal="enter top and move -200px over 1s">
				My notes
			</h1>
			<h3 data-scrollreveal="enter top and move -200px over 1s">
<?php
        $notes_used = getNotesUsed($_SESSION['user_id']);
        $note_max = getMaxNotes($_SESSION['user_id']);
	$total_notes = getTotalNotes($_SESSION['user_id']);
	echo "<span>$notes_used</span> notes of <span>$note_max</span> created this month. <span>$total_notes</span> notes in total";
?>
			</h3>
			
			<div id="contAllNotas" data-scrollreveal="enter bottom and move 100px over 1s">
<?php
	$res = $mysql->query("select N.note_name, NL.note_text, NL.note_seq from notes N, note_lines NL where N.user_id = $_SESSION[user_id] and NL.note_id = N.note_id and NL.note_seq = (select max(note_seq) from note_lines where note_id = N.note_id)");
	if($res->num_rows)
	{
		$script = '';

		for($i=0; $i < $res->num_rows; ++$i)
		{
			$res->data_seek($i);
			$row = $res->fetch_object();				
			echo '<div class="notaAllNota">';
			echo "<a href='notpad.php?note=$row->note_name'>";
			echo "<div class='allNotaContTxt' id='id-allNota$row->note_seq'>";
			$display_text = preg_replace('/[\r\n]+/', ' ', trim($row->note_text));
			if(strlen($display_text) > 300)
			{
				$display_text = substr($display_text,0,300);
				$display_text .= '....';
			}
			echo $display_text;
			echo '</div>';
			echo '</a>';
			echo "<div class='allNotaIcon' id='but-id$row->note_seq'>";
			echo '<center>';
			echo '<img src="eye.png">';
			echo '</center>';
			echo '<div class="anI-txt">View code</div>';
			echo '</div>';
			echo '</div>';

			$script .= '$( "#but-id' . $row->note_seq . '").hover(' . "\n";
			$script .= 'function() {' . "\n";
			$script .= '$(\'#id-allNota' . $row->note_seq . '\').fadeOut( 50 , function(){' . "\n";
			$script .= 'var div = $("<div class=\'allNotaContTxt replacedNote\' id=\'id-allNota' . $row->note_seq . '\'>' . $row->note_name . '</div>").hide();' . "\n";
			$script .= '$(this).replaceWith(div);' . "\n";
			$script .= '$(\'#id-allNota' . $row->note_seq . '\').fadeIn( 50 );' . "\n";
			$script .= '});' . "\n";
			$script .= '}, function() {' . "\n";
			$script .= '$(\'#id-allNota' . $row->note_seq . '\').fadeOut( 50 , function(){' . "\n";
			$script .= 'var div = $("<div class=\'allNotaContTxt\' id=\'id-allNota' . $row->note_seq . '\'>' . $display_text . '</div>").hide();' . "\n";
			$script .= '$(this).replaceWith(div);' . "\n";
			$script .= '$(\'#id-allNota' . $row->note_seq . '\').fadeIn( 50 );' . "\n";
			$script .= '});' . "\n";
			$script .= '}' . "\n";
			$script .= ');' . "\n";
		}
	}	
?>
			</div>
			
			<script>
<?php
	echo $script;
?>
			</script>
			
			<script src="scrollReveal.js"></script>
		</body>
</html>
