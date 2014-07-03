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
	//if(isset($_SESSION['preauth_email']))
	//{
		//$callstr .= "&EMAIL=" . $_SESSION['preauth_email'];
	//}
	//elseif(isset($_SESSION['email']))
	//{
		//$callstr .= "&EMAIL=" . $_SESSION['email'];
	//}
	
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
	$custom = createUpdateTicket(getSubscrId($_SESSION['user_id']));

echo '<!DOCTYPE html>' . "\n";
echo '<html lang=en>' . "\n";
echo '  <meta name="viewport" content="width=device-width, initial-scale=0.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>' . "\n";
echo '  <title>Loading...</title>' . "\n";
echo '  <style>' . "\n";
echo '.l{position:absolute;top:50%;left:50%;width:7.33333em;height:7.33333em;margin-left:-3.66667em;margin-top:-3.66667em}.l-b{position:absolute;top:0;left:0;display:inline-block;opacity:0;width:2em;height:2em;background:#fdfdfd;-webkit-animation:show .88s step-end infinite alternate,pulse .88s linear infinite alternate;animation:show .88s step-end infinite alternate,pulse .88s linear infinite alternate}.l-b:nth-child(1){-moz-transform:translate(0,0);-ms-transform:translate(0,0);-o-transform:translate(0,0);-webkit-transform:translate(0,0);transform:translate(0,0);-webkit-animation-delay:.065s;animation-delay:.065s}.l-b:nth-child(2){-moz-transform:translate(2.66667em,0);-ms-transform:translate(2.66667em,0);-o-transform:translate(2.66667em,0);-webkit-transform:translate(2.66667em,0);transform:translate(2.66667em,0);-webkit-animation-delay:.13s;animation-delay:.13s}.l-b:nth-child(3){-moz-transform:translate(5.33333em,0);-ms-transform:translate(5.33333em,0);-o-transform:translate(5.33333em,0);-webkit-transform:translate(5.33333em,0);transform:translate(5.33333em,0);-webkit-animation-delay:.195s;animation-delay:.195s}.l-b:nth-child(4){-moz-transform:translate(0,2.66667em);-ms-transform:translate(0,2.66667em);-o-transform:translate(0,2.66667em);-webkit-transform:translate(0,2.66667em);transform:translate(0,2.66667em);-webkit-animation-delay:.325s;animation-delay:.325s}.l-b:nth-child(5){-moz-transform:translate(2.66667em,2.66667em);-ms-transform:translate(2.66667em,2.66667em);-o-transform:translate(2.66667em,2.66667em);-webkit-transform:translate(2.66667em,2.66667em);transform:translate(2.66667em,2.66667em);-webkit-animation-delay:.13s;animation-delay:.13s}.l-b:nth-child(6){-moz-transform:translate(5.33333em,2.66667em);-ms-transform:translate(5.33333em,2.66667em);-o-transform:translate(5.33333em,2.66667em);-webkit-transform:translate(5.33333em,2.66667em);transform:translate(5.33333em,2.66667em);-webkit-animation-delay:.455s;animation-delay:.455s}.l-b:nth-child(7){-moz-transform:translate(0,5.33333em);-ms-transform:translate(0,5.33333em);-o-transform:translate(0,5.33333em);-webkit-transform:translate(0,5.33333em);transform:translate(0,5.33333em);-webkit-animation-delay:.39s;animation-delay:.39s}.l-b:nth-child(8){-moz-transform:translate(2.66667em,5.33333em);-ms-transform:translate(2.66667em,5.33333em);-o-transform:translate(2.66667em,5.33333em);-webkit-transform:translate(2.66667em,5.33333em);transform:translate(2.66667em,5.33333em);-webkit-animation-delay:.26s;animation-delay:.26s}.l-b:nth-child(9){-moz-transform:translate(5.33333em,5.33333em);-ms-transform:translate(5.33333em,5.33333em);-o-transform:translate(5.33333em,5.33333em);-webkit-transform:translate(5.33333em,5.33333em);transform:translate(5.33333em,5.33333em)}@-webkit-keyframes pulse{40%,from{background:#add8e6}to{background:#fff}}@-webkit-keyframes show{40%,from{opacity:0}41%,to{opacity:1}}@keyframes pulse{40%,from,to{background:#add8e6}}@keyframes show{40%,from{opacity:0}41%,to{opacity:1}}body,html{background:#4CAED3;text-align:center}' . "\n";
echo '  </style>' . "\n";
echo '  <div class="l">' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
echo '    <span class="l-b"></span>' . "\n";
	echo "<form id='redir' action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post'>";

	echo "<input type='hidden' name='cmd' value='_xclick-subscriptions'>";
	echo "<input type='hidden' name='business' value='notispad@gmail.com'>";
	echo "<input type='hidden' id='item_name' name='item_name' value='$desc'>";
	echo "<input type='hidden' id='a3' name='a3' value='$price'>";
	echo "<input type='hidden' name='p3' value='1'>";
	echo "<input type='hidden' name='t3' value='M'>";
	echo "<input type='hidden' name='src' value='1'>";
	echo "<input type='hidden' name='no_shipping' value='1'>";
	echo "<input type='hidden' name='custom' value='$custom'>";

	echo "</form>\n";
	echo "<script>\n";
	echo "function submitForm()\n";
	echo "{ document.getElementById('redir').submit(); }\n";
	echo "window.onload = submitForm;\n";
	echo "</script>\n";
echo '  </div>' . "\n";
echo '</html>' . "\n";

	exit();
    }
?>
