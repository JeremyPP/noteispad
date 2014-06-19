<?php
require_once('functions.php');
require_once('PPfunctions.php');
session_start();

if(isset($_GET['token']))
{
	if(isset($_GET['PayerID']))
	{	
		$_SESSION['pp_token'] = $_REQUEST['token'];
		$_SESSION['pp_payerid'] = $_REQUEST['PayerID'];
		$res = CreateRecurringPaymentsProfile($_REQUEST['token']);
		if(isset($res['ACK']) && ($res['ACK'] == 'SUCCESS'))
		{
			if(!isset($_GET['config']))
			{
				if($res['PROFILESTATUS'] == "ActiveProfile")
				{
					$start_date = $_SESSION['preauth_date'];
				}
				else
				{
					// Profile is Pending so wait for the IPN to trigger the date
					$start_date = "0000-00-00 00:00:00";
				}

				$id = addUser($_SESSION['preauth_name'], $_SESSION['preauth_password'], $_SESSION['preauth_email'], $_SESSION['preauth_planno'], $res['PROFILEID'], $start_date);
				$_SESSION['user_id'] = $id;
				if(isset($_SESSION['remember_me']))
				{
					addAuth($id);
				}

				$location = 'me.php';
			}
			else
			{
				$_SESSION['plan_change'] = true;
				$location = 'config.php';
			}

			header("Location: $location");
			exit();
		}
	}
}

header("Location: index.php");
?>
