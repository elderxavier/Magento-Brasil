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

// Prepare to Generate and Send Digital Order


// Basic transaction fields
// *******************************

$merchTxnRef     = $_POST["MerchTxnRef"];
$merchantID      = $_POST["MerchantID"];
$transactionNo   = $_POST["TransactionNo"];
$refundAmount    = $_POST["RefundAmount"];
$amaUsername     = $_POST["Username"];
$amaPassword     = $_POST["Password"];

if (strlen($merchTxnRef) > 0) {
	$conn->addAdminCommandField("MerchTxnRef", $merchTxnRef);
}



// Perform the refund request
// **************************************************************

$conn->doAdminRefund($merchantID, $transactionNo, $refundAmount, $amaUsername, $amaPassword);



// Get the result data from the Digital Receipt
// **************************************************************


$qsiResponseCode     = "";
$qsiResponseCodeDesc = "";
$resCode             = "";
$transactionNr       = "";
$receiptNo           = "";
$authorizeID         = "";
$cardType            = "";
$batchNo             = "";
$amount              = "";
$acqResponseCode     = "";


$qsiResponseCode = $conn->getResultField("DigitalReceipt.QSIResponseCode");


//echo "--".$conn->getResultField("PaymentClient.ERROR");


// If there is no errors with the Payment Client Connection object then also
// check for a Digital Receipt error anyway

$errorMessage = $conn->getErrorMessage();

if (($errorMessage == "") || ($qsiResponseCode != "0")) {
	$errorMessage = $conn->getResultField("DigitalReceipt.ERROR");
}


// Check for an empty result

if ($errorMessage == "") {
	
	$cmdResponse = $conn->getResultField("DigitalReceipt.Result");
	if ($cmdResponse == "") {
		// Set an error message
		$errorMessage = "(20) The result field was an empty string";
	} else {
		// Get the result data
		
		$adminResult = $cmdResponse;
	}

}



// Use the "getAvailableFieldKeys" command to obtain a list of keys available
// within the  Hash table containing the receipt results.

if ($errorMessage == "") {
	
	$receiptKeys = "";
	$cmdResponse = $conn->getAvailableFieldKeys();
	if ($cmdResponse == "") $cmdResponse = "No Value Returned";
	$receiptKeys = str_replace( ",", "<br/>",$receiptKeys);

}



// In a production system the sent values and the receive
// values could be checked to make sure they are the same.
if ($errorMessage == "") {
	
	
	$merchantID      = $conn->getResultField("DigitalReceipt.MerchantId");
	$receiptNo       = $conn->getResultField("DigitalReceipt.ReceiptNo");
	$acqResponseCode = $conn->getResultField("DigitalReceipt.AcqResponseCode");
	$authorizeID     = $conn->getResultField("DigitalReceipt.AuthorizeId");
	$batchNo         = $conn->getResultField("DigitalReceipt.BatchNo");
	$transactionNr   = $conn->getResultField("DigitalReceipt.TransactionNo");
	$cardType        = $conn->getResultField("DigitalReceipt.CardType");
	$amount          = $conn->getResultField("DigitalReceipt.PurchaseAmountInteger");
	
	$qsiResponseCodeDesc = getResultDescription($qsiResponseCode);


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
    
    // separate out the cells for display purposes only
    $tableData = buildTableHeadings($adminResult);
    $tableData = $tableData . buildTableRow($adminResult,1);
} else {
    $title = $title." Error Page";
    // if exception is empty then set it to a value
    if (strlen($errorMessage) == 0) {
        $errorMessage = "No Further Information Returned";
    }
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

<center><h1><?=$title?></h1><br/></center>

<table align='center' border='0' width='80%'>

    <tr>
        <td width="45%">&nbsp;</td>
        <td width="55%">&nbsp;</td>
    </tr>
    <tr class="title">
        <td colspan="2"><p><strong>&nbsp;Refund Transaction Receipt Fields</strong></p></td>
    </tr>
    <tr>    
        <td align="right"><strong><em>Merchant Transaction Reference: </em></strong></td>
        <td><?=$merchTxnRef?></td>
    </tr>
    <tr class="shade">    
        <td align="right"><strong><em>Merchant ID: </em></strong></td>
        <td><?=$merchantID?></td>
    </tr>
    <tr>    
        <td align="right"><strong><em>Shopping Transaction Number: </em></strong></td>
        <td><?=$transactionNo?></td>
    </tr>
    <tr class="shade">    
        <td align="right"><strong><em>Refund Amount: </em></strong></td>
        <td><?=$refundAmount?></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <div class='bl'>Fields above are the primary request values.<hr>Fields below are receipt data fields.</div>
        </td>
    </tr>
<?
// only display these next fields if not an error
if ($errorMessage == "") {
?>  <tr class="shade">    
        <td align="right"><strong><em>QSI Response Code: </em></strong></td>
        <td><?=$qsiResponseCode?></td>
    </tr>
    <tr>    
        <td align="right"><strong><em>QSI Response Code Description: </em></strong></td>
        <td><?=$qsiResponseCodeDesc?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><strong><em>Refund Transaction No: </em></strong></td>
        <td><?=$transactionNr?></td>
    </tr>
    <tr>
        <td align='right'><em><strong>Receipt No: </strong></em></td>
        <td><?=$receiptNo?></td>
    </tr>
    <tr class='shade'>                  
        <td align='right'><em><strong>Authorize Id: </strong></em></td>
        <td><?=$authorizeID?></td>
    </tr>
    <tr>
        <td align='right'><em><strong>AcqResponseCode: </strong></em></td>
        <td><?=$acqResponseCode?></td>
    </tr>
    <tr class='shade'>
        <td align='right'><em><strong>Batch No: </strong></em></td>
        <td><?=$batchNo?></td>
    </tr>
    <tr>                  
        <td align='right'><em><strong>CardType: </strong></em></td>
        <td><?=$cardType?></td>
    </tr>
    <tr>
        <td colspan='2' align='center'><hr /></td>
    </tr>
    <tr class='title'>
        <td colspan='2'><p><strong>&nbsp;Returned Data String</strong></p></td>
    </tr>
</table>

<table align="center">
    <tr>
        <td align="center"><?=$adminResult?></td>
    </tr>
</table>
<table align="center">
    <tr>
        <td align="center"><br />or separated out:</td>
    </tr>
</table><br />

<table align="center" cellpadding='2' cellspacing='0' border='1' bordercolor='#3979C6'>
      <?=$tableData?>
</table><br />

<? } else { ?>
        <!-- only display these next fields if an error condition exists-->
    <tr class="title">
        <td colspan="2"><p><strong>&nbsp;Error in Processing the Data</strong></p></td>
    </tr>
		<tr>
		    <td align='right' width='35%'><em><strong>Error Description: </strong></em></td>
		    <td><?=$errorMessage?></td>
		</tr>
    
</table><br />

<? } ?>
   
<center><br /><p class='blue'><a href='<?=$againLink?>'>Another Transaction</a></p></center>

</body>
</html>

<?    
// End Processing

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

// -----------------------------------------------------------------------------

?>

