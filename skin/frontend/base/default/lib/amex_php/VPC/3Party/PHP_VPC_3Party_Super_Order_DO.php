<?php


// Initialisation
// ==============

// 
include('VPCPaymentConnection.php');
$conn = new VPCPaymentConnection();


// This is secret for encoding the MD5 hash
// This secret will vary from merchant to merchant

$secureSecret = "F965E1D338862A60F3CADBFA45F42C29";

// Set the Secure Hash Secret used by the VPC connection object
$conn->setSecureSecret($secureSecret);

$proxy = "";

// *******************************************
// START OF MAIN PROGRAM
// *******************************************

// This is the URL link for another transaction
// add the againLink to the array
// Shows how a user field (such as an application Session ID) could be added
$_POST['AgainLink']=urlencode($HTTP_REFERER);

// Sort the POST data - it's important to get the ordering right
ksort ($_POST);

// add the start of the vpcURL querystring parameters
$vpcURL = $_POST["virtualPaymentClientURL"];

// This is the title for display
$title  = $_POST["Title"];


// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
unset($_POST["virtualPaymentClientURL"]); 
unset($_POST["SubButL"]);


// Add VPC post data to the Digital Order
foreach($_POST as $key => $value) {
	if (strlen($value) > 0) {
		$conn->addDigitalOrderField($key, $value);
	}
}

// Add original order HTML so that another transaction can be attempted.
//$conn->addDigitalOrderField("AgainLink", $againLink);


// Obtain a one-way hash of the Digital Order data and add this to the Digital Order
$secureHash = $conn->hashAllFields();
$conn->addDigitalOrderField("vpc_SecureHash", $secureHash);

// Obtain the redirection URL and redirect the web browser
$vpcURL = $conn->getDigitalOrder($vpcURL);



header("Location: ".$vpcURL);
//echo "<a href=$vpcURL>$vpcURL</a>";

//The below echo commands is to assist the Debugging of hashing
//echo "$vpcURL";
//$hashinput = $conn->returnhashinput();
//echo "$secureHash";
//echo "$hashinput";


?>