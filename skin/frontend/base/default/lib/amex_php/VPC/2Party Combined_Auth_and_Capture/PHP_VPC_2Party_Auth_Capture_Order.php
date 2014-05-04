<?php
/*
 *
 * Version 1.0
 *
 * ----------------- Disclaimer ------------------------------------------------
 *
 * Copyright © 2007 Dialect Payment Technologies - a Transaction Network
 * Services company.  All rights reserved.
 *
 * This program is provided by Dialect Payment Technologies on the basis that
 * you will treat it as confidential.
 *
 * No part of this program may be reproduced or copied in any form by any means
 * without the written permission of Dialect Payment Technologies.  Unless
 * otherwise expressly agreed in writing, the information contained in this
 * program is subject to change without notice and Dialect Payment Technologies
 * assumes no responsibility for any alteration to, or any error or other
 * deficiency, in this program.
 *
 * 1. All intellectual property rights in the program and in all extracts and 
 *    things derived from any part of the program are owned by Dialect and will 
 *    be assigned to Dialect on their creation. You will protect all the 
 *    intellectual property rights relating to the program in a manner that is 
 *    equal to the protection you provide your own intellectual property.  You 
 *    will notify Dialect immediately, and in writing where you become aware of 
 *    a breach of Dialect's intellectual property rights in relation to the
 *    program.
 * 2. The names "Dialect", "QSI Payments" and all similar words are trademarks
 *    of Dialect Payment Technologies and you must not use that name or any 
 *    similar name.
 * 3. Dialect may at its sole discretion terminate the rights granted in this 
 *    program with immediate effect by notifying you in writing and you will 
 *    thereupon return (or destroy and certify that destruction to Dialect) all 
 *    copies and extracts of the program in its possession or control.
 * 4. Dialect does not warrant the accuracy or completeness of the program or  
 *    its content or its usefulness to you or your merchant customers.  To the  
 *    extent permitted by law, all conditions and warranties implied by law  
 *    (whether as to fitness for any particular purpose or otherwise) are  
 *    excluded. Where the exclusion is not effective, Dialect limits its  
 *    liability to $100 or the resupply of the program (at Dialect's option).
 * 5. Data used in examples and sample data files are intended to be fictional 
 *    and any resemblance to real persons or companies is entirely coincidental.
 * 6. Dialect does not indemnify you or any third party in relation to the
 *   content or any use of the content as contemplated in these terms and 
 *    conditions. 
 * 7. Mention of any product not owned by Dialect does not constitute an 
 *    endorsement of that product.
 * 8. This program is governed by the laws of New South Wales, Australia and is 
 *    intended to be legally binding. 
 * ---------------------------------------------------------------------------*/

/**
 * Please refer to the following guides for more information:
 *     1. Payment Client Integration Guide
 *        this details how to integrate with Payment Client 3.1.
 *     2. Payment Client Reference Guide
 *        this guide details all the input and return parameters that are used
 *        by the Payment Client and Payment Server for a Payment Client
 *        integration.
 *     3. Payment Client Install Guide
 *        this guide details the installation of Payment Client 3.1 and related
 *        issues.
 *
 * @author Dialect Payment Technologies
 *
 */
 

 

// Initialisation
// ==============

// 
include('VPCPaymentConnection.php');
$conn = new VPCPaymentConnection();
$capt = new VPCPaymentConnection();



// If a proxy server is required then set $proxy to "hostname:port".
// Example: $proxy = "servername:8080";

$proxy = "tns-proxy-bris:800";





// *******************************************
// START OF MAIN PROGRAM
// *******************************************


// add the start of the vpcURL querystring parameters
$vpcURL = $_POST["virtualPaymentClientURL"];

// This is the title for display
$title  = $_POST["Title"];


// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
unset($_POST["virtualPaymentClientURL"]); 
unset($_POST["SubButL"]);
unset($_POST["Title"]);

// Add VPC post data to the Digital Order
foreach($_POST as $key => $value) {
	if (strlen($value) > 0) {
		$conn->addDigitalOrderField($key, $value);
	}
}
$accessCode       = $_POST["vpc_AccessCode"];
$username 			  = $_POST["vpc_User"];
$password 			  = $_POST["vpc_Password"];

// Send the Digital Order to the Payment Server
$conn->sendMOTODigitalOrder($vpcURL, $proxy);


// don't overwrite message if any error messages detected
if (strlen($conn->getErrorMessage()) == 0) {
    $message            = $conn->getResultField("vpc_Message");
}

// Standard Receipt Data
$amount          = $conn->getResultField("vpc_Amount");
$locale          = $conn->getResultField("vpc_Locale");
$batchNo         = $conn->getResultField("vpc_BatchNo");
$command         = $conn->getResultField("vpc_Command");
$version         = $conn->getResultField("vpc_Version");
$cardType        = $conn->getResultField("vpc_Card");
$orderInfo       = $conn->getResultField("vpc_OrderInfo");
$receiptNo       = $conn->getResultField("vpc_ReceiptNo");
$merchantID      = $conn->getResultField("vpc_Merchant");
$merchTxnRef     = $conn->getResultField("vpc_MerchTxnRef");
$authorizeID     = $conn->getResultField("vpc_AuthorizeId");
$transactionNo   = $conn->getResultField("vpc_TransactionNo");
$acqResponseCode = $conn->getResultField("vpc_AcqResponseCode");
$txnResponseCode = $conn->getResultField("vpc_TxnResponseCode");

// CSC Receipt Data
$cscResultCode  = $conn->getResultField("vpc_CSCResultCode");
$cscACQRespCode = $conn->getResultField("vpc_AcqCSCRespCode");

// AVS Receipt Data
$avsResultCode  = $conn->getResultField("vpc_AVSResultCode");
$avsACQRespCode = $conn->getResultField("vpc_AcqAVSRespCode");

// Get the descriptions behind the QSI, CSC and AVS Response Codes
// Only get the descriptions if the string returned is not equal to "No Value Returned".

$txnResponseCodeDesc = "";
$cscResultCodeDesc = "";
$avsResultCodeDesc = "";
    
if ($txnResponseCode != "No Value Returned") {
    $txnResponseCodeDesc = getResultDescription($txnResponseCode);
}

if ($cscResultCode != "No Value Returned") {
    $cscResultCodeDesc = getCSCResultDescription($cscResultCode);
}

if ($avsResultCode != "No Value Returned") {
    $avsResultCodeDesc = getAVSResultDescription($avsResultCode);
}
    

$error = "";
// Show this page as an error page if error condition
if ($txnResponseCode=="7" || $txnResponseCode=="No Value Returned") {
    $error = "Error ";
}

$captAttempted = false;
$captMerchTxnRef = $merchTxnRef;
$captMerchTxnRef = $captMerchTxnRef."-C";
// Now that we have a successful authorisation, we can process the capture request.
if ($txnResponseCode == "0") {
	$captAttempted = true;


	
	$capt->addDigitalOrderField("vpc_Version","1");
	$capt->addDigitalOrderField("vpc_Command","capture");
	$capt->addDigitalOrderField("vpc_AccessCode", $accessCode);
	$capt->addDigitalOrderField("vpc_MerchTxnRef",$captMerchTxnRef);
	$capt->addDigitalOrderField("vpc_Merchant", $merchantID);
	$capt->addDigitalOrderField("vpc_TransNo", $transactionNo);
	$capt->addDigitalOrderField("vpc_Amount",$amount);
  $capt->addDigitalOrderField("vpc_User", $username);
	$capt->addDigitalOrderField("vpc_Password", $password);
	
	// Send the capture request to the Payment Server
	$capt->sendMOTODigitalOrder($vpcURL, $proxy);
	// don't overwrite message if any error messages detected
	if (strlen($capt->getErrorMessage()) == 0) {
    $captMessage            = $capt->getResultField("vpc_Message");
	}

	// Standard Receipt Data
	$captMerchTxnRef     = $capt->getResultField("vpc_MerchTxnRef");

	$captAmount          = $capt->getResultField("vpc_Amount");
	$captBatchNo         = $capt->getResultField("vpc_BatchNo");
	$captCommand         = $capt->getResultField("vpc_Command");
	$captVersion         = $capt->getResultField("vpc_Version");
	$captOrderInfo       = $capt->getResultField("vpc_OrderInfo");
	$captReceiptNo       = $capt->getResultField("vpc_ReceiptNo");
	$captAuthorizeID     = $capt->getResultField("vpc_AuthorizeId");
	$captTransactionNr   = $capt->getResultField("vpc_TransactionNo");
	$captAcqResponseCode = $capt->getResultField("vpc_AcqResponseCode");
	$captTxnResponseCode = $capt->getResultField("vpc_TxnResponseCode");

	// AMA Transaction Data
	$captShopTransNo     = $capt->getResultField("vpc_ShopTransactionNo");
	$captAuthorisedAmount= $capt->getResultField("vpc_AuthorisedAmount");
	$captCapturedAmount  = $capt->getResultField("vpc_CapturedAmount");
	$captRefundedAmount  = $capt->getResultField("vpc_RefundedAmount");
	$captTicketNumber    = $capt->getResultField("vpc_TicketNo");

	if ($captTxnResponseCode != "No Value Returned") {
  	  $captTxnResponseCodeDesc = getResultDescription($captTxnResponseCode);
	}
	
	if (($captTxnResponseCode == "7") || ($captTxnResponseCode == "No Value Returned")) {
			$captError = "Error ";
	}
} else {
	$captMessage = "Capture not attempted due to Authorisation Failure - see above"; 
}    
// FINISH TRANSACTION - Process the VPC Response Data
// =====================================================
// For the purposes of demonstration, we simply display the Response fields
// on a web page.

?>                 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html>
    <head>
        <title><?=$title?> - <?=$error?>Response Page</title>
        <meta http-equiv="Content-Type" content="text/html, charset=iso-8859-1">
        <style type="text/css">
            <!--
            h1       { font-family:Arial,sans-serif; font-size:20pt; font-weight:600; margin-bottom:0.1em; color:#08185A;}
            h2       { font-family:Arial,sans-serif; font-size:14pt; font-weight:100; margin-top:0.1em; color:#08185A;}
            h2.co    { font-family:Arial,sans-serif; font-size:24pt; font-weight:100; margin-top:0.1em; margin-bottom:0.1em; color:#08185A}
            h3       { font-family:Arial,sans-serif; font-size:16pt; font-weight:100; margin-top:0.1em; margin-bottom:0.1em; color:#08185A}
            h3.co    { font-family:Arial,sans-serif; font-size:16pt; font-weight:100; margin-top:0.1em; margin-bottom:0.1em; color:#FFFFFF}
            body     { font-family:Verdana,Arial,sans-serif; font-size:10pt; background-color:#FFFFFF; color:#08185A}
            th       { font-family:Verdana,Arial,sans-serif; font-size:8pt; font-weight:bold; background-color:#CED7EF; padding-top:0.5em; padding-bottom:0.5em;  color:#08185A}
            tr       { height:25px; }
            .shade   { height:25px; background-color:#CED7EF }
            .title   { height:25px; background-color:#0074C4 }
            td       { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A }
            td.red   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0066 }
            td.green { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#008800 }
            p        { font-family:Verdana,Arial,sans-serif; font-size:10pt; color:#FFFFFF }
            p.blue   { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#08185A }
            p.red    { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#FF0066 }
            p.green  { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#008800 }
            div.bl   { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#0074C4 }
            div.red  { font-family:Verdana,Arial,sans-serif; font-size:7pt;  color:#FF0066 }
            li       { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#FF0066 }
            input    { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:bold }
            select   { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:bold; }
            textarea { font-family:Verdana,Arial,sans-serif; font-size:8pt;  color:#08185A; background-color:#CED7EF; font-weight:normal; scrollbar-arrow-color:#08185A; scrollbar-base-color:#CED7EF }
            -->
        </style>
    </head>
    <body>
        <!-- Start Branding Table -->
        <table width="100%" border="2" cellpadding="2" class="title">
            <tr>
                <td class="shade" width="90%"><h2 class="co">&nbsp;Virtual Payment Client Example</h2></td>
                <td class="title" align="center"><h3 class="co">Dialect<br />Payments</h3></td>
            </tr>
        </table>
        <!-- End Branding Table -->
        <center><h1><?=$title?> - <?=$error?>Response Page</h1></center>
        <table width="85%" align="center" cellpadding="5" border="0">
            <tr class='title'>
                <td colspan="2" height="25"><p><strong>&nbsp;Basic 2-Party Transaction Fields</strong></p></td>
            </tr>
            <tr>
                <td align="right" width="50%"><strong><i>VPC API Version: </i></strong></td>
                <td width="50%"><?=$version?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Command: </i></strong></td>
                <td><?=$command?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>Merchant Transaction Reference: </i></strong></td>
                <td><?=$merchTxnRef?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Merchant ID: </i></strong></td>
                <td><?=$merchantID?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>Order Information: </i></strong></td>
                <td><?=$orderInfo?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Amount: </i></strong></td>
                <td><?=$amount?></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <font color="#0074C4">Fields above are the primary request values.<br />
                    <hr />
                    Fields below are the response fields for a Standard Transaction.<br /></font>
                </td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>VPC Transaction Response Code: </i></strong></td>
                <td><?=$txnResponseCode?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>Transaction Response Code Description: </i></strong></td>
                <td><?=$txnResponseCodeDesc?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Message: </i></strong></td>
                <td><?=(($conn->getErrorMessage()=="") ? $message : $conn->getErrorMessage()) ?></td>
            </tr>
<? 
    // Only display the following fields if not an error condition
    if ($txnResponseCode!="7" && $txnResponseCode!="No Value Returned") { 
?>
            <tr>
                <td align="right"><strong><i>Receipt Number: </i></strong></td>
                <td><?=$receiptNo?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Transaction Number: </i></strong></td>
                <td><?=$transactionNo?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>Acquirer Response Code: </i></strong></td>
                <td><?=$acqResponseCode?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Bank Authorization ID: </i></strong></td>
                <td><?=$authorizeID?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>Batch Number: </i></strong></td>
                <td><?=$batchNo?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>Card Type: </i></strong></td>
                <td><?=$cardType?></td>
            </tr>
            <? if ($captAttempted) {
            ?>
            <tr class="title">
                <td colspan="2"><p><strong>&nbsp;Capture Transaction Receipt Fields</strong></p></td>
            </tr>
            <tr>    
                <td align="right"><strong><em>Capture Merchant Transaction Reference: </em></strong></td>
                <td><?=$captMerchTxnRef?></td>
            </tr>
            <tr class ="shade">    
                <td align="right"><strong><em>Capture Financial Transaction Number: </em></strong></td>
                <td><?=$captTransactionNr?></td>
            </tr>
            <tr>    
                <td align="right"><strong><em>Capture Amount: </em></strong></td>
                <td><?=$captAmount?></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <div class='bl'>Fields above are the primary request values.<hr>Fields below are receipt data fields.</div>
                </td>
            </tr>
            <tr>    
                <td align="right"><strong><em>Capture QSI Response Code: </em></strong></td>
                <td><?=$captTxnResponseCode?></td>
            </tr>
            <tr class="shade">
                <td align='right'><strong><em>Capture QSI Response Code Description: </em></strong></td>
                <td><?=$captTxnResponseCodeDesc?></td>
            </tr>
            <tr>    
                <td align="right"><strong><em>Capture Acquirer Response Code: </em></strong></td>
                <td><?=$captAcqResponseCode?></td>
            </tr>
            <tr class='shade'>
                <td align='right'><em><strong>Receipt No: </strong></em></td>
                <td><?=$captReceiptNo?></td>
            </tr>
            <tr>                  
                <td align='right'><em><strong>Authorize Id: </strong></em></td>
                <td><?=$captAuthorizeID?></td>
            </tr>
            <?
            } else {
            
            ?>
            <tr class='title'>
                <td colspan='2'><p><strong>&nbsp;Capture Transaction Receipt Fields</strong></p></td>
            </tr>
            <tr>
                <td align='right'><strong><em>Capture Error: </em></strong></td>
                <td><?=$captMessage?></td>
            </tr>
            <?    
            }
            ?>
            <tr>
                <td colspan="2" align="center">
                    <font color="#0074C4">Fields above are for a Standard Transaction<br />
                    <hr />
                    Fields below are additional fields for extra functionality.</font><br />
                </td>
            </tr>
            <tr class='title'>
                <td colspan="2" height="25"><p><strong>&nbsp;Card Security Code Fields</strong></p></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>CSC Acquirer Response Code: </i></strong></td>
                <td><?=$cscACQRespCode?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>CSC QSI Result Code: </i></strong></td>
                <td><?=$cscResultCode?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>CSC Result Description: </i></strong></td>
                <td><?=$cscResultCodeDesc?></td>
            </tr>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <tr class='title'>
                <td colspan="2" height="25"><p><strong>&nbsp;Address Verification Service Fields</strong></p></td>
            </tr>
            <tr>
                <td align="right"><strong><i>AVS Acquirer Response Code: </i></strong></td>
                <td><?=$avsACQRespCode?></td>
            </tr>
            <tr class='shade'>
                <td align="right"><strong><i>AVS QSI Result Code: </i></strong></td>
                <td><?=$avsResultCode?></td>
            </tr>
            <tr>
                <td align="right"><strong><i>AVS Result Description: </i></strong></td>
                <td><?=$avsResultCodeDesc?></td>
            </tr>
<? } ?>
        </table>
        <center><p><a href='PHP_VPC_2Party_Super_Order.html'>New Transaction</a></p></center>
    </body>
</html>