<?php
require_once('functions.php');
require_once('PPfunctions.php');
session_start();

if(isset($_REQUEST['token']))
{
	if(isset($_REQUEST['PayerID']))
	{	
		$_SESSION['pp_token'] = $_REQUEST['token'];
		$_SESSION['pp_payerid'] = $_REQUEST['PayerID'];
		$res = CreateRecurringPaymentsProfile($_REQUEST['token']);
//		if(isset($res['ACK']) && ($res['ACK'] == 'SUCCESS'))
//		{
			// Do we need to do DoExpressCheckoutPayment?
//			$res = DoExpressCheckoutPayment($_SESSION['pp_payerid'], $_SESSION['pp_token'], $_SESSION['pp_amt']);
			if(isset($res['ACK']) && ($res == 'SUCCESS'))
			{
				$id = addUser($_SESSION['preauth_name'], $_SESSION['preauth_password'], $_SESSION['preauth_email'], $_SESSION['preauth_planno'], $_SESSION['pp_payerid'], $_SESSION['preauth_date']);
				$_SESSION['user_id'] = $id;
				if(isset($_SESSION['remember_me']))
				{
					addAuth($id);
				}

				header("Location: me.php");
				exit();
			}
//		}
	}
}

header("Location: index.php");
?>
