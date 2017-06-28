<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class SslcommerzRepository
{
	//protected $amount;

	public function __construct()
    {
       
    }
	
	//public function makeMyPayment($bookingId, $user, $amount)
	public function makeMyPayment($bookingId)
	{
		// // Common setup for API credentials
		// <form id="payment_gw" name="payment_gw" method="POST" action="https://sandbox.sslcommerz.com/gwprocess/v3/process.php">
		// 	<input type="hidden" name="total_amount" value="1150.00" />
		// 	<input type="hidden" name="store_id" value="testbox" />
		// 	<input type="hidden" name="tran_id" value="594e9719c2e59" />
		// 	<input type="hidden" name="success_url" value="https://sandbox.sslcommerz.com/developer/success.php" />
		// 	<input type="hidden" name="fail_url" value="https://sandbox.sslcommerz.com/developer/fail.php" />
		// 	<input type="hidden" name="cancel_url" value="https://sandbox.sslcommerz.com/developer/cancel.php" />
		// 	<input type="hidden" name="version" value="3.00" />	

		// 	<!-- Customer Information !-->
		// 	<input type="hidden" name="cus_name" value="ABC XYZ">
		// 	<input type="hidden" name="cus_email" value="abc.xyz@mail.com">	
			
		// 	<!-- SUBMIT REQUEST  !-->
		// 	<input type="submit" name="submit" value="Pay Now" />
		// </form>
		// https://sandbox.sslcommerz.com/gwprocess/v3/gw.php?Q=PAY&SESSIONKEY=51DCEFD13E008BD86D99DCD95A3EA7C9
		// https://sandbox.sslcommerz.com/gwprocess/v3/gw.php?Q=PAY&SESSIONKEY=95BAB58C2D023012AE7BA5B18F55487F
		$client = new Client();
		//$response = $client->request('POST', 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php', [
		$response = $client->request('POST', 'https://requestb.in/1j7we5l1', [
		    'form_params' => [
		        'total_amount' => '1150.00',
		        'store_id' => 'testbox',
		        'tran_id' => $bookingId,
		        'success_url' => route('success'),
            	//'fail_url' => route('fail', ['id' => 'F9997499']),//'http://localhosthttp://localhost/api/payment/fail',
            	'fail_url' => route('fail'), //http://localhost/api/payment/fail',
            	'cancel_url' => 'http://localhost/payment/cancel/F9997499',
		        'cus_name' => 'ABC XYZ',		       
		        'cus_email' => 'abc.xyz@mail.com',		       
		        'version' => '3.0.0',		       
		    ]
		]);
		//return $response->getBody();		
		dd($response);		

	}

	

}
