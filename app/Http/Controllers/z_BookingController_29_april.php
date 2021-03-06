<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\GuestUser;
use App\Seat;


class BookingController extends Controller
{
    

	protected $request;   

    public function __construct(Request $request)
    {
        //$this->middleware('auth');
        $this->request = $request;        

    }

    public function store()
    {
        
       // if($this->request->ajax()) {
            $this->validate($this->request, [
                'name' => 'required',
                "email" => 'required',
                "phone" => 'required',            
            ]); 
            //$busId = $this->request->input('bus_id'); 
            $name = $this->request->input('name');
            $email = $this->request->input('email');
            $phone = $this->request->input('phone');
            // $scheduleId = $this->request->input('booking_id'); 
            $scheduleId = $this->request->input('schedule_id'); 
            $totalSeats = $this->request->input('total_seats'); 
            $totalFare = (float) $this->request->input('total_fare'); 
            $date = $this->request->input('date');
            $selectedSeats = $this->request->input('selected_seats'); //

            $dt = date_format(date_create($date),"Ymd");        
            $bookingId = strtoupper(bin2hex(random_bytes(4)));            

            $date = date("Y-m-d", strtotime($date));            
            //return 'success';
            // GuestUser::create([
            //     'name' => $name,
            //     'email' => $email,
            //     'phone' => $phone,           
            //     'booking_id' => $bookingId,
            //     'schedule_id' => $scheduleId,
            //     'seats' => $totalSeats,
            //     'amount' => $totalFare,
            //     'date' => $date,
            //     'pickup_point' => 'AAA',
            //     'dropping_point' => 'BBB',
            // ]);
            //return 'success';
       // }
       // $seatNo = '';
        $selectedSeats = json_decode(json_encode($selectedSeats), FALSE); // array to object
        $seatNo = '';
        foreach ($selectedSeats as $seat ) {
           $seatNo = $seatNo .' '. $seat->seat_no;
            // Seat::create([
            //     'booking_id' => $bookingId,
            //     'seat_no' => $seat->seat_no,
            //     'status' => $seat->status,
            //     ]);
        }
        //return $seatNo;
        $seats = trim($seatNo);

        return response()->json([
            // 'name' => 'Abigail',
            // 'state' => 'CA'
            'name' => $name,
            'email' => $email,
            'phone' => $phone,           
            'booking_id' => $bookingId,
            //'schedule_id' => $scheduleId,
            'seats' => $totalSeats,
            'seat_no' => $seats,
            'amount' => $totalFare,
            'date' => $date,
            'pickup_point' => 'AAA',
            'dropping_point' => 'BBB',
        ]);

        // for registered user
    	/*if($this->request->ajax()) {
            //$busId = $this->request->input('bus_id'); 
            $scheduleId = $this->request->input('schedule_id'); 
            $date = $this->request->input('date');
        	$totalSeats = $this->request->input('total_seats'); 
        	$totalFare = (float) $this->request->input('total_fare'); 
        	$selectedSeats[] = $this->request->input('selected_seats');


            $dt = date_format(date_create($date),"Ymd");        
            $bookingId = strtoupper(bin2hex(random_bytes(4)));

            $date = date("Y-m-d", strtotime($date));            
            //return 'success';
            $this->request->user()->bookings()->create([            
                'id' => $bookingId,
                'schedule_id' => $scheduleId,
                'seats' => $totalSeats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);
            return 'success';
        }*/
        

        // foreach ($selectedSeats as $seat) {
        //     Seat::create([
        //         'id' => $bookingId,
        //         'seat_no' => $seat->seat_no,
        //         'status' => $seat->status,
        //         ]);
        // }

        
       // return 'FAILURE';

        // return $busId .'/' . $scheduleId . '/' . $date . '/' . $totalSeats . '/' .$totalFare;
    	// return view('pages.home');
    	// dd($selectedSeats);
    	//return $selectedSeats;
    	
    }

    public function test()
    {
        
        // $date=date_create("2013-03-15");
        // $dt= date_format($date,"d"); // using php 
      
        // //$str = $dt . strtoupper(
        //  // $str1 = bin2hex(random_bytes(4)); 
        // $bookingId = strtoupper(bin2hex(random_bytes(4)));
        // var_dump($bookingId);

        $busId = '123' ;
        $scheduleId = '2' ;
        $date = "2017-04-27" ;
        $totalSeats = 2; 
        $totalFare = 4000; 
        //$selectedSeats[] = $this->request->input('selected_seats');
        $dt = date_format(date_create($date),"Ymd");
        
        $bookingId = strtoupper(bin2hex(random_bytes(4)));

        $this->request->user()->bookings()->create([            
            'id' => $bookingId,
            'schedule_id' => $scheduleId,
            'seats' => $totalSeats,
            'amount' => $totalFare,
            'date' => $date,
            'pickup_point' => 'AAA',
            'dropping_point' => 'BBB',
        ]);

        return 'success';

    }
}
