<?php
require_once("init.php");
require_once("PPfunctions.php");


$token = 'tBA_zgv-TOeV2BbjWtNc8wjG4FqVNmov_QUYBH4q7IToIjGqgagjGvgFcG0';
if(isset($_GET['tx']))
{
	// First call - we've got the tx but care about the other values as it might be a spoof call
	$tx=$_GET['tx'];
	$ch = curl_init();
	if(isSandbox())
	{
		$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}
	else
	{
		$url = "https://www.paypal.com/cgi-bin/webscr";
	}

	curl_setopt_array($ch, array
	(
		
		CURLOPT_URL => $url,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query(array
		(
			'cmd' => '_notify-synch',
			'tx' => $_GET['tx'],
			'at' => $token,
		)),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => false,
	));

	$res = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);

	if(($status == 200) && (strpos($res, 'SUCCESS') == 0))
	{
		$res = substr($res,7);
		$res = urldecode($res);
		preg_match_all('/^([^=\s]++)=(.*+)/m', $res, $m, PREG_PATTERN_ORDER);
		$res = array_combine($m[1], $m[2]);
error_log(">>>processpdt");
foreach($res as $k => $v)
{
	error_log(">>>$k=$v");
}

		// First thing to check is that this really is for us
		if($res['receiver_email'] != 'notispad@gmail.com')
		{
			error_log(">>>>INVALID RECEIVER_EMAIL: $res[receiver_email]");
			exit();
		}

		// We could be here for one of three reasons:
		// It's a new user (no email registered yet) so setup the whole thing (custom set and start with 'N')
		// It's an existing user who has paid a subscription
		// It's a new payment following a plan update (custom set and starts with 'U')

		if(($res['txn_type'] == 'subscr_payment') && isset($res['payment_status']) && ($res['payment_status'] == 'Completed'))
		{
			$already = isTicketProcessed($res['custom']);

			if($already == 1)
			{
				$amount = $res['mc_gross'];
				$curr = $res['mc_currency'];
				
				// Make sure that the currency is correct and that the plan amount is valid
				if(($curr == 'USD') && (isCorrectPlan($res['subscr_id'], $amount)))
				{
					updateDate($res['subscr_id']);
					// Just do this to store the txn_id (actually, we should never be here in pdt)
					closeTicket($res['custom'], $res['txn_id']);
					updateTotal($amount);
				}
				else
				{
					error_log(">>>$res[payer_id]: INVALID PLAN PAYMENT OF $curr $amount");
				}
			}
			elseif(($already == 0) && (substr($res['custom'],0,1) == 'U'))
			{
				$prev_subscr_id = processTicket($res['custom']);

				$id = getUserByPayerAndSubscription($res['payer_id'], $prev_subscr_id);
				// We need to change the plan_id, subscr_id and payment_date
				// Make sure that the currency is valid
				$amount = $res['mc_gross'];
				$curr = $res['mc_currency'];
				if($curr == 'USD')
				{
					cancelPayments($id);	// Cancel the existing plan
					changePlan($id, $res['subscr_id'], $res['payment_date'], $amount);
					closeTicket($res['custom'], $res['txn_id']);
					updateTotal($amount);
					header("Location: config.php");
					exit();
				}
				else
				{
					error_log(">>>$res[payer_id]: INVALID CURRENCY $curr");
				}
			}
			elseif(($already == 0) && (substr($res['custom'],0,1) == 'N'))
			{
				// New user
				list ($name, $passwd, $email, $planno) = processTicket($res['custom']);
				$_SESSION['user_id'] = addUser($name, $passwd, $email, $planno, $res['subscr_id'], $res['payer_id']);
				closeTicket($res['custom'], $res['txn_id']);
				updateTotal($res['mc_gross']);
				//header("Location: config.php");
				header("Location: me.php");
				exit();
			}

			//header("Location: me.php");
			exit();
		}
		elseif($res['txn_type'] == 'subscr_cancel')
		{
			header("Location: me.php");
			exit();
		}
	}
	else
	{
		// Something went wrong so redirect to index.php
		header('Location: index.php');
	}
}
?>
