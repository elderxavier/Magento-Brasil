<?php

/*
 *
 * Version 1.0
 *
 * ----------------- Disclaimer ------------------------------------------------
 *
 * Copyright � 2007 Dialect Payment Technologies - a Transaction Network
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
$getDebug = array_key_exists("DebugOn", $_POST) ? true : false;
$conn->debug = $getDebug;

// Connect to the Payment Client
$payClientIP    = $_POST["HostName"];
$portNo         = $_POST["Port"];
$conn->connect($payClientIP,$portNo);

// Test the Payment Client socket was created successfully
$conn->echoTest();


// *********************
// START OF MAIN PROGRAM
// *********************



/* The following fields are the input fields for the command, please
* refer to the Payment Client Reference Guide for more information on
* the fields.
*/
$merchTxnRef = "";
$orderInfo   = "";
$merchantID  = "";
$amount      = "";
$locale      = "";
$returnURL   = "";

// Digital Order variable
$digitalOrder = "";

/* The URL link for the receipt/error page to do another transaction.
* Note: This is ONLY used for this example and is not required for
* production code.
*
* However, it does show how extra variables can be added to the
* transaction, that will be returned in the receipt.
*/
$againLink = $HTTP_REFERER;

// set the appropriate title
	$title = $_POST["Title"];

// Optional If merchant is not setup to accept multi currency
// **************************************************************

$Currency     = $_POST["Currency"];

if (strlen($Currency) > 0) {
	$conn->addDigitalOrderField("Currency", $Currency);
}
   
// Add the digital order fields based on input from the html page.
	$merchTxnRef = $_POST["MerchTxnRef"];
	$gateway     = $_POST["Gateway"];
	$card        = $_POST["CardType"];
	$cardNum     = $_POST["CardNum"];
	
	
	if (strlen($merchTxnRef) > 0) {
	    $conn->addDigitalOrderField("MerchTxnRef", $merchTxnRef);
	}
	
	if (strlen($gateway) > 0) {
	    $conn->addDigitalOrderField("gateway", $gateway);
	}
	
	if (strlen($card) > 0) {
	    $conn->addDigitalOrderField("card", $card);
	}
	
	if (strlen($cardNum) > 0) {
	    $conn->addDigitalOrderField("CardNum", $cardNum);
	}
    
    
// need to concatenate the card month and expiry before adding to the digital order
	$cardExpiry = $_POST["CardExpYear"].$_POST["CardExpMonth"];
	if (strlen($cardExpiry) > 0) {
	    $conn->addDigitalOrderField("CardExp", $cardExpiry);
	}
    
// The fields below are the optional data fields that can be added to the digital order
// Add CSC/CVV/CID
    
	$cardSecurityCode = $_POST["CardSecurityCode"];
	if (strlen($cardSecurityCode) > 0){
	    $conn->addDigitalOrderField("CardSecurityCode", $cardSecurityCode);
	}
    
// Add Ticket Number
	$ticketNo = $_POST["TicketNo"];
	if (strlen($ticketNo) > 0) {
	    $conn->addDigitalOrderField("TicketNo", $ticketNo);
	}
    
// Add AVS Data - Compulsory fields for AVS
	$avsStreet =      $_POST["AVS_Street01"];
	$avsPostCode =    $_POST["AVS_PostCode"];
	
	if (strlen($avsStreet) > 0) {
	    $conn->addDigitalOrderField("AVS_Street01", $avsStreet);
	}
	
	if (strlen($avsPostCode) > 0) {
	    $conn->addDigitalOrderField("AVS_PostCode", $avsPostCode);
	}
	
// Optional AVS fields
	$avsCity =    $_POST["AVS_City"];
	$avsState =   $_POST["AVS_StateProv"];
	$avsCountry = $_POST["AVS_Country"];
	
	if (strlen($avsCity) > 0) {
	    $conn->addDigitalOrderField("AVS_City", $avsCity);
	}
	
	if (strlen($avsState) > 0) {
	    $conn->addDigitalOrderField("AVS_StateProv", $avsState);
	}
	
	if (strlen($avsCountry) > 0 ) {
	    $conn->addDigitalOrderField("AVS_Country", $avsCountry);
	}
    
// Add AAV data
	$billToTitle =        $_POST["BillTo_Title"];
	$billToFirstname =    $_POST["BillTo_Firstname"];
	$billToMiddlename =   $_POST["BillTo_Middlename"];
	$billToLastname =     $_POST["BillTo_Lastname"];
	$billToPhone =        $_POST["BillTo_Phone"];
	$shipToFullname =     $_POST["ShipTo_Fullname"];
	$shipToTitle =        $_POST["ShipTo_Title"];
	$shipToFirstname =    $_POST["ShipTo_Firstname"];
	$shipToMiddlename =   $_POST["ShipTo_Middlename"];
	$shipToLastname =     $_POST["ShipTo_Lastname"];
	$shipToPhone =        $_POST["ShipTo_Phone"];
	$shipToStreet01 =     $_POST["ShipTo_Street01"];
	$shipToCity =         $_POST["ShipTo_City"];
	$shipToState =        $_POST["ShipTo_StateProv"];
	$shipToPostCode =     $_POST["ShipTo_PostCode"];
	$shipToCountry =      $_POST["ShipTo_Country"];
    
	if (strlen($billToTitle) > 0) {
	    $conn->addDigitalOrderField("BillTo_Title", $billToTitle);
	}
	
	if (strlen($billToFirstname) > 0) {
	    $conn->addDigitalOrderField("BillTo_Firstname", $billToFirstname);
	}
	
	if (strlen($billToMiddlename) > 0) {
	    $conn->addDigitalOrderField("BillTo_Middlename", $billToMiddlename);
	}
	
	if (strlen($billToLastname) > 0) {
	    $conn->addDigitalOrderField("BillTo_Lastname", $billToLastname);
	}
	
	if (strlen($billToPhone) > 0) {
	    $conn->addDigitalOrderField("BillTo_Phone", $billToPhone);
	}
	
	if (strlen($shipToFullname) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Fullname", $shipToFullname);
	}
	
	if (strlen($shipToFirstname) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Firstname", $shipToFirstname);
	}
	
	if (strlen($shipToMiddlename) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Middlename", $shipToMiddlename);
	}
	
	if (strlen($shipToLastname) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Lastname", $shipToLastname);
	}
	
	if (strlen($shipToPhone) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Phone", $shipToPhone);
	}
	
	if (strlen($shipToStreet01) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Street01", $shipToStreet01);
	}
	
	if (strlen($shipToCity) > 0) {
	    $conn->addDigitalOrderField("ShipTo_City", $shipToCity);
	}
	
	if (strlen($shipToState) > 0) {
	    $conn->addDigitalOrderField("ShipTo_StateProv", $shipToState);
	}
	
	if (strlen($shipToPostCode) > 0) {
	    $conn->addDigitalOrderField("ShipTo_PostCode", $shipToPostCode);
	}
	
	if (strlen($shipToCountry) > 0) {
	    $conn->addDigitalOrderField("ShipTo_Country", $shipToCountry);
	}
    
// add APD data. It is important to note that APD data and ITD data cannot both be contained in the same transaction
	$apdDeptDate =                $_POST["APD_DeptDate"];
	$apdPassengerTitle =          $_POST["APD_PassengerTitle"];
	$apdPassengerFirstname =      $_POST["APD_PassengerFirstname"];
	$apdPassengerMiddlename =     $_POST["APD_PassengerMiddlename"];
	$apdPassengerLastname =       $_POST["APD_PassengerLastname"];
	$apdCardmemberTitle =         $_POST["APD_CardmemberTitle"];
	$apdCardmemberFirstname =     $_POST["APD_CardmemberFirstname"];
	$apdCardmemberMiddlename =    $_POST["APD_CardmemberMiddlename"];
	$apdCardmemberLastname =      $_POST["APD_CardmemberLastname"];
	$apdOrigin =                  $_POST["APD_Origin"];
	$apdDest =                    $_POST["APD_Dest"];
	$apdRoute =                   $_POST["APD_Route"];
	$apdCarriers =                $_POST["APD_Carriers"];
	$apdFareBasis =               $_POST["APD_FareBasis"];
	$apdNumPassengers =           $_POST["APD_NumPassengers"];
	$apdeTicket =                 $_POST["APD_eTicket"];
	$apdResCode =                 $_POST["APD_ResCode"];
	$apdTravelAgentCode =         $_POST["APD_TravelAgentCode"];
	
	if (strlen($apdDeptDate) > 0) {
	    $conn->addDigitalOrderField("APD_DeptDate", $apdDeptDate);
	}
	
	if (strlen($apdPassengerTitle) > 0) {
	    $conn->addDigitalOrderField("APD_PassengerTitle", $apdPassengerTitle);
	}
	
	if (strlen($apdPassengerFirstname) > 0) {
	    $conn->addDigitalOrderField("APD_PassengerFirstname", $apdPassengerFirstname);
	}
	
	if (strlen($apdPassengerMiddlename) > 0) {
	    $conn->addDigitalOrderField("APD_PassengerMiddlename", $apdPassengerMiddlename);
	}
	
	if (strlen($apdPassengerLastname) > 0) {
	    $conn->addDigitalOrderField("APD_PassengerLastname", $apdPassengerLastname);
	}
	
	if (strlen($apdCardmemberTitle) > 0) {
	    $conn->addDigitalOrderField("APD_CardmemberTitle", $apdCardmemberTitle);
	}
	
	if (strlen($apdCardmemberFirstname) > 0) {
	    $conn->addDigitalOrderField("APD_CardmemberFirstname", $apdCardmemberFirstname);
	}
	
	if (strlen($apdCardmemberMiddlename) > 0) {
	    $conn->addDigitalOrderField("APD_CardmemberMiddlename", $apdCardmemberMiddlename);
	}
	
	if (strlen($apdCardmemberLastname) > 0) {
	    $conn->addDigitalOrderField("APD_CardmemberLastname", $apdCardmemberLastname);
	}
	
	if (strlen($apdOrigin) > 0) {
	    $conn->addDigitalOrderField("APD_Origin", $apdOrigin);
	}
	
	if (strlen($apdDest) > 0) {
	    $conn->addDigitalOrderField("APD_Dest", $apdDest);
	}
	
	if (strlen($apdRoute) > 0) {
	    $conn->addDigitalOrderField("APD_Route", $apdRoute);
	}
	
	if (strlen($apdCarriers) > 0) {
	    $conn->addDigitalOrderField("APD_Carriers", $apdCarriers);
	}
	
	if (strlen($apdFareBasis) > 0) {
	    $conn->addDigitalOrderField("APD_FareBasis", $apdFareBasis);
	}
	
	if (strlen($apdNumPassengers) > 0) {
	    $conn->addDigitalOrderField("APD_NumPassengers", $apdNumPassengers);
	}
	
	if (strlen($apdeTicket) > 0) {
	    $conn->addDigitalOrderField("APD_eTicket", $apdeTicket);
	}
	
	if (strlen($apdResCode) > 0) {
	    $conn->addDigitalOrderField("APD_ResCode", $apdResCode);
	}
	
	if (strlen($apdTravelAgentCode) > 0) {
	    $conn->addDigitalOrderField("APD_TravelAgentCode", $apdTravelAgentCode);
	}
	
// Add the ITD data. It is important to note that you can only add either ITD or APD data to the transaction, not both.
    
	$customerEmail =          $_POST["CustomerEmail"];
	$itdCustomerHostname =    $_POST["ITD_CustomerHostname"];
	$itdCustomerBrowser =     $_POST["ITD_CustomerBrowser"];
	$itdShipMethodCode =      $_POST["ITD_ShipMethodCode"];
	$itdShipToCountryCode =   $_POST["ITD_ShipToCountryCode"];
	$itdMerchantSKU =         $_POST["ITD_MerchantSKU"];
	$customerIpAddress =      $_POST["CustomerIpAddress"];
	$itdCustomerANI =         $_POST["ITD_CustomerANI"];
	$itdCustomerANICallType = $_POST["ITD_CustomerANICallType"];
	
	if (strlen($customerEmail) > 0) {
	    $conn->addDigitalOrderField("CustomerEmail", $customerEmail);
	}
	
	if (strlen($itdCustomerHostname) > 0) {
	    $conn->addDigitalOrderField("ITD_CustomerHostname", $itdCustomerHostname);
	}
	
	if (strlen($itdCustomerBrowser) > 0) {
	    $conn->addDigitalOrderField("ITD_CustomerBrowser", $itdCustomerBrowser);
	}
	
	if (strlen($itdShipMethodCode) > 0) {
	    $conn->addDigitalOrderField("ITD_ShipMethodCode", $itdShipMethodCode);
	}
	
	if (strlen($itdShipToCountryCode) > 0) {
	    $conn->addDigitalOrderField("ITD_ShipToCountryCode", $itdShipToCountryCode);
	}
	
	if (strlen($itdMerchantSKU) > 0) {
	    $conn->addDigitalOrderField("ITD_MerhchantSKU", $itdMerchantSKU);
	}
	
	if (strlen($customerIpAddress) > 0) {
	    $conn->addDigitalOrderField("CustomerIpAddress", $customerIpAddress);
	}
	
	if (strlen($itdCustomerANI) > 0) {
	    $conn->addDigitalOrderField("ITD_CustomerANI", $itdCustomerANI);
	}
	
	if (strlen($itdCustomerANICallType) > 0) {
	    $conn->addDigitalOrderField("ITD_CustomerANICallType", $itdCustomerANICallType);
	}



// Generate Digital Order

	$orderInfo        = $_POST["OrderInfo"];
	$merchantID       = $_POST["Merchant"];
	$amount           = $_POST["Amount"];
	
	$locale           = "en";
	$returnURL        = $_POST["ReturnURL"];

// add Againlink to ReturnURL for DR Servlet page
// application session variables can be added in the same way
	$returnURL = $returnURL  . "&AgainLink=" . urlencode($againLink) . "&Title=" . urlencode($title) . "&HostName=" . $payClientIP . "&Port=" . $portNo . "&DebugOn=" . $getDebug;
    
	$digitalOrder = $conn->getDigitalOrder($orderInfo, $merchantID, $amount, $locale, $returnURL);
    
// close the sockect connection as we are now finished with it
	$conn->close();
    
/*
* Provided nothing has gone wrong up until now, the following
* line redirects the purchaser's browser to the URL specified
* by digitalOrder. That is, a session is established with
* the Payment Server and the DO is transmitted via an HTTP GET
* operation. The DO is decrypted and verified by the Payment
* Server and a Digital Receipt (DR) is sent back via a
* browser redirect from the Payment Server. A separate servlet
* is provided to handle the processing of the DR.
    */
    
// Check for error messages
$errorMessage = $conn->getErrorMessage();

if ($errorMessage == "") {
	
	if (!$getDebug) {
		// Transmit the DO to the Payment Server via a browser redirect
		header("Location: ".$digitalOrder);
	
	} else {

		// Click on a link to send the DO to the Payment Server
		?><a href='<?=$digitalOrder?>'>Click here to proceed.</a><?php
  }
  
  
  
} else {

// set the title
	$title = $title . " Error Page";

// if exception is empty then set it to a value
  if (strlen($errorMessage) == 0) {
      $errorMessage = "No Further Information Returned";
  }

?>    
<!DOCTYPE HTML PUBLIC '-'W3C'DTD HTML 4.01 Transitional'EN'>
<head><title><?=$title?></title>
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
            <td bgcolor='#CED7EF' width='90%'><h2 class='co'>&nbsp;Amex Payment Client 3.1 Example</h2></td>
            <td bgcolor='#0074C4' align='center'><h3 class='co'>Dialect<br>Payments</h3></td>
        </tr>
    </table>
    <!-- end branding table -->

    <center><h1><br><?=$title?></h1></center>
    
    <table align="center" border="0" width="70%">
        
        <tr class="title">
            <td colspan="2"><p><strong>&nbsp;Transaction Digital Order Fields</strong></p></td>
        </tr>
        <tr>    
            <td align="right"><strong><em>Merchant ID: </em></strong></td>
            <td><?=$merchantID?></td>
        </tr>
        <tr class="shade">    
            <td align="right"><strong><em>OrderInfo: </em></strong></td>
            <td><?=$orderInfo?></td>
        </tr>
        <tr>    
            <td align="right"><strong><em>Transaction Amount: </em></strong></td>
            <td><?=$amount?></td>
        </tr>
        <tr class="shade">    
            <td align="right"><strong><em>Locale: </em></strong></td>
            <td><?=$locale?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <div class='bl'>Fields above are the Digital Order values used.<hr>Error information is shown below.</div>
            </td>
        </tr>
        <tr class="title">
            <td colspan="2"><p><strong>&nbsp;Error in processing the data</strong></p></td>
        </tr>
        <tr>
            <td align='right' width='35%'><em><strong>Error Description: </strong></em></td>
            <td><?=$errorMessage?></td>
        </tr>
        <tr>
            <td  width="45%">&nbsp;</td>
            <td  width="55%">&nbsp;</td>
        </tr>
        <tr>    
            <td colspan="2" align="center"><a href='<?=$againLink?>'>Another Transaction</a></td>
        </tr>
    </table>
</body>
</html>

<?php
}
?>