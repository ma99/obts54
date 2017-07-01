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
	protected $request;


	public function __construct(SslcommerzRepository $payment, Request $request)
    {
        $this->payment = $payment;
	    $this->request = $request;
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
        $amount = $booking->amount;
        $onlineCharge = 0.035*$amount; //3.5%
        $totalAmount = $amount + $onlineCharge;
        $user = User::find($booking->user_id);
        $name = $user->name;
        $email = $user->email;

        //create Session for $bookingId, $amount, $totalAmount
        $this->request->session()->put('booking_id', $bookingId);
        //$this->request->session()->put('amount', $amount);
        $this->request->session()->put('total_amount', $totalAmount);

        $gwUrl = 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php';               
        return view('payment.payment', compact(
                        'gwUrl', 
                        'bookingId', 
                        'amount',
                        'onlineCharge',
                        'totalAmount', 
                        'name', 
                        'email'
                ));
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
     
       // 1. validate the transaction
                // Restore data from session as submited data
                /* $bookingId = $this->request->session()->get('booking_id');
                    $bookingId = session('booking_id');

                    //$amount = $this->request->session()->get('amount');
                    $totalAmount = $this->request->session()->get('total_amount');
                */

            //2. store to data base 
                //$bookingId, $totalAmount
                // $payment_data, $validation_data
        //3. updateSeatStatus 

        //clear session
       // $this->request->session()->forget('booking_id');
        //$this->request->session()->forget('amount');
       // $this->request->session()->forget('total_amount');


        return view('payment.success', compact('request'));
        //return $request;
    }
    
    public function fail()
    {
       // return 'FAILED';
        
        //1. store to data base 
        // 2. removeSeatBookedOrBuyingStatus

       return view('payment.failed');
    }

    public function cancel()
    {
        return 'CANCELLED';
        //return view('payment.failed');
    }

    public function payNow2(Booking $booking)
    {
        $bookingId = $booking->id;        
        $client = new Client();       
        $client->request('POST', 'https://sandbox.sslcommerz.com/gwprocess/v3/process.php', [
            'form_params' => [
                'total_amount' => '1150.00',
                'store_id' => 'testbox',
                'tran_id' => $bookingId,
                'success_url' => route('success'),            
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