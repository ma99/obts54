<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\GuestUser;
use App\Payment;

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
        //$amount = 0
    	//$bk = Booking::find($bookingId);
    	$user = User::find($userId);
    	// if ($user) {
    	// 	//return $user;   		
    	// } else 
    	// {
    	// 	$user = GuestUser::find($userId);
    	// 	//return $user; 
    	// }
    	
    	$amount = 2.23;
    	//$this->payment->chargeCreditCard(2.23);
    	$trxData = $this->payment->chargeCreditCard($bookingId, $user, $amount);
        if ($trxData) {
            $payment = Payment::create([
                    'booking_id' => $bookingId,
                    'amount' => $booking->amount, //$amount = $booking->amount
                    'transaction_id' => $trxData->transaction_id,
                    'auth_code' => $trxData->auth_code,
                    'status' => $trxData->status,
                    'description' => $trxData->description
                ]);
            $payment = json_decode(json_encode($payment), FALSE); //array to object
            return view('payment.success', compact('payment')); 
        }
        //$payment = 'Payment Failed'; //array to object
        return view('payment.failed');          
    }

}