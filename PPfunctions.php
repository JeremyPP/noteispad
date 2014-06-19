<?php

require_once("functions.php");

    /**
    * Make SetExpressCheckout call
    * @param description, cancel URL, return URL for a good call, config array, buyer email, price
    * @return Token
    */
    function SetExpressCheckout($desc, $cancel, $returl, $email, $price)
    {
	$callstr = "&PAYMENTREQUEST_0_AMT=" . urlencode($price);
	$_SESSION['pp_amt'] = urlencode($price);
	$callstr .= "&PAYMENTREQUEST_0_CURRENCYCODE=USD";
	$callstr .= "&PAYMENTREQUEST_0_PAYMENTACTION=Sale";
	$callstr .= "&L_BILLINGTYPE0=RecurringPayments";
	$callstr .= "&NOSHIPPING=1";
	$callstr .= "&EMAIL=" . urlencode('admin@notispad.com');
	$callstr .= "&L_BILLINGAGREEMENTDESCRIPTION0=" . urlencode($desc);
	$_SESSION['pp_desc'] = urlencode($desc);	// Save for later processing
	$callstr .= "&returnUrl=" . urlencode($returl);
	$callstr .= "&cancelUrl=" . urlencode($cancel);

	$res = callPP('SetExpressCheckout', $callstr);
	return $res;
    }

    /**
    * Make DoExpressCheckoutPayment call
    * @param payer id, token, amount
    * @return Token
    */
    function DoExpressCheckoutPayment($payerid, $token, $amt)
    {
	$callstr = "&TOKEN=" . urlencode($token);
	$callstr .= "&PAYERID=" . $payerid;
	$callstr .= "&PAYMENTREQUEST_0_PAYMENTACTION=Sale";
	$callstr .= "&PAYMENTREQUEST_0_AMT=" . $amt;

	$res = callPP('DoExpressCheckoutPayment', $callstr);
	return $res;
    }

    /**
    * Make CreateRecurringPaymentsProfile call
    * @param token
    * @return Results array
    */
    function CreateRecurringPaymentsProfile($token)
    {
	$callstr = "&TOKEN=" . urlencode($token);
	$callstr .= "&EMAIL=" . $_SESSION['preauth_email'];
	$callstr .= "&DESC=" . $_SESSION['pp_desc'];
	$callstr .= "&BILLINGPERIOD=Month";
	$callstr .= "&BILLINGFREQUENCY=1";
	$callstr .= "&AMT=" . $_SESSION['pp_amt'];
	$callstr .= "&CURRENCYCODE=USD";
	$callstr .= "&L_PAYMENTREQUEST_0_ITEMCATEGORY0=Digital";
	$callstr .= "&L_PAYMENTREQUEST_0_NAME0=" . $_SESSION['pp_desc'];
	$callstr .= "&L_PAYMENTREQUEST_0_AMT0=" . $_SESSION['pp_amt'];
	$callstr .= "&L_PAYMENTREQUEST_0_QTY0=1";

	date_default_timezone_set('UTC');
	$date = date("Y\-m\-d\TH\:i\:s\Z");
	$_SESSION['preauth_date'] = $date;
	$callstr .= "&PROFILESTARTDATE=" . $date;

	$res = callPP('CreateRecurringPaymentsProfile', $callstr);
	return $res;
    }

    /**
    * Call PayPal with passed method (using curl)
    * @param Method name, url param string, method only flag (if true then don't add merchant details or version)
    * @return array from PayPal
    */
    function callPP($method, $str, $method_only=false)
    {
	$ch = curl_init();

	list ($ppname, $pppass, $ppsig, $ppsandbox) = getPayPalMerchantDetails();
	if($ppsandbox)
	{
		$url = "https://api-3t.sandbox.paypal.com/nvp";
	}
	else
	{
		$url = "https://api-3t.paypal.com/nvp";
	}

	$nvp = "METHOD=" . urlencode($method);
	if(!$method_only)
	{
		$nvp .= "&VERSION=104.0";
		$nvp .= "&user=" . urlencode($ppname);
		$nvp .= "&pwd=" . urlencode($pppass);
		$nvp .= "&signature=" . urlencode($ppsig);
	}

	$nvp .= $str;

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);
	$resp = curl_exec($ch);
	curl_close($ch);

	$ret = expandNameValuePairs($resp);
	return $ret;
    }

    /**
    * Split name value pairs to make a hash array
    * @param NVP string
    * @return array 
    */
    function expandNameValuePairs($str)
    {
	$intial=0;
	$nvpArray = array();

	foreach(explode('&', $str) as $s)
	{
		$data = explode('=', $s);
		$k = strtoupper(urldecode($data[0]));	
		$v = strtoupper(urldecode($data[1]));	
		$nvpArray[$k] = $v;
	}	
	return $nvpArray;
    }

    /**
    * Redirect to PayPal for payment
    * @param token
    * @return none
    */
    function redirectToPayPal($token)
    {
	list ($ppname, $pppass, $ppsig, $ppsandbox) = getPayPalMerchantDetails();
	if($ppsandbox)
	{
		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
	}
	else
	{
		$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
	}

	$url .= $token;
	header('Location: ' . $url);
    }

    /**
    * Cancel PayPal agreement
    * @param User_id
    * @return none
    */
    function cancelPayments($id)
    {
	$pp = getPaymentProfile($id);
	$nvp = "&PROFILEID=$pp&ACTION=Cancel";
error_log(">>>$nvp");
	$res = callPP('ManageRecurringPaymentsProfileStatus', $nvp, false);
foreach($res as $k => $v)
{
	error_log(">>>$k=$v");
}
    }

    /**
    * Update paypal billing amount. PayPal will only allow a 20% increase in payment amounts in each 180 period
    * so the best way to do it is to cancel the existing plan and create a new one.
    * @param user_id, new plan number
    * @return true if able to update amount
    */
    function updatePayments($id, $new_plan)
    {
	// Paypal processing....
	// Set up payment authorisation
	list ($title, $price, $notes) = getPlan($new_plan);
	$desc = "notispad $title";

	$cancelUrl = 'http://pbembid.com:8888/config.php';
	$returnUrl = 'http://pbembid.com:8888/processpayment.php?config';

	$ret = SetExpressCheckout($desc, $cancelUrl, $returnUrl, getEmail($id), $price);
	// Check that we're successful and call with token if we are
	if(isset($ret['ACK']) && ($ret['ACK'] == "SUCCESS"))
	{
		$_SESSION['plan_change_plan'] = $new_plan;
		redirectToPayPal($ret['TOKEN']);
	}
	exit();
    }
?>
