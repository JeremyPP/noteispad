<?php
require_once("init.php");
require_once("functions.php");

// STEP 1: read POST data
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
if(!($res = curl_exec($ch))) 
{
	// error_log("Got " . curl_error($ch) . " when processing IPN data");
	curl_close($ch);
	exit;
}

curl_close($ch);

if(strcmp($res, "VERIFIED") == 0) 
{
	// The IPN is verified, process it:
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your Primary PayPal email
	// check that payment_amount/payment_currency are correct
	// process the notification

	if(isset($_POST['payment_status']) && (strtoupper($_POST['payment_status']) == 'COMPLETED'))
	{
		//$payment_amount = $_POST['mc_gross'];
		// Check that the amount agrees with the plan amount and the currency is USD
		$payment_amount = $_POST['amount'];
		$curr_code = $_POST['currency_code'];
		$profile_id = $_POST['recurring_payment_id'];
		if(($curr_code == 'USD') && (isCorrectPlan($profile_id, $payment_amount)))
		{
			updateDate($profile_id);
		}
		else
		{
			error_log(">>>VALID but wrong: $curr_code $payment_amout, $profile_id");
			exit();
		}
	}
} 
elseif($res == "INVALID")
{
	// IPN invalid, log for manual investigation
	error_log(">>>INVALID: $curr_code $payment_amout, $profile_id");
}
?>

