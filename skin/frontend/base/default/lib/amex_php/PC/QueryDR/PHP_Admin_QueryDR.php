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
include('PaymentClientConnection.php');
$conn = new PaymentClientConnection();

// Check whether the user has selected to output the socket commands
$conn->debug = array_key_exists("DebugOn", $_POST) ? true : false;



// *********************
// START OF MAIN PROGRAM
// *********************

// Connect to the Payment Client
$conn->connect($_POST["HostName"],$_POST["Port"]);

// Test the Payment Client socket was created successfully
$conn->echoTest();

/* The following fields are the input fields for the command, please
* refer to the Payment Client Reference Guide for more information on
* the fields.
*/
$merchTxnRef     = "";
$merchantID      = "";

// receipt variables
$drExists        = "";
$multipleDRs     = "";
$locale          = "";
$orderInfo       = "";
$qsiResponseCode = "";
$receiptNo       = "";
$acqResponseCode = "";
$authorizeID     = "";
$batchNo         = "";
$amount          = "";
$transactionNr   = ""; 
$cardType        = ""; 
$receiptKeys     = ""; 
$avs_Street01    = "";
$avs_City        = "";
$avs_StateProv   = "";
$avs_PostCode    = "";
$avs_Country     = "";
$avsResultCode   = "";
$acqAVSRespCode  = "";
$avsRequestCode  = "";
$cscResultCode   = "";
$acqCSCRespCode  = "";
$cscRequestCode  = "";
$verType         = "";
$verStatus       = "";
$verSecurLevel   = "";
$enrolled        = "";
$authStatus      = "";
$xid             = "";
$token           = "";
$acqECI          = "";

// This is the receipt type for 'Receipt' page 
// Either a stardard 2/3-Party style or Capture/Refund style
$receiptType = array_key_exists("ReceiptType", $_POST) ? $_POST["ReceiptType"] : "";



// Generate and Send Digital Order (& receive DR)
// *******************************************************


// This is the only command that communicates with the Payment Server.
// All other commands only communicate locally with the Payment Client.
$merchantID  = $_POST["MerchantID"];
$merchTxnRef = $_POST["MerchTxnRef"];
$username    = $_POST["Username"];
$password    = $_POST["Password"];



// Perform the query request
// **************************************************************

$conn->doAdminQuery($merchantID,$merchTxnRef,$username,$password);



// Get the result data from the Digital Receipt
// =====================================================



// QueryDR specific data
if ($errorMessage == "") {

    $drExists = $conn->DRExists();
    $multipleDRs = $conn->FoundMultipleDRs();
    
}



// Check the QSIResponseCode for the transaction from the Payment Client Hash
// table. This is the most important result field and indicates the status of 
// the transaction. If the QSIResponseCode doesn't exist, this is an error
// condition.

$qsiResponseCode = $conn->getResultField("DigitalReceipt.QSIResponseCode");


// If the QSIResponseCode is '0' the transaction is successful.
// If the QSIResponseCode is not '0' the transaction has beed declined or an 
// error condition was detected, such as the customer typed in an invalid card
// number.

if (($errorMessage == "") || ($qsiResponseCode != "0")) {
	$errorMessage = $conn->getResultField("DigitalReceipt.ERROR");
}




// Check for an empty result
if ($errorMessage == "" && strtolower($receiptType) == "ama") {
	
	$cmdResponse = $conn->getResultField("DigitalReceipt.Result");
	
	if ($cmdResponse == "") {
		// Set an error message
		$errorMessage = "(20) The result field was an empty string";
	} else {
		// Get the result data
		$adminResult = $cmdResponse;
		
		$tableData = buildTableHeadings($adminResult);
		$tableData = $tableData . buildTableRow($adminResult,1);
	}
	
}

// Use the "getAvailableFieldKeys" command to obtain a list of keys available
// within the  Hash table containing the receipt results.

$receiptKeys = "";
if ($errorMessage == "") {
	$cmdResponse = $conn->getAvailableFieldKeys();
	if ($cmdResponse == "") {
		$receiptKeys = "No Value Returned";
	} else {
		$receiptKeys = str_replace( ",", "<br/>",$cmdResponse);
	}
}


// In a production system the sent values and the receive
// values could be checked to make sure they are the same.
if ($errorMessage == "") {
    // Standard Receipt Fields
    $merchantID = $conn->getResultField("DigitalReceipt.MerchantId");
    $receiptNo = $conn->getResultField("DigitalReceipt.ReceiptNo");
    $transactionNo = $conn->getResultField("DigitalReceipt.TransactionNo");
    $acqResponseCode = $conn->getResultField("DigitalReceipt.AcqResponseCode");
    $authorizeID = $conn->getResultField("DigitalReceipt.AuthorizeId");
    $batchNo = $conn->getResultField("DigitalReceipt.BatchNo");
    $cardType = $conn->getResultField("DigitalReceipt.CardType");

		$getResponseDescription = getResultDescription($qsiResponseCode);
		

    // if an AMA transaction, (e.g. a refund/capture) the PurchaseAmountInteger 
    // returns a non-valid amount so only get if for payment transactions
    if (strtolower($receiptType) == "ama") {
			$amount = getToken($adminResult, ",", 11);
    } else {
	    $amount = $conn->getResultField("DigitalReceipt.PurchaseAmountInteger");
			$orderInfo = $conn->getResultField("DigitalReceipt.OrderInfo");
			$locale = $conn->getResultField("DigitalReceipt.Locale");
	
			// AVS Receipt Fields
			$avs_Street01 = $conn->getResultField("DigitalReceipt.AVS_Street01");
			$avs_City = $conn->getResultField("DigitalReceipt.AVS_City");
			$avs_StateProv = $conn->getResultField("DigitalReceipt.AVS_StateProv");
			$avs_PostCode = $conn->getResultField("DigitalReceipt.AVS_PostCode");
			$avs_Country = $conn->getResultField("DigitalReceipt.AVS_Country");
			$avsResultCode = $conn->getResultField("DigitalReceipt.AVSResultCode");
			$acqAVSRespCode = $conn->getResultField("DigitalReceipt.AcqAVSRespCode");
			$avsRequestCode = $conn->getResultField("DigitalReceipt.AVSRequestCode");
			
			$displayAVSResponse = getAVSResultDescription($avsResultCode);
	
			// CSC Receipt Fields
			$cscResultCode = $conn->getResultField("DigitalReceipt.CSCResultCode");
			$acqCSCRespCode = $conn->getResultField("DigitalReceipt.AcqCSCRespCode");
			$cscRequestCode = $conn->getResultField("DigitalReceipt.CSCRequestCode");
			
			$displayCSCResponse = getCSCResultDescription($cscResultCode);
	
			// 3-D Secure Receipt Fields
			$verType = $conn->getResultField("DigitalReceipt.VerType");
			$verStatus = $conn->getResultField("DigitalReceipt.VerStatus");
			$verSecurLevel = $conn->getResultField("DigitalReceipt.VerSecurityLevel");
			$enrolled = $conn->getResultField("DigitalReceipt.3DSenrolled");
			$authStatus = $conn->getResultField("DigitalReceipt.3DSstatus");
			$xid = $conn->getResultField("DigitalReceipt.3DSXID");
			$token = $conn->getResultField("DigitalReceipt.VerToken");
			$acqECI = $conn->getResultField("DigitalReceipt.3DSECI");
	}
}

// Close the socket connection to the Payment Client
// **************************************************************

$conn->close();


// *********************
// END OF MAIN PROGRAM
// *********************

// FINISH TRANSACTION - Process the Response Data
// ==============================================
// For the purposes of demonstration, we simply display the Result fields on a
// web page.

// This is the display title for 'Receipt' page 
$title = $_POST["Title"];

/* The URL link for the receipt to do another transaction.
 * Note: This is ONLY used for this example and is not required for 
 * production code.  */
$againLink  = $HTTP_REFERER;

if ($errorMessage == "") {
    $title = $title." Receipt Page";
} else {
    $title = $title." Error Page";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title><?=$title?></title>
    <meta http-equiv="Content-Type" content="text/html, charset=iso-8859-1"/>
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

<!-- Start branding table -->
<table width='100%' border='2' cellpadding='2' bgcolor='#0074C4'>
    <tr>
        <td bgcolor='#CED7EF' width='90%'>
            <h2 class='co'> Payment Client v3.1 Example</h2>
        </td>
        <td bgcolor='#0074C4' align='center'>
            <h3 class='co'>Dialect<br />Payments</h3>
        </td>
    </tr>
</table>
<!-- End branding table -->

<center><h1><?=$title?></h1></center>

<table align='center' border='0' width='80%'>

	<tr>    
		<td width='55%'>&nbsp;</td>
		<td width='45%'>&nbsp;</td>
	</tr>
	<tr class='title'>
		<td colspan='2'><p><strong>&nbsp;QueryDR Transaction Receipt Fields</strong></p></td>
	</tr>
	<tr>
		<td align='right'><strong><em>Merchant Transaction Reference: </em></strong></td>
		<td><?=$merchTxnRef?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>Merchant ID: </em></strong></td>
		<td><?=$merchantID?></td>
	</tr>
<?
// only display these next fields if not an error condition
if ($errorMessage != "") {
?>
	<tr><td colspan='2' align='center'><hr/></td></tr>

	<tr class='title'>
		<td colspan='2'><p><strong>&nbsp;Error in processing the data</strong></p></td>
	</tr>
	<tr>
		<td align='right' width='35%'><em><strong>Error Description: </strong></em></td>
		<td><?=$errorMessage?></td>
	</tr>
</table>
<?
} else {
?>
	<tr>
		<td colspan='2' align='center'><div class='bl'>Fields above are the main order values.<hr />Fields immediately below are additional special fields for QueryDR functionality.</div></td>
	</tr>
	<tr class='title'>
		<td colspan='2' height='25'><p><strong> QueryDR Receipt Fields</strong></p></td>
	</tr>
	<tr>                    
		<td align='right'><em><strong>Receipt Exists: </strong></em></td>
		<td><?=$drExists?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><em><strong>Found Multiple Receipts: </strong></em></td>
		<td><?=$multipleDRs?></td>
	</tr>

<?
	if ($qsiResponseCode != "null") {
?>
	<tr>
		<td colspan='2' align='center'><div class='bl'><hr/>
		   Fields below are for a Standard Transaction.</div></td>
	</tr>
	   
	<tr class='title'>
		<td colspan='2' height='25'><p><strong> Standard Transaction Receipt Fields</strong></p></td>
	</tr>
	<tr>
		<td align='right'><strong><em>QSI Response Code: </em></strong></td>
		<td><?=$qsiResponseCode?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>QSI Response Code Description: </em></strong></td>
		<td><?=$getResponseDescription?></td>
	</tr>
<?
	}
    // Only display the following fields if a receipt exists
    if (strtoupper($drExists) == "Y") {
        // these 2 fields following don't apply to AMA transactions.
        if (strtolower($receiptType) != "ama") { 
?>
	<tr>
		<td align='right'><strong><em>Order Information: </em></strong></td>
		<td><?=$orderInfo?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>Locale: </em></strong></td>
		<td><?=$locale?></td>
	</tr>
<?
		} 
        // the following fields apply to all transactions.
?>
	<tr>
		<td align='right'><strong><em>Transaction Amount: </em></strong></td>
		<td><?=$amount?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>Receipt Number: </em></strong></td>
		<td><?=$receiptNo?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>Shopping Transaction Number: </em></strong></td>
		<td><?=$transactionNo?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>Acquirer Response Code: </em></strong></td>
		<td><?=$acqResponseCode?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>Authorization ID: </em></strong></td>
		<td><?=$authorizeID?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>Batch Number for this transaction: </em></strong></td>
		<td><?=$batchNo?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>Card Type: </em></strong></td>
		<td><?=$cardType?></td>
	</tr>
	<tr>
		<td colspan='2' align='center'>
			<font color='#0074C4'>Fields above are for a Standard Transaction<br />
			<hr />
			Fields below are additional fields for extra functionality.</font><br />
		</td>
	</tr>
	<tr class='title'>
		<td colspan='2' height='25'><p><strong> Possible Receipt Fields Returned for This Transaction</strong></p></td>
	</tr>
	<tr>
		<td align='right'><em><strong>getAvailableFieldKeys() : </strong></em><br/> This is a list of all possible receipt values&nbsp;<br/>that can be returned for this transaction.&nbsp;</td>
		<td><?=$receiptKeys?></td>
	</tr>
	<tr class='shade'>
		<td align='center' colspan='2'><strong><u>Note</u>: DigitalResult.SessionId</strong> <em>and</em> <strong>DigitalResult.OrderInfo</strong> <em>are the same field with different names.<br/>DigitalResult.SessionId was used for earlier versions of the Payment Client API</em></td>
	</tr>

	<tr><td colspan='2' align='center'><hr/></td></tr>
<?
        // the following fields only apply to AMA transactions such as captures and refunds.
        if (strtolower($receiptType) == "ama") { 
?>
	<tr class='title'>    
		<td colspan='2'><p><strong>&nbsp;Returned Data String</strong></p></td>
	</tr>
</table>
	  
<table align='center'>
	<tr>
		<td align='center'><?=$adminResult?></td>
	</tr>
</table>
<table align='center'>
	<tr>
		<td align='center'><br />or separated out:</td>
	</tr>
</table><br />

<table align='center' cellpadding='2' cellspacing='0' border='1' bordercolor='#3979C6'>
	<?=$tableData?> 
</table>
<?
        // the following fields only apply to standard 2/3 Party transactions.
		} else {
?>
	<tr class='title'>
		<td colspan='2' height='25'><p><strong> Address Verification Service Fields</strong></p></td>
	</tr>
	<tr>
		<td align='right'><strong><em>AVS Street/Postal Address: </em></strong></td>
		<td><?=$avs_Street01?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>AVS City/Town/Suburb: </em></strong></td>
		<td><?=$avs_City?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>AVS State/Province: </em></strong></td>
		<td><?=$avs_StateProv?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>AVS Postal/Zip Code: </em></strong></td>
		<td><?=$avs_PostCode?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>AVS Country Code: </em></strong></td>
		<td><?=$avs_Country?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>AVS Result Code: </em></strong></td>
		<td><?=$avsResultCode?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>AVS Result Description: </em></strong></td>
		<td><?=$displayAVSResponse?></td>
	</tr>
	<tr class='shade'>
		<td align='right'><strong><em>AVS Request Code: </em></strong></td>
		<td><?=$avsRequestCode?></td>
	</tr>
	<tr>
		<td align='right'><strong><em>AVS Acquirer Response Code: </em></strong></td>
		<td><?=$acqAVSRespCode?></td>
	</tr>

	<tr><td colspan='2' align='center'><hr/></td></tr>

    <tr class='title'>
        <td colspan='2' height='25'><p><strong> Card Security Code Fields</strong></p></td>
    </tr>
    <tr>
        <td align='right'><strong><em>CSC Result Code: </em></strong></td>
        <td><?=$cscResultCode?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><strong><em>CSC Result Description: </em></strong></td>
        <td><?=$displayCSCResponse?></td>
    </tr>
    <tr>
        <td align='right'><strong><em>CSC Request Code: </em></strong></td>
        <td><?=$cscRequestCode?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><strong><em>CSC Acquirer Response Code: </em></strong></td>
        <td><?=$acqCSCRespCode?></td>
    </tr>

	<tr><td colspan='2' align='center'><hr/></td></tr>

    <tr class='title'>
        <td colspan='2' height='25'><P><strong> 3-D Secure Fields</strong></P></td>
    </tr>
    <tr>
        <td align='right'><strong><em>Unique 3DS transaction identifier: </em></strong></td>
        <td class='red'><?=$xid?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><strong><em>3DS Authentication Verification Value: </em></strong></td>
        <td class='red'><?=$token?></td>
    </tr>
    <tr>
        <td align='right'><strong><em>3DS Electronic Commerce Indicator: </em></strong></td>
        <td class='red'><?=$acqECI?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><strong><em>3DS Authentication Scheme: </em></strong></td>
        <td class='red'><?=$verType?></td>
    </tr>
    <tr>
        <td align='right'><strong><em>3DS Security level used in the AUTH message: </em></strong></td>
        <td class='red'><?=$verSecurLevel?></td>
    </tr>
    <tr class='shade'>
        <td align='right'>
            <strong><em>3DS CardHolder Enrolled: </strong>
            <br />
            <div class='bl'>Takes values: <strong>Y</strong> - Yes <strong>N</strong> - No</em></div>
        </td>
        <td class='red'><?=$enrolled?></td>
    </tr>
    <tr>
        <td align='right'>
            <em><strong>Authenticated Successfully: </strong><br />
            <div class='bl'>Only returned if CardHolder Enrolled = <strong>Y</strong>. Takes values:<br />
            <strong>Y</strong> - Yes <strong>N</strong> - No <strong>A</strong> - Attempted to Check <strong>U</strong> - Unavailable for Checking</div></em>
        </td>
        <td class='red'><?=$authStatus?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><strong><em>Payment Server 3DS Authentication Status Code: </em></strong></td>
        <td class='green'><?=$verStatus?></td>
    </tr>
    <tr>
        <td align='right'><em><strong>3DS Authentication Status Code Description: </strong></em></td>
        <td class='green'><?=getStatusDescription($verStatus)?></td>
    </tr>
    <tr>
        <td colspan='2' align='center'>
            <p class='red'>The 3-D Secure values shown in red are those values that are important values to store in case of future transaction repudiation.</p>
        </td>
    </tr>
    <tr>
        <td colspan='2' align='center'>
            <p class='green'>The 3-D Secure values shown in green are for information only and are not required to be stored.</p>
        </td>
    </tr>
</table>
<?
		}
	}
}
if ($qsiResponseCode == "null") {
	// required to finish off the table if qsiResponseCode="null"
	// this happens if drExists = N
?>
</table>
<?
}
?>

<center><p class='blue'><a href='<?=$againLink?>'>Another Transaction</a></p></center>
</body>
</html>

<?    
// End Processing

// =============================================================================


/**
* This method gets a specified token from the adminResult String
*
* @param tokenString String of token seperated values
* @param separator is the token string delimiter character
* @param fieldNo integer number of requested token
*
* @return requested token
*
*/
function getToken($tokenString, $separator, $fieldNo) {

    if (!is_int($fieldNo) || $fieldNo < 1) {
        $result = "Field number must be an integer greater than 0 (zero) and<br/>less than or equal to the number of tokens in the String"; 
    } else {
        // split the comma delimited string into an array
        $fieldsArray = explode($separator, $tokenString);

        // array starts from cell 0 so subtract 1 from required field number
        if ($fieldNo - 1 < count($fieldsArray)) {
            $result = $fieldsArray[$fieldNo - 1];
        } else {
            $result = "Field number too large for this string"; 
        }
    }
    
    return $result;
}

//  ----------------------------------------------------------------------------

// This subroutine builds the HTML table row using the comma delimited result
// String returned by the Payment Client. The returned string contains a
// HTML marked up table row of column headings.

// @param vResult String of comma ',' seperated values

// @return table String containing the HTML table header row

function buildTableHeadings($vResult) {

    // Begin the table row
    $table = "<tr>\n";
    
    // initialise variables
    $separator = ",";
    $colCount = 1;
    $displayArray = split(",", $vResult);

    // Add the cell data for each column in the result
    foreach($displayArray as $key => $value) {
        if ($colCount == 1) {
            // Add the extra text "Field No. " to the first column heading
            $table = $table . "        <th>Record</th>\n        <th>Field No." . $colCount . "</th>\n";
        } else {
            $table = $table . "        <th>" . $colCount . "</th>\n";
        }
        $colCount++; 
    }
    // Close  and return the table row 
    return $table . "    </tr>\n";
}

// -----------------------------------------------------------------------------

// This subroutine builds the HTML table row using the comma delimited result
// String returned by the Payment Client. The returned string contains a
// HTML marked up table row constructed from the data provided.

// @param vResult String of comma ',' seperated values

// @return table String containing the HTML table data row

function buildTableRow($vResult, $recordNo) {

    // Begin the table row
    $table = "    <tr>\n        <th>$recordNo</th>\n";
    $displayArray = split(",", $vResult);

    // Process the data until all data in the row has been parsed and marked up
    foreach($displayArray as $key => $value) {
        // Check for empty fields and substitute "null" into the HTML table
        if (strlen($value) == 0) {
           $value = "null";
        }
        // Put the field into the HTML table
        $table  = $table . "        <td align='center'>" . $value . "</td>\n";
    }
    // Close the table row and return the table
    return $table . "    </tr>\n";
}


//  -----------------------------------------------------------------------------

// This method uses the verRes status code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code

// @param statusResponse String containing the 3DS Authentication Status Code
// @return String containing the appropriate description

function getStatusDescription($statusResponse) {
    if ($statusResponse == "" || $statusResponse == "No Value Returned") {
        $result = "3DS not supported or there was no 3DS data provided";
    } else {
        switch ($statusResponse) {
            Case "Y"  : $result = "The cardholder was successfully authenticated."; break;
            Case "E"  : $result = "The cardholder is not enrolled."; break;
            Case "N"  : $result = "The cardholder was not verified."; break;
            Case "U"  : $result = "The cardholder's Issuer was unable to authenticate due to some system error at the Issuer."; break;
            Case "F"  : $result = "There was an error in the format of the request from the merchant."; break;
            Case "A"  : $result = "Authentication of your Merchant ID and Password to the ACS Directory Failed."; break;
            Case "D"  : $result = "Error communicating with the Directory Server."; break;
            Case "C"  : $result = "The card type is not supported for authentication."; break;
            Case "M"  : $result = "The card issuer does not support 3D-Secure. No liabilty shift occurred."; break;
            Case "S"  : $result = "The signature on the response received from the Issuer could not be validated."; break;
            Case "P"  : $result = "Error parsing input from Issuer."; break;
            Case "I"  : $result = "Internal Payment Server system error."; break;
            default   : $result = "Unable to be determined"; break;
        }
    }
    return $result;
}

//  -----------------------------------------------------------------------------


?>

