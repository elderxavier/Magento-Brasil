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
 
require('PaymentCodesHelper.php');

class PaymentClientConnection {
	
	// Define Variables
	// ----------------

	private $SHORT_SOCKET_TIMEOUT = 5;        // The maximum number of seconds required to perform simple Payment Client commands
	private $LONG_SOCKET_TIMEOUT  = 100;	    // The maximum number of seconds required to perform extended Payment Client commands
	
	public $debug = false;                    // Turn on/off debugging functionality

	private $errorExists = false;             // Indicates if an error exists
	private $errorMessage;                    // The error message

	private $socketCreated = false;           // Indicates if a socket connection has been established
	private $payClientSocket = -1;            // Resource ID for the socket connection

	private $payClientTimeout;                // Timeout setting between PHP and Payment Client


	public function connect($payClientIP = "127.0.0.1", $payClientPort = 9050) {
	
		// Create the socket connection to the Payment Client
		
		// Set error message variables
		$errno = "";
		$errstr = "";
		
		// Set defaults
    $this->errorExists = false;
    $this->socketCreated = false;		
		
		// Validate Payment Client connection information
		
		if (strlen($payClientIP) > 0 && $payClientPort > 0) {

				$this->payClientTimeout = $this->SHORT_SOCKET_TIMEOUT;
		    $this->payClientSocket = @fsockopen($payClientIP, $payClientPort, $errno, $errstr, $this->payClientTimeout);
		    
		} else {
			
		    $this->errorMessage = "(44) Incorrect data to create a socket connection to Payment Client - Host:$payClientIP Port:$payClientPort";
		    $this->errorExists = true;
		    
		}
		
		
		if (!$this->errorExists && $this->payClientSocket < 1) {

		    // Display an error page as the socket connection failed
		    $this->errorMessage = "(45) Failed to create a socket connection to Payment Client - Host:$payClientIP Port:$payClientPort";
		    $this->errorExists = true;

		} else {

		    $this->socketCreated = true;
		  
		}

	}
	

	public function echoTest($echoMessage = "Test") {
		
		// This function tests the communication to the Payment Client using an "echo" command.

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists
		
	  $cmdResponse = $this->sendCommand("1,$echoMessage");

	  if (substr($cmdResponse,2) != "echo:$echoMessage") {

	        // Display an error as the communication to the Payment Client failed
	        $this->errorMessage = "(5) Failed to complete echo test to Payment Client - should be: Should be: '1,echo:$echoMessage', but received: '$cmdResponse'";
	        $this->errorExists = true;
	        
	        return false;
	    }

		return true;
		
	}	
	
	
	public function addDigitalOrderField($field, $value) {
		

		if ($this->errorExists) return false;           // Exit function if an error exists
    if (strlen($value) == 0) return false;          // Exit function if there is no Digital Order data to add
		

		// Send the command to the Payment Client
    $cmdResponse = $this->sendCommand("7,$field,$value");

		// Check if errors exist
    if (substr($cmdResponse,0,1) != "1") {
    	
        $this->errorMessage = "(6) Failed to add supplementary data using addDigitalOrderField command - ".$field.". Response=".$cmdResponse;
        $this->errorExists = true;
        
        return false;        
		}
		
		return true;
		
	}

	
	public function addAdminCommandField($field, $value) {
		

		if ($this->errorExists) return false;           // Exit function if an error exists
    if (strlen($value) == 0) return false;          // Exit function if there is no Digital Order data to add
		

		// Send the command to the Payment Client
    $cmdResponse = $this->sendCommand("28,$field,$value");

		// Check if errors exist
    if (substr($cmdResponse,0,1) != "1") {
    	
        $this->errorMessage = "(6) Failed to add supplementary data using addAdminCommandField command - ".$field.". Response=".$cmdResponse;
        $this->errorExists = true;
        
        return false;        
		}
		
		return true;
		
	}

	
	public function sendMOTODigitalOrder($orderInfo, $merchantID, $amount, $locale = "en", $returnURL = "") {
		
		// Generate and Send Digital Order (& receive DR)
		// *******************************************************

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


		
		// Set the socket timeout value to long value for the primary
		// command as it sends and receives data to the Payment Server.
		$this->payClientTimeout = $this->LONG_SOCKET_TIMEOUT;

		// (This primary command also receives the encrypted Digital Receipt)
    $cmdResponse = $this->sendCommand("6,$orderInfo,$merchantID,$amount,$locale,$returnURL");
    
    if (substr($cmdResponse,0,1) != "1") {
        // Retrieve the Payment Client Error (There may be none to retrieve)
        $cmdResponse = $this->sendCommand("4,PaymentClient.Error");
				if (substr($cmdResponse,0,1) == "1") {$exception = substr($cmdResponse,2);}

        $this->errorMessage = "(11) Digital Order has not created correctly - sendMOTODigitalOrder($orderInfo,$merchantID,$amount,$locale,$returnURL) failed - $exception";
        $this->errorExists = true;
        
        return false;
        
    }

		// Set the socket timeout value to normal
		$this->payClientTimeout = $this->SHORT_SOCKET_TIMEOUT;

		// Automatically call the nextResult function
		$this->nextResult();
		
		return true;

	}
	
	
	public function getDigitalOrder($orderInfo, $merchantID, $amount, $locale = "en", $returnURL) {
		
		// Generate Digital Order
		// *******************************************************

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


		
		// This primary command also receives the encrypted Digital Receipt
    $cmdResponse = $this->sendCommand("2,$orderInfo,$merchantID,$amount,$locale,$returnURL");
    
    if (substr($cmdResponse,0,1) != "1") {
        
				$exception = substr($cmdResponse,2);

        $this->errorMessage = "(11) Digital Order has not created correctly - getDigitalOrder($orderInfo,$merchantID,$amount,$locale,$returnURL) failed - $exception";
        $this->errorExists = true;
        
        return false;
        
    }

		return substr($cmdResponse,2);		
		
	}

	
	public function decryptDR($digitalReceipt) {
		
		// Decrypt Digital Receipt
		// ********************************


		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists



		// (This primary command to decrypt the Digital Receipt)
    $cmdResponse = $this->sendCommand("3,$digitalReceipt");
    
    if (substr($cmdResponse,0,1) != "1") {
        // Retrieve the Payment Client Error (There may be none to retrieve)
        $cmdResponse = $this->sendCommand("4,PaymentClient.Error");
				if (substr($cmdResponse,0,1) == "1") {$exception = substr($cmdResponse,2);}

        $this->errorMessage = "(11) Digital Order has not created correctly - decryptDR($digitalReceipt) failed - $exception";
        $this->errorExists = true;
        
        return false;
        
    }

		// Set the socket timeout value to normal
		$this->payClientTimeout = $this->SHORT_SOCKET_TIMEOUT;

		// Automatically call the nextResult function
		$this->nextResult();
		
		return true;



		
	}
	
	
	public function nextResult() {
		

		// Step 5 - Check the Digital Receipt to see if there is a valid result
		// ====================================================================
		// Use the "nextResult" command to check if the Payment Client contains a
		// valid Hash table containing the receipt results.
		
		
		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists
				
		$cmdResponse = $this->sendCommand("5,");

    if (substr($cmdResponse,0,1) != "1") {
        // Retrieve the Payment Client Error (There may be none to retrieve)
        if ($this->payClientSocket != "") {
            $cmdResponse = $this->sendCommand("4,PaymentClient.Error");
            if (substr($cmdResponse,0,1) == "1") {
                $exception = substr($cmdResponse,2);
            }
        }
        
        // Display an error message as the command failed
        $this->errorMessage = "(12) No Results for Digital Receipt: $exception";
        $this->errorExists = true;
        
        return false;

    }
    
    return true;

	}


	public function doAdminCapture($merchantID,$transactionNo,$captureAmount,$username,$password) {
		
		// Send capture command to the Payment Client
		// *******************************************************

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


		// Set the socket timeout value to long value for the primary
		// command as it sends and receives data to the Payment Server.
		$this->payClientTimeout = $this->LONG_SOCKET_TIMEOUT;


		// This command performs the capture
    $cmdResponse = $this->sendCommand("14,$merchantID,$transactionNo,$captureAmount,$username,$password");
    
    if (substr($cmdResponse,0,1) != "1") {
        
				$exception = substr($cmdResponse,2);

        $this->errorMessage = "(11) Digital Order has not created correctly - doAdminCapture($merchantID,$transactionNo,$captureAmount,$username,$password) failed - $exception";
        $this->errorExists = true;
        
        return false;
        
    }

		// Set the socket timeout value to normal
		$this->payClientTimeout = $this->SHORT_SOCKET_TIMEOUT;

		// Automatically call the nextResult function
		$this->nextResult();
		
		return true;

	}
	

	public function doAdminRefund($merchantID,$transactionNo,$refundAmount,$username,$password) {
		
		// Send capture command to the Payment Client
		// *******************************************************

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


		// Set the socket timeout value to long value for the primary
		// command as it sends and receives data to the Payment Server.
		$this->payClientTimeout = $this->LONG_SOCKET_TIMEOUT;


		// This command performs the capture
    $cmdResponse = $this->sendCommand("15,$merchantID,$transactionNo,$refundAmount,$username,$password");
    
    if (substr($cmdResponse,0,1) != "1") {
        
				$exception = substr($cmdResponse,2);

        $this->errorMessage = "(11) Digital Order has not created correctly - doAdminRefund($merchantID,$transactionNo,$refundAmount,$username,$password) failed - $exception";
        $this->errorExists = true;
        
        return false;
        
    }

		// Set the socket timeout value to normal
		$this->payClientTimeout = $this->SHORT_SOCKET_TIMEOUT;

		// Automatically call the nextResult function
		$this->nextResult();
		
		return true;

	}public function doAdminQuery($merchantID,$merchTxnRef,$username,$password) {
		
		// Send query command to the Payment Client
		// *******************************************************

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


		// Set the socket timeout value to long value for the primary
		// command as it sends and receives data to the Payment Server.
		$this->payClientTimeout = $this->LONG_SOCKET_TIMEOUT;


		// This command performs the query
    $cmdResponse = $this->sendCommand("29,$merchantID,$merchTxnRef,$username,$password");
    
    if (substr($cmdResponse,0,1) != "1") {
        
				$exception = substr($cmdResponse,2);

        $this->errorMessage = "(11) Digital Order has not created correctly - doAdminQuery($merchantID,$merchTxnRef,$username,$password) failed - $exception";
        $this->errorExists = true;
        
        return false;
        
    }

		// Set the socket timeout value to normal
		$this->payClientTimeout = $this->SHORT_SOCKET_TIMEOUT;

		// Automatically call the nextResult function
		$this->nextResult();
		
		return true;

	}
	
		
	public function DRExists() {
		

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


    $cmdResponse = $this->sendCommand("4,QueryDR.DRExists");
    
    return substr($cmdResponse,0,1) == "1" ? substr($cmdResponse,2) : "";
    
	}


	public function FoundMultipleDRs() {
		

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


    $cmdResponse = $this->sendCommand("4,QueryDR.FoundMultipleDRs");
    
    return substr($cmdResponse,0,1) == "1" ? substr($cmdResponse,2) : "";
    
	}


	public function getResultField($field) {
		

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


    $cmdResponse = $this->sendCommand("4,".$field);
    
    return substr($cmdResponse,0,1) == "1" ? substr($cmdResponse,2) : "";
    
	}


	public function getAvailableFieldKeys() {
		

		if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
		if ($this->errorExists) return false;           // Exit function if an error exists


    $cmdResponse = $this->sendCommand("33");
    
    return substr($cmdResponse,0,1) == "1" ? substr($cmdResponse,2) : "";
    
	}


	public function sendCommand($command) {

			// This function sends the command to the Payment Client and retrieves the
			// response for the main body of the example. If an error is encountered
			// an error page is displayed.
			//
			// @param $command  - String that will be sent to the Payment Client Socket
			//
			// @return True if the command was sent successfully


			if (!$this->socketCreated) return false;        // Exit function if an the socket connection hasn't been created
			if ($this->errorExists) return false;           // Exit function if an error exists


			socket_set_timeout($this->payClientSocket, $this->payClientTimeout);
		
	    $this->debug("<font color='#FF0066'>Sent : ".$command."</font>");
	    
	    
	    // output the data to the socket & read in the response
	    $buf = $command . "\n";
	    $response = fputs($this->payClientSocket, $buf) == strlen($buf);    
	    if (!$response) {

        // Display an error as there has been a communication error
        $this->errorMessage = "(46) Socket communication error - received: no response, sent: '$command'";
        $this->errorExists = true;
        
        return false;
	        
	    }    
	    
	    // Set the time to stop reading using the globale timeout variable
	    $stop=time() + $this->payClientSocket;
	    $reply="";
	    while (!strpos($reply,"\n")) {
		    // Check to see if we have timed out
	        if (time() >= $stop) {

	          $this->errorMessage = "(49) Socket communication error: socket timed out waiting for reply - sent: '$command'";
		        $this->errorExists = true;
		        
		        return false;

	        }
	        $reply .= fgets($this->payClientSocket, 4096);
	    }
	    

      $this->debug("<font color='#008800'>Recd: ".$reply."</font><br />");

	
	    // return the socket response
	    return chop($reply);
	    
	}
	
	
	public function getErrorMessage() {
		return $this->errorMessage;
	}


	public function debug($message) {

		// If debugging is enabled, send a message to the debug processor
		if ($this->debug) {
			
			// Make the message HTML compatible
			//$replaceChars = array(" ", "<", ">", "\n");
			//$replacementChars = array("&nbsp;", "&lt;", "&gt;", "<br/>");
			//$htmlMessage = str_replace($replaceChars, $replacementChars, $message);

			echo $message."<br>\n";
		}
	
		return true;
	
	}
	
	
	public function close() {

		// This function closes the socket connection

		if (!$this->socketCreated) return false;           // Exit function if the a socket connection has not been created 

    $buf = "99";
    $response = @fputs($this->payClientSocket, $buf) == strlen($buf);    
    @fclose($this->payClientSocket);
    
    return true;
	}
	
	
}

?>