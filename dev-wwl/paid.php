<?php 
session_start();
include_once 'dbconnect.php';
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}
//Total Credits
$totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
$cr_rs=mysqli_query($DBcon,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($DBcon));
$cr_row=mysqli_fetch_array($cr_rs);
$total_credit_cr=$cr_row['credits_cr'];

$totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
$db_rs=mysqli_query($DBcon,$totalcredits_db) or die("Cannot Execute query".mysqli_error($DBcon));
$db_row=mysqli_fetch_array($db_rs);
$total_credit_db=$db_row['credits_cr'];
$mycredits=$total_credit_cr-$total_credit_db;
// paypal credentials */
$ppappid="APP-80W284485P519543T";
$ppuserid="merchant_workdeepti6_api1.gmail.com";
$pppass="NNYEBLW82J6LCD7Y";
$ppsig="AFcWxV21C7fd0v3bYYYRCpSSRl31AQrzyIIuwQ9LX5XiidQ4BHAAKOuQ";

$amountval=1/100*$_REQUEST['withdraw'];
$amount=$_REQUEST['withdraw'];
$mail=$_REQUEST['email'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];


// check paypal email is valid or not 


$url = trim("https://svcs.sandbox.paypal.com/AdaptiveAccounts/GetVerifiedStatus");  //set PayPal Endpoint to sandbox
//$url = trim("https://svcs.paypal.com/AdaptiveAccounts/GetVerifiedStatus");         //set PayPal Endpoint to Live 

$bodyparams = array (   "requestEnvelope.errorLanguage" => "en_US",
                        "emailAddress" =>$mail,
                        "firstName" =>$fname,
                        "lastName" =>$lname,
                        "matchCriteria" => "NAME"
                    );


 $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
	'X-PAYPAL-REQUEST-DATA-FORMAT: JSON',
	'X-PAYPAL-RESPONSE-DATA-FORMAT: JSON',
	'X-PAYPAL-SECURITY-USERID: '. $ppuserid,
	'X-PAYPAL-SECURITY-PASSWORD: '. $pppass,
	'X-PAYPAL-SECURITY-SIGNATURE: '. $ppsig,
	'X-PAYPAL-APPLICATION-ID: '. $ppappid
));  
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($bodyparams));//
$response = curl_exec($ch);
 $response = json_decode($response, 1);
 //print_r($response);
//echo $response['responseEnvelope']["ack"];

if($response['responseEnvelope']["ack"]<>"Failure")
{

if(($mycredits>=$amount) and $amount>0)
{
$payLoad=array();

//prepare the receivers
//"dushyant108d-facilitator@gmail.com"
$transaction=time().uniqid();
$receiverList=array();
$counter=0;
$ppapicall="sandbox";
$receiverList["receiver"][$counter]["amount"]=$amountval;
$receiverList["receiver"][$counter]["email"]=$mail;
$receiverList["receiver"][$counter]["paymentType"]="PERSONAL";//this could be SERVICE or PERSONAL (which makes it free!)
$receiverList["receiver"][$counter]["invoiceId"]=$transaction;//NB that this MUST be unique otherwise paypal will reject it and get shitty. However it is a totally optional field

//prepare the call
$payLoad["actionType"]="PAY";
$payLoad["cancelUrl"]="http://winwinlabs.com/developer/winwinlabs/index.php";//this is required even though it isnt used
$payLoad["returnUrl"]="http://winwinlabs.com/developer/winwinlabs/success.php";//this is required even though it isnt used
$payLoad["currencyCode"]="USD";
$payLoad["receiverList"]=$receiverList;
//$payLoad["feesPayer"]="DEEPTI Malhotra";//this could be SENDER or EACHRECEIVER
$payLoad["fundingConstraint"]=array("allowedFundingType"=>array("fundingTypeInfo"=>array("fundingType"=>"BALANCE")));//defaults to ECHECK but this takes ages and ages, so better to reject the payments if there isnt enough money in the account and then do a manual pull of bank funds through; more importantly, echecks have to be accepted/rejected by the user and i THINK balance doesnt
$payLoad["sender"]["email"]="merchant_workdeepti6@gmail.com";//the paypal email address of the where the money is coming from




//run the call
$API_Endpoint = "https://svcs.$ppapicall.paypal.com/AdaptivePayments/Pay";
$payLoad["requestEnvelope"]=array("errorLanguage"=>urlencode("en_US"),"detailLevel"=>urlencode("ReturnAll"));//add some debugging info the payLoad and setup the requestEnvelope
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
	'X-PAYPAL-REQUEST-DATA-FORMAT: JSON',
	'X-PAYPAL-RESPONSE-DATA-FORMAT: JSON',
	'X-PAYPAL-SECURITY-USERID: '. $ppuserid,
	'X-PAYPAL-SECURITY-PASSWORD: '. $pppass,
	'X-PAYPAL-SECURITY-SIGNATURE: '. $ppsig,
	'X-PAYPAL-APPLICATION-ID: '. $ppappid
));  
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payLoad));//
$response = curl_exec($ch);
 $response = json_decode($response, 1);
 //print_r($response);

//analyse the output
$payKey = $response["payKey"];
$paymentExecStatus=$response["paymentExecStatus"];
$correlationId=$response["responseEnvelope"]["correlationId"];
$paymentInfoList = isset($response["paymentInfoList"]) ? $response["paymentInfoList"] : null;

if ($paymentExecStatus<>"ERROR") {

if(isset($paymentInfoList["paymentInfo"]))
{
foreach($paymentInfoList["paymentInfo"] as $paymentInfo) 
{//they will only be in this array if they had a paypal account
$receiverEmail = $paymentInfo["receiver"]["email"];
$receiverAmount = $paymentInfo["receiver"]["amount"];
$withdrawalID = $paymentInfo["receiver"]["invoiceId"];
$transactionId = $paymentInfo["transactionId"];//what shows in their paypal account
$senderTransactionId = $paymentInfo["senderTransactionId"];//what shows in our paypal account
$senderTransactionStatus = $paymentInfo["senderTransactionStatus"];
$pendingReason = isset($paymentInfo["pendingReason"]) ? $paymentInfo["pendingReason"] : null;
}
}

$status="withdraw Credits in ".$mail;
if($transactionId=="")
{
    $transactionId=$transaction;
}
$date = date('Y-m-d H:i:s');
$totalcredits=$mycredits-$amount;
$q="INSERT INTO payments(Credits,User_ID,Date,Notes,Status,game_id,item_number,txn_id,payment_gross,currency_code,payment_status,total_credits) VALUES('".$amount."','".$_SESSION['userSession']."','".$date."','".$status."','2','','','".$transactionId."','".$amountval."','','','".$totalcredits."')";
$insert = mysqli_query($DBcon,$q) or die("Cannot Execute query".mysqli_error($db).$q);

echo "2: Payment Transaction is Successful.";
}else{
    $paymentInfoList = isset($response["payErrorList"]) ? $response["payErrorList"] : null;
    foreach($paymentInfoList["payError"] as $paymentInfo) {
        echo  $error="1 : Paypal Error - ".$paymentInfo["error"]["message"];
//deal with it
    }
}
}
else
{
    echo "1 : Sorry! You do not sufficient balance for this transaction.";
}
}
else
{
    foreach($response["error"] as $paymentInfo) 
    {
        $error= $paymentInfo['message'];
    }
    echo "1 : Paypal Error - ".$error;
}
