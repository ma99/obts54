<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\GuestUser;

use App\Repositories\PaymentRepository;

class PaymentController extends Controller
{
	//protected $amount;
	protected $payment;

	public function __construct(PaymentRepository $payment)
    {
	    $this->payment = $payment;
    }

    /*
    bookingId as setInvoiceNumber
    user_id as customerId
    amount as amount
    */
    public function payNow(Booking $booking)
    {
    	$bookingId = $booking->id;
    	$userId = $booking->user_id;
    	//$bk = Booking::find($bookingId);
    	$user = User::find($userId);
    	if ($user) {
    		//return $user;   		
    	} else 
    	{
    		$user = GuestUser::find($userId);
    		//return $user; 
    	}
    	
    	$amount = 2.23;

    	//$this->payment->chargeCreditCard(2.23);
    	$this->payment->chargeCreditCard($bookingId, $user, $amount);
    }

}