<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\SeatStatusUpdatedEvent;
use App\Booking;
use App\User;
use App\GuestUser;
use App\Payment;
use App\Seat;

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
        $scheduleId = $booking->schedule_id;        
        //$travelDate = $booking->date;
        $travelDate = date("d-m-Y", strtotime($booking->date)) ;
    	$userId = $booking->user_id;
        
    	$user = User::find($userId);
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

            $this->updateSeatStatus($bookingId, $scheduleId, $travelDate);

            return view('payment.success', compact('payment')); 
        }         
        
        $this->removeSeatBookedOrBuyingStatus($bookingId, $scheduleId, $travelDate);
        return view('payment.failed');          
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

}