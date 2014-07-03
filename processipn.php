<?php
require_once("init.php");
require_once("functions.php");
require_once("PPfunctions.php");

// STEP 1: read POST data
error_log(">>>>>processipn.php");
foreach ($_POST as $k => $v)
{
	error_log(">>>$k=$v");
}

// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// Instead, read raw POST data from the input stream. 
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();

foreach($raw_post_array as $keyval) 
{
	$keyval = explode ('=', $keyval);
	if(count($keyval) == 2)
	{
		$myPost[$keyval[0]] = urldecode($keyval[1]);
	}
}

// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) 
{
	$get_magic_quotes_exists = true;
} 

foreach($myPost as $key => $value) 
{        
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) 
	{ 
		$value = urlencode(stripslashes($value)); 
	} 
	else 
	{
		$value = urlencode($value);
	}

	$req .= "&$key=$value";
}

// Step 2: POST IPN data back to PayPal to validate
$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// In wamp-like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
// the directory path of the certificate as shown below:
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
if(!($ret = curl_exec($ch))) 
{
	// error_log("Got " . curl_error($ch) . " when processing IPN data");
	curl_close($ch);
	exit;
}

curl_close($ch);

if(strcmp($ret, "VERIFIED") == 0) 
{
	$res = $_POST;	// Make it simpler to copy code from processpdt to processipn

	// First thing to check is that this really is for us
	if($res['receiver_email'] != 'notispad@gmail.com')
	{
		error_log(">>>>INVALID RECEIVER_EMAIL: $res[receiver_email]");
		exit();
	}

	// The IPN is verified, process it:

	// We could be here for one of the following reasons:
	// It's a new user (no email registered yet) so setup the whole thing (custom[0] is 'new')
	// It's an existing user who has paid a subscription (custom[0] is set but already processed)
	// It's an existing user who has paid a subscription after a plan change (custom[0] is 'update')
	// It's a cancellation
	// We don't process subscr_signup (at the moment)

	if(($res['txn_type'] == 'subscr_payment') && isset($res['payment_status']) && ($res['payment_status'] == 'Completed'))
	{
		if(isAlreadyDone($res['txn_id']))
		{
			// This has already been done by pdt so exit
error_log(">>>>>>>>>>This has shown as already done");
			exit();
		}
		
		$already = isTicketProcessed($res['custom']);
		if($already == 1)
		{
			$amount = $res['mc_gross'];
			$curr = $res['mc_currency'];
			
			// Make sure that the currency is correct and that the plan amount is valid
			if(($curr == 'USD') && (isCorrectPlan($res['subscr_id'], $amount)))
			{
				updateDate($res['subscr_id']);
				// I know it's alrady closed - I want the txn_id storing
				closeTicket($res['custom'], $res['txn_id']);
			}
			else
			{
				error_log(">>>$res[payer_id]: INVALID PLAN PAYMENT OF $curr $amount");
			}
		}
		elseif(($already == 0) && (substr($res['$custom'],0,1) == 'U'))
		{
			$amount = $res['mc_gross'];
			$curr = $res['mc_currency'];
			$id = getUserByPayerAndSubscription($res['payer_id'], processTicket($res['custom']));
			// We need to change the plan_id, subscr_id and payment_date
			// Make sure that the currency is valid
			if($curr == 'USD')
			{
				cancelPayments($id);	// Cancel the existing plan
				changePlan($id, $res['subscr_id'], $res['payment_date'], $amount);
				closeTicket($res['custom'], $res['txn_id']);
				exit();
			}
			else
			{
				error_log(">>>$res[payer_id]: INVALID CURRENCY $curr");
			}
		}
		elseif(($already == 0) && (substr($res['custom'],0,1) == 'N'))
		{
			// New user - don't add if pdt has already done it
			list ($name, $passwd, $email, $planno) = processTicket($res['custom']);
			if(!checkUser($email))
			{
				addUser($name, $passwd, $email, $planno, $res['subscr_id'], $res['payer_id']);
				closeTicket($res['custom'], $res['txn_id']);
			}
		}

		exit();
	}
	elseif($res['txn_type'] == 'subscr_cancel')
	{
		//cancelSubscription($res['subscr_id']);
		exit();
	}
	else
	{
		// Something went wrong so redirect to index.php
	}
}
elseif($ret == "INVALID")
{
	// IPN invalid, log for manual investigation
	error_log(">>>INVALID: $curr_code $payment_amout, $profile_id");
}
?>

