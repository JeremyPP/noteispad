<?php
require_once("init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link href="style.css" type="text/css" rel="stylesheet">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<title>Admin - not is pad!</title>
		<meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    </head>
        <body id="admin" style="background: #333;">
			<a href="../notepad" style=" text-decoration: none; "><div id="openb2"><img src="back.png">Back</div></a>
			<h1>ADMIN.</h1>
			<p>
				This is a restricted area reserved for administrators. If you don't know how you
				got here, or you are not an administrator, please ignore the content below and
				close this page. 
			</p>
			<div id="basic-info">
				<h6>General informations</h6>
<?php
	list ($tot_usr, $tot_fn, $live_fn) = getNoteStats();
				echo "<div>Total usernotes created: <span>$tot_usr</span></div>\n";
				echo "<div>Total of Fast Notes created ever: <span>$tot_fn</span></div>\n";
				echo "<div>Total of live Fast Notes: <span>$live_fn</span></div>\n";
?>
				<br>
<?php
	$amount = getMonthlyIncome();
				echo "<div>Users income per month: <span>$amount</span></div>\n";
	$amount = getTotalIncome();
				echo "<div>Total users income: <span>$amount</span></div>\n";
?>
			</div>
			<div id="servidor-info">
				<h6>Server</h6>
				<div id="bginfoserver">
					<div>Memory:</div>
<?php
	// Assume that we're interested in the total memory used figure
	$fh = fopen('/proc/meminfo', 'r');
	while($line = fgets($fh))
	{
		$lp = array();
		if(preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $lp))
		{
			$totmem = $lp[1];
		}
		elseif(preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $lp))
		{
			$freemem = $lp[1];
		}
	}

	fclose($fh);

	$pcnt = sprintf("%.2f", (($totmem-$freemem)/$totmem)*100);
					echo "<h3>" . $pcnt . "%</h3>\n";

	$ds = displaySize(disk_total_space("/home/www/noteispad"));
	$fs = displaySize(disk_free_space("/home/www/noteispad"));
					echo "<h4>" . $fs . " of " . $ds . "</h4>\n";
?>
				</div>
			</div>
			<div id="usuarios-info">
				<h6>Users</h6>
<?php
	$plans = array();
	$plans = getUserCounts();
	$total = 0;
	foreach($plans as $k => $v)
	{
				echo "<div>Number of users " . $k . " plan:</div>\n";
				echo "<h3>$v</h3>\n";
				echo "<br>\n";
				$total += $v;
	}
?>
				<div id="separausersinfo"></div>
				<div>Total users:</div>
				<h3 style="color: #4CAED3;background: #fff;">
<?php
	echo $total;
?>
				</h3>
				<br>
			</div>
			<div id="lista-usuarios">Download list of all users</div>
		</body>
</html>
