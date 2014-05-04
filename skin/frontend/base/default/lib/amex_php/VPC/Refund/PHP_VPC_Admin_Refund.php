﻿<?php
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

// Send the Digital Order to the Payment Server
$conn->sendMOTODigitalOrder($vpcURL, $proxy);


// don't overwrite message if any error messages detected
if (strlen($conn->getErrorMessage()) == 0) {
    $message            = $conn->getResultField("vpc_Message");
}

// Standard Receipt Data
# merchTxnRef not always returned in response if no receipt so get input
$merchTxnRef     = $vpc_MerchTxnRef;

$amount          = $conn->getResultField("vpc_Amount");
$locale          = $conn->getResultField("vpc_Locale");
$batchNo         = $conn->getResultField("vpc_BatchNo");
$command         = $conn->getResultField("vpc_Command");
$version         = $conn->getResultField("vpc_Version");
$cardType        = $conn->getResultField("vpc_Card");
$orderInfo       = $conn->getResultField("vpc_OrderInfo");
$receiptNo       = $conn->getResultField("vpc_ReceiptNo");
$merchantID      = $conn->getResultField("vpc_Merchant");
$authorizeID     = $conn->getResultField("vpc_AuthorizeId");
$transactionNr   = $conn->getResultField("vpc_TransactionNo");
$acqResponseCode = $conn->getResultField("vpc_AcqResponseCode");
$txnResponseCode = $conn->getResultField("vpc_TxnResponseCode");

// AMA Transaction Data
$shopTransNo     = $conn->getResultField("vpc_ShopTransactionNo");
$authorisedAmount= $conn->getResultField("vpc_AuthorisedAmount");
$capturedAmount  = $conn->getResultField("vpc_CapturedAmount");
$refundedAmount  = $conn->getResultField("vpc_RefundedAmount");
$ticketNumber    = $conn->getResultField("vpc_TicketNo");

if ($txnResponseCode != "No Value Returned") {
    $txnResponseCodeDesc = getResultDescription($txnResponseCode);
}


/*********************
* END OF MAIN PROGRAM
*********************/

// FINISH TRANSACTION - Process the VPC Response Data
// =====================================================
// For the purposes of demonstration, we simply display the Result fields on a
// web page.

// Show 'Error' in title if an error condition
$errorTxt = "";
// Show the display page as an error page
if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned") {
    $errorTxt = "Error ";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Virtual Payment Client Example Response Page</title>
        <meta http-equiv="Content-Type" content="text/html, charset=UTF-8" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="expires" content="0" />
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

        <!-- start branding table -->
        <table width='100%' border='2' cellpadding='2' class="title">
            <tr>
                <td class="shade" width='90%'><h2 class='co'>&nbsp;Amex Virtual Payment Client Example</h2></td>
                <td class="title" align='center'><h3 class='co'>Dialect<br>Payments</h3></td>
            </tr>
        </table>
        <!-- end branding table -->

        <center><h1><?=$title?> - <?=$errorTxt?>Response Page</h1></center>

        <table width="80%" align="center" cellpadding="5" border="0">
          <tr class="title">
            <td colspan="2" height="25"><p><strong>&nbsp;Refund Transaction Fields</strong></p></td>
          </tr>
          <tr>
            <td align="right" width="50%"><strong><i>VPC API Version: </i></strong></td>
            <td width="50%"><?=$version?></td>
          </tr>
          <tr class="shade">
            <td align="right"><strong><i>Command: </i></strong></td>
            <td><?=$command?></td>
          </tr>
          <tr>
            <td align="right"><strong><i>Merchant Transaction Reference: </i></strong></td>
            <td><?=$merchTxnRef?></td>
          </tr>
          <tr class="shade">
            <td align="right"><strong><i>Merchant ID: </i></strong></td>
            <td><?=$merchantID?></td>
          </tr>
          <tr>
            <td align="right"><strong><i>Shopping Transaction Number: </i></strong></td>
            <td><?=$shopTransNo?></td>
          </tr>
          <tr class='shade'>
            <td align="right"><strong><i>Amount: </i></strong></td>
            <td><?=$amount?></td>
          </tr>
          <tr>
            <td colspan = '2' align='center'><font color='#0074C4'>Fields above are the primary request values.</font><br/><hr/>
            </td>
          </tr>

          <tr class="shade">
            <td align='right'><b><i>VPC Transaction Response Code: </i></b></td>
            <td><?=$txnResponseCode?></td>
          </tr>
          <tr>
            <td align='right'><b><i>Transaction Response Code Description: </i></b></td>
            <td><?=$txnResponseCodeDesc?></td>
          </tr>
          <tr class="shade">
            <td align='right'><b><i>Message: </i></b></td>
            <td><?=$message?></td>
          </tr>
<?
    // only display the following fields if not an error condition
    if ($txnResponseCode != "7" && $txnResponseCode != "No Value Returned") {
?>
          <tr>
            <td align='right'><b><i>Receipt Number: </i></b></td>
            <td><?=$receiptNo?></td>
          </tr>
          <tr class="shade">
            <td align='right'><b><i>Refund Transaction Number: </i></b></td>
            <td><?=$transactionNr?></td>
          </tr>
          <tr>
            <td align='right'><b><i>Acquirer Response Code: </i></b></td>
            <td><?=$acqResponseCode?></td>
          </tr>
          <tr class="shade">
            <td align='right'><b><i>Bank Authorization ID: </i></b></td>
            <td><?=$authorizeID?></td>
          </tr>
          <tr>
            <td align='right'><b><i>Batch Number: </i></b></td>
            <td><?=$batchNo?></td>
          </tr>
          <tr class="shade">
            <td align='right'><b><i>Card Type: </i></b></td>
            <td><?=$cardType?></td>
          </tr>

          <tr>
            <td colspan='2' align='center'><font color='#0074C4'>Fields above are for a standard transaction<br/><hr/>
                Fields below are additional fields for extra functionality.</font><br/></td>
          </tr>

          <tr class="title">
            <td colspan="2" height="25"><p><b>&nbsp;Financial Transaction Fields</b></p></td>
          </tr>
          <tr>
            <td align='right'><b><i>Shopping Transaction Number: </i></b></td>
            <td><?=$shopTransNo?></td>
          </tr>
          <tr class="shade">
            <td align='right'><b><i>Authorised Amount: </i></b></td>
            <td><?=$authorisedAmount?></td>
          </tr>
          <tr>
            <td align='right'><b><i>Captured Amount: </i></b></td>
            <td><?=$capturedAmount?></td>
          </tr>
          <tr class="shade">
            <td align='right'><b><i>Refunded Amount: </i></b></td>
            <td><?=$refundedAmount?></td>
          </tr>
          <tr>
            <td align='right'><b><i>Ticket Number: </i></b></td>
            <td><?=$ticketNumber?></td>
          </tr>
<? } ?>
        </table>

    <center><p><A HREF='<?=$HTTP_REFERER?>'>New Transaction</a></p></center>
    </body>

    <head>
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="expires" content="0" />
    </head>
</html>