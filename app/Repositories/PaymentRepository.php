<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use App\Samplecode\Constants;

require '../vendor/autoload.php';

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
define("AUTHORIZENET_LOG_FILE", "phplog");


class PaymentRepository
{
	//protected $amount;

	public function __construct()
    {
       //$amount = \SampleCode\Constants::SAMPLE_AMOUNT;
		// if (!defined('DONT_RUN_SAMPLES')) {
	 //  		$this->chargeCreditCard($amount);
		// }
    }
	
	

	public function chargeCreditCard($bookingId, $user, $amount)
	{
	    // Common setup for API credentials
	    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
	    $merchantAuthentication->setName(Constants::MERCHANT_LOGIN_ID);
	    $merchantAuthentication->setTransactionKey(Constants::MERCHANT_TRANSACTION_KEY);
	    $refId = 'ref' . time();
	    // Create the payment data for a credit card 
	    //Payment Information 
	    $creditCard = new AnetAPI\CreditCardType();
	    $creditCard->setCardNumber("4111111111111111");
	    $creditCard->setExpirationDate("1226");
	    $creditCard->setCardCode("123");
	    $paymentOne = new AnetAPI\PaymentType();
	    $paymentOne->setCreditCard($creditCard);

	    //Order Information
	    $order = new AnetAPI\OrderType();
	    $order->setDescription("Payment For Seat");
	    $order->setInvoiceNumber($bookingId); // seat booking ref

	    // Set the customer's Bill To address
	    $customerAddress = new AnetAPI\CustomerAddressType();
	    $customerAddress->setFirstName($user->name);
	    // $customerAddress->setLastName("Johnson");
	    // $customerAddress->setCompany("Souveniropolis");
	    // $customerAddress->setAddress("14 Main Street");
	    // $customerAddress->setCity("Pecan Springs");
	    // $customerAddress->setState("TX");
	    // $customerAddress->setZip("44628");
	    // $customerAddress->setCountry("USA");
	    
	    // Set the customer's identifying information
	    $customerData = new AnetAPI\CustomerDataType();
	    $customerData->setType("individual");
	    $customerData->setId($user->userId); // customerId
	    //$customerData->setEmail("EllenJohnson@example.com");
	    $customerData->setEmail($user->email);
	    
	    //Add values for transaction settings
	    $duplicateWindowSetting = new AnetAPI\SettingType();
	    $duplicateWindowSetting->setSettingName("duplicateWindow");
	    $duplicateWindowSetting->setSettingValue("600");
	    
	    // Create a TransactionRequestType object
	    $transactionRequestType = new AnetAPI\TransactionRequestType();
	    $transactionRequestType->setTransactionType( "authCaptureTransaction"); 
	    $transactionRequestType->setAmount($amount);
	    $transactionRequestType->setOrder($order);
	    $transactionRequestType->setPayment($paymentOne);
	    $transactionRequestType->setBillTo($customerAddress);
	    $transactionRequestType->setCustomer($customerData);
	    $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
	    
	    $request = new AnetAPI\CreateTransactionRequest();
	    $request->setMerchantAuthentication($merchantAuthentication);
	    $request->setRefId( $refId);
	    $request->setTransactionRequest( $transactionRequestType);
	    $controller = new AnetController\CreateTransactionController($request);
	    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	    
	    if ($response != null)
	    {
	      if($response->getMessages()->getResultCode() == Constants::RESPONSE_OK)
	      {
	        $tresponse = $response->getTransactionResponse();
	        
	        if ($tresponse != null && $tresponse->getMessages() != null)   
	        {
	          echo " Transaction Response Code : " . $tresponse->getResponseCode() . "\n";
	          echo " Successfully created an authCapture transaction with Auth Code : " . $tresponse->getAuthCode() . "\n";
	          echo " Transaction ID : " . $tresponse->getTransId() . "\n";
	          echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
	          echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
	        }
	        else
	        {
	          echo "Transaction Failed \n";
	          if($tresponse->getErrors() != null)
	          {
	            echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
	            echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";            
	          }
	        }
	      }
	      else
	      {
	        echo "Transaction Failed \n";
	        $tresponse = $response->getTransactionResponse();
	        
	        if($tresponse != null && $tresponse->getErrors() != null)
	        {
	          echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
	          echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";                      
	        }
	        else
	        {
	          echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
	          echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
	        }
	      }      
	    }
	    else
	    {
	      echo  "No response returned \n";
	    }
	    return $response;
  	}

}
