<?php 

namespace App\Repositories\Payment;

use App\SslcommerzPayment;
use Illuminate\Http\Request;



class PaymentCancelledRepository implements PaymentRepositoryInterface
{
    
    protected $payment;

    public function __construct(PaymentRepository $payment)
    {
       $this->payment = $payment;	   
    }

    public function action(Request $request)
    {
         
    	$sessionBookingInfo = $this->payment->getSessionForBookingInfo();
    	extract($sessionBookingInfo); //$bookingId, $scheduleId, $travelDate, $totalAmount

        $bookingId = session('booking_id');
        $totalAmount = session('total_amount');

        $payment_status = 'cancelled';
        $tran_id = isset($request->tran_id) ? $request->tran_id : null; 
        
        if ($tran_id !== null && strlen($tran_id) > 0) {
            $payment_data = $request->all(); // all of the input data as an array

            $validation_data = array(
                'error' => (isset($request->error) ? $request->error : 'User cancelled payment')
            );

            SslcommerzPayment::create([
                'booking_id' => $bookingId,
                'total_amount' => $totalAmount,
                'payment_data' => $payment_data,
                'validation_data' => $validation_data,
                'validation_date' => date('Y-m-d H:i:s'),
                'payment_status' => $payment_status,
            ]);
        }
        // validatio message
        $validation_message = '';
        if (isset($validation_data['error'])) {
            $validation_message = $validation_data['error'];
        } else {
            if ($payment_status != 'success') {
                $validation_message = 'Payment cancelled';
            }
        }

        return [
            'payment_status' => $payment_status, 
            'validation_message' => $validation_message, 
            // 'status' => $status,            
            'bookingId' => $bookingId,
        ];
    }
}