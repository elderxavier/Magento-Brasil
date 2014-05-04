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
 


// AMA User Configuration
// ======================


$amaUsername = "amauser";
$amaPassword = "monday123";




// Initialisation
// ==============

// 
include('PaymentClientConnection.php');
$conn = new PaymentClientConnection();

// Check whether the user has selected to output the socket commands
$getDebug = $_GET["DebugOn"];
$conn->debug = $getDebug;

// Connect to the Payment Client
$payClientIP    = $_GET["HostName"];
$portNo         = $_GET["Port"];
$conn->connect($payClientIP,$portNo);

// Test the Payment Client socket was created successfully
$conn->echoTest();


// *********************
// START OF MAIN PROGRAM
// *********************



// Digital receipt variables
$merchTxnRef         = "";
$merchantID          = "";
$orderInfo           = "";
$amount              = "";

$qsiResponseCode     = "";
$qsiResponseCodeDesc = "";
$resCode             = "";
$transactionNr       = "";
$receiptNo           = "";
$authorizeID         = "";
$cardType            = "";
$cscResultCode       = "";
$cscResultCodeDesc   = "";
$avsResultCode       = "";
$avsResultCodeDesc   = "";
$batchNo             = "";

$captureQSIResponseCode     = "No Capture Performed";
$captureQSIResponseCodeDesc = "No Capture Performed";
$captureReceiptNo           = "No Capture Performed";
$captureAcqResponseCode     = "No Capture Performed";
$captureBatchNo             = "No Capture Performed";
$captureTransactionNo       = "No Capture Performed";
$captureCardType            = "No Capture Performed";
$captureResult              = "No Capture Performed";
$captureMerchTxnRef         = "No Capture Performed";


// Decrypt the Digital Receipt

$encryptedDR = $_GET["DR"];
$conn->decryptDR($encryptedDR);


// Get the QSI response code
$qsiResponseCode = $conn->getResultField("DigitalReceipt.QSIResponseCode");


// If there is no error with the Payment Client Connection object then also
// check for a Digital Receipt error anyway

$errorMessage = $conn->getErrorMessage();

if (($errorMessage == "") || ($qsiResponseCode != "0")) {
	$errorMessage = $conn->getResultField("DigitalReceipt.ERROR");
}



$merchantID = $conn->getResultField("DigitalReceipt.MerchantId");
$merchTxnRef = $conn->getResultField("DigitalReceipt.MerchTxnRef");
$orderInfo = $conn->getResultField("DigitalReceipt.OrderInfo");
$amount = $conn->getResultField("DigitalReceipt.PurchaseAmountInteger");


// Obtain Digital Receipt data if there are no errors

if ($errorMessage == "") {
	
	$receiptNo = $conn->getResultField("DigitalReceipt.ReceiptNo");
	$resCode = $conn->getResultField("DigitalReceipt.AcqResponseCode");
	$authorizeID = $conn->getResultField("DigitalReceipt.AuthorizeId");
	$batchNo = $conn->getResultField("DigitalReceipt.BatchNo");
	$transactionNr = $conn->getResultField("DigitalReceipt.TransactionNo");
	$cardType = $conn->getResultField("DigitalReceipt.CardType");
	$cscResultCode = $conn->getResultField("DigitalReceipt.CSCResultCode");
	$avsResultCode = $conn->getResultField("DigitalReceipt.AVSResultCode");
	
	$qsiResponseCodeDesc = getResultDescription($qsiResponseCode);
	$cscResultCodeDesc = getCSCResultDescription($cscResultCode);
	$avsResultCodeDesc = getAVSResultDescription($avsResultCode);

	  



}

// we are now finished with the socket so close it
	$conn->close();
    



// Perform a capture only if the authorisation was approved.
// **************************************************************

if (($errorMessage == "") && ($qsiResponseCode == "0")) {
	
	// Create a new Payment Client Connection object to perform the capture
	$captConn = new PaymentClientConnection();
	
	// Set debugging on or off
	$captConn->debug = $_GET["DebugOn"]=="1" ? true : false;

	// Connect to the Payment Client
	$captConn->connect($_GET["HostName"],$_GET["Port"]);

	// Test the Payment Client socket was created successfully
	$captConn->echoTest();

	// Add the MerchTxnRef field. Note: Adds "-C" to the end to keep the
	// MerchTxnRef unique for both the Auth and Capture.
	if (strlen($merchTxnRef) > 0) {
		$captureMerchTxnRef = $merchTxnRef."-C";
		$captConn->addDigitalOrderField("MerchTxnRef", $captureMerchTxnRef);
	}
	
	// Perform the capture request	
	$captConn->doAdminCapture($merchantID, $transactionNr, $amount, $amaUsername, $amaPassword);

	// Get the QSI response code
	$captureQSIResponseCode = $captConn->getResultField("DigitalReceipt.QSIResponseCode");
	
	// If there is no errors with the Payment Client Connection object then also
	// check for a Digital Receipt error anyway
	$errorMessage = $captConn->getErrorMessage();
	
	if (($errorMessage == "") || ($captureQSIResponseCode != "0")) {
		$errorMessage = $captConn->getResultField("DigitalReceipt.ERROR");
	}


	if ($errorMessage == "") {
		// Retrieve all available receipt fields
		// Standard Receipt Fields
		$captureReceiptNo       = $captConn->getResultField("DigitalReceipt.ReceiptNo");
		$captureAcqResponseCode = $captConn->getResultField("DigitalReceipt.AcqResponseCode");
		$captureBatchNo         = $captConn->getResultField("DigitalReceipt.BatchNo");
		$captureTransactionNo   = $captConn->getResultField("DigitalReceipt.TransactionNo");
		$captureCardType        = $captConn->getResultField("DigitalReceipt.CardType");
		$captureResult          = $captConn->getResultField("DigitalReceipt.Result");
		
		$captureQSIResponseCodeDesc = getResultDescription($captureQSIResponseCode);
	}



	// Close the socket connection to the Payment Client
	// **************************************************************
	
	$captConn->close();


}	
	




$againLink = $_GET["AgainLink"];

// set the appropriate title
if ($errorMessage == "") {
    $receiptTitle = $_GET["Title"] . " Receipt Page";
} else {
    $receiptTitle = $_GET["Title"] . " Error Page";
} 

?>

<!DOCTYPE HTML PUBLIC '-'W3C'DTD HTML 4.01 Transitional'EN'>
<head><title><?=$receiptTitle?></title>
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
    <style type='text/css'>
        <!--
        h1       { font-family:Arial,sans-serif; font-size:20pt; font-weight:600; margin-bottom:0.1em; color:#08185A;}
        h2       { font-family:Arial,sans-serif; font-size:14pt; font-weight:100; margin-top:0.1em; color:#08185A;}
        h2.co    { font-family:Arial,sans-serif; font-size:24pt; font-weight:100; margin-top:0.1em; margin-bottom:0.1em; color:#08185A}
        h3       { font-family:Arial,sans-serif; font-size:16pt; font-weight:100; margin-top:0.1em; margin-bottom:0.1em; color:#08185A}
        h3.co    { font-family:Arial,sans-serif; font-size:16pt; font-weight:100; margin-top:0.1em; margin-bottom:0.1em; color:#FFFFFF}
        body     { font-family:Verdana,Arial,sans-serif; font-size:10pt; background-color:#FFFFFF; color:#08185A}
        th       { font-family:Verdana,Arial,sans-serif; font-size:8pt; font-weight:bold; background-color:#CED7EF; padding-top:0.5em; padding-bottom:0.5em;  color:#08185A}
        tr       { height:25px; }
        tr.shade { height:25px; background-color:#CED7EF }
        tr.title { height:25px; background-color:#0074C4 }
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
    
    <!-- start branding table -->
    <table width='100%' border='2' cellpadding='2' bgcolor='#0074C4'>
        <tr>
            <td bgcolor='#CED7EF' width='90%'><h2 class='co'>&nbsp;Payment Client 3.1 Example</h2></td>
            <td bgcolor='#0074C4' align='center'><h3 class='co'>Dialect<br>Solutions</h3></td>
        </tr>
    </table>
    <!-- end branding table -->
    
    <center><h1><br><?=$receiptTitle?></h1></center>
    
    <table align='center' border='0' width='80%'>
        
        <tr class='title'>
            <td colspan='2'><p><strong>&nbsp;Transaction Receipt Fields</strong></p></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Merchant Transaction Reference (Authorisation): </em></strong></td>
            <td><?=$merchTxnRef?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Merchant Transaction Reference (Capture): </em></strong></td>
            <td><?=$captureMerchTxnRef?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Merchant ID: </em></strong></td>
            <td><?=$merchantID?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Order Information: </em></strong></td>
            <td><?=$orderInfo?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Transaction Amount: </em></strong></td>
            <td><?=$amount?></td>
        </tr>
        <tr>
            <td colspan='2' align='center'>
                <div class='bl'>Fields above are the primary request values.<hr>Fields below are receipt data fields.</div>
            </td>
        </tr>
        <?
        // only display these next fields if not an error
        if ($errorMessage == "") {
        ?>
				<tr class='shade'>
						<td align='right'><strong><em>QSI Response Code (Authorisation): </em></strong></td>
            <td><?=$qsiResponseCode?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>QSI Response Code Description (Authorisation): </em></strong></td>
            <td><?=$qsiResponseCodeDesc?></td>
        </tr>
				<tr class='shade'>
						<td align='right'><strong><em>QSI Response Code (Capture): </em></strong></td>
            <td><?=$captureQSIResponseCode?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>QSI Response Code Description (Capture): </em></strong></td>
            <td><?=$captureQSIResponseCodeDesc?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Acquirer Response Code (Authorisation): </em></strong></td>
            <td><?=$resCode?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Acquirer Response Code (Capture): </em></strong></td>
            <td><?=$captureAcqResponseCode?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Shopping Transaction Number (Authorisation): </em></strong></td>
            <td><?=$transactionNr?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Financial Transaction Number (Capture): </em></strong></td>
            <td><?=$captureTransactionNo?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Receipt Number (Authorisation): </em></strong></td>
            <td><?=$receiptNo?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Receipt Number (Capture): </em></strong></td>
            <td><?=$captureReceiptNo?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Authorization ID: </em></strong></td>
            <td><?=$authorizeID?></td>
        </tr>
        <tr>
            <td colspan='2' align='center'>
                <div class='bl'>Fields above are for a Standard Transaction<br />
                    <hr />
                Fields below are additional fields for extra functionality.</div>
            </td>
        </tr>
        <tr class='title'>
            <td colspan='2'><p><strong>&nbsp;CSC Data Fields</strong></p></td>
        </tr>
        <tr>
            <td align='right'><strong><em>CSC Result Code: </em></strong></td>
            <td><?=$cscResultCode?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>CSC Result Description: </em></strong></td>
            <td><?=$cscResultCodeDesc?></td>
        </tr>
        
        <tr class='title'>
            <td colspan='2'><p><strong>&nbsp;AVS Data Fields</strong></p></td>
        </tr>
        <tr>
            <td align='right'><strong><em>AVS Result Code: </em></strong></td>
            <td><?=$avsResultCode?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>AVS Result Description: </em></strong></td>
            <td><?=$avsResultCodeDesc?></td>
        </tr>
        
        
        <?
        
        
        if ($numOccurrences >= 0) {
        ?>
        <tr class='title'>
            <td colspan='2'><p><strong>&nbsp;Amex Plan Payment Data</strong></p></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Sale Amount: </em></strong></td>
            <td><?=$saleAmount?></td>
        </tr>
        <tr class='shade'>
            <td align='right'><strong><em>Interest Rate: </em></strong></td>
            <td><?=$interestRate?></td>
        </tr>
        <tr>
            <td align='right'><strong><em>Sale Amount: </em></strong></td>
            <td><?=$numOccurrences?></td>
        </tr>
        <?
      	}
				?>

        <tr><td colspan="2" align="center"><hr/></td></tr>
        
        
        <?
        // only display these next fields if an error condition exists-->
        } else {
        ?>      <tr class='title'>
            <td colspan='2'><p><strong>&nbsp;Error in processing the data</strong></p></td>
        </tr>
        <tr>
            <td align='right' width='35%'><em><strong>Error Description: </strong></em></td>
            <td><?=$errorMessage?></td>
        </tr>
        <?
        } ?>
        <tr>    
            <td width="50%">&nbsp;</td>
            <td width="50%">&nbsp;</td>
        </tr>
    </table>
    
    <center><p class='blue'><a href='<?=$againLink?>'>Another Transaction</a></p></center>
    
</body>
</html>

