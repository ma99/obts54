<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Events\SeatStatusUpdatedEvent;
use App\Booking;
use App\User;
use App\GuestUser;
use App\Payment;
use App\Seat;
use GuzzleHttp\Client;

use App\Repositories\SslcommerzRepository;

class PaymentController extends Controller
{
	//protected $amount;
	protected $payment;

	public function __construct(SslcommerzRepository $payment)
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
    	/*$bookingId = $booking->id;
        $scheduleId = $booking->schedule_id;        
        //$travelDate = $booking->date;
        $travelDate = date("d-m-Y", strtotime($booking->date)) ;
    	$userId = $booking->user_id;
        
    	$user = User::find($userId);
    	$amount = 2.23;*/
    	//$this->payment->chargeCreditCard(2.23);        
        //$this->payment->makeMyPayment();
        $bookingId = $booking->id;
        $gwUrl = 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php';               
        return view('payment.payment', compact('gwUrl', 'bookingId'));
    }


    public function removeSeatBookedOrBuyingStatus($bookingId, $scheduleId, $travelDate){
        // by Deleting from bookings, seats table

        Booking::destroy($bookingId); // deleting by pk

        $seats = Seat::where('booking_id', $bookingId)->get();            
            foreach ($seats as $seat) {
                $updateSeatInfo = [
                        'seat_no' => $seat->seat_no,
                        'status' => 'available',
                    ];
                $seat->delete();
                $updateSeatInfo = json_decode(json_encode($updateSeatInfo), FALSE); //array to object
                broadcast(new SeatStatusUpdatedEvent($updateSeatInfo, $scheduleId, $travelDate))->toOthers();
            }
        return;
    }

    public function updateSeatStatus($bookingId, $scheduleId, $travelDate)
    {
        $seats = Seat::where('booking_id', $bookingId)->get();            
            foreach ($seats as $seat) {
                $seat->update([
                        'status' => 'confirmed',
                    ]);
                broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            }
        return;
    }

    public function success(Request $request)
    {
        return view('payment.success', compact('request'));
        //return $request;
    }
    
    public function fail()
    {
       // return 'FAILED';
       return view('payment.failed');
    }

    public function cancel()
    {
        return 'CANCELLED';
        //return view('payment.failed');
    }

    public function payNow2(Booking $booking)
    {
        /*$bookingId = $booking->id;
        $scheduleId = $booking->schedule_id;        
        //$travelDate = $booking->date;
        $travelDate = date("d-m-Y", strtotime($booking->date)) ;
        $userId = $booking->user_id;
        
        $user = User::find($userId);
        $amount = 2.23;*/
        //$this->payment->chargeCreditCard(2.23);        
        //$this->payment->makeMyPayment();
        $bookingId = $booking->id;
        //$txr = $this->payment->makeMyPayment($bookingId);
        //dd($txr);
        //$gwUrl = 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php';               
        //return view('payment.payment', compact('gwUrl', 'bookingId'));
        $client = new Client();
        //$response = $client->request('POST', 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php', [
        $client->request('POST', 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php', [
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
                'submit' => 'Pay+Now'              
            ]
        ]);
    }


}