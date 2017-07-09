<?php

namespace App\Repositories\Payment;

use Illuminate\Http\Request;
use App\Booking;
use App\User;

class PaymentRepository
{
	//protected $amount;
	protected $onlineCharge = 3.5;


	public function __construct()
    {
       //$this->setOnlineCharge();
    }

    public function findUserInfo($userId)
    {
    	return User::find($userId);
    }

    public function setSessionForBookingInfo(array $booking, Request $request)
    {
    	     
        // $amount = $booking->amount;
        // $totalOnlineCharge = $this->onlineCharge*$amount; //3.5%
        // $totalAmount = $amount + $totalOnlineCharge;

    	//create Session for $bookingId, $amount, $totalAmount
        // $this->request->session()->put('booking_id', $booking['booking_id']);
        // $this->request->session()->put('schedule_id', $booking->['schedule_id']);
        // $this->request->session()->put('travel_date', $booking['travel_date']);
        // //$this->request->session()->put('amount', $amount);
        // $this->request->session()->put('total_amount', $booking['total_amount']);

        foreach ($booking as $key => $value) {
        	$request->session()->put($key, $value);
        }

        return;
    }

    public function getSessionForBookingInfo()
    {
    	// $bookingId = session('booking_id');
     //    $scheduleId = session('schedule_id');
     //    $travelDate = session('travel_date');            
     //    $totalAmount = session('total_amount');

        return $sessionBookingInfo = [
        	'bookingId' => session('booking_id'),
	        'scheduleId' => session('schedule_id'),
	        'travelDate' => session('travel_date'),           
	        'totalAmount' => session('total_amount')
        ];

    }
    // public function setOnlineCharge()
    // {
    	// find $value from database settings table
    // 	$this->onlineCharge = $value/100;
    // 	return;
    // }

    public function getOnlineCharge()
    {
    	return ($this->onlineCharge/100);
    }
}