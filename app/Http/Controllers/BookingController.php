<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Seat;

class BookingController extends Controller
{
    

	protected $request;   

    public function __construct(Request $request)
    {
        //$this->middleware('auth');
        $this->request = $request;        

    }

    public function store(Request $request)
    {
    	$busId = $this->request->input('bus_id'); 
        $scheduleId = $this->request->input('schedule_id'); 
        $date = $this->request->input('date');
    	$totalSeats = $this->request->input('total_seats'); 
    	$totalFare = $this->request->input('total_fare'); 
    	$selectedSeats[] = $this->request->input('selected_seats');
        $dt = date_format(date_create($date),"Ymd");
        
        $bookingId = strtoupper(bin2hex(random_bytes(4)));

        $request->user()->bookings()->create([            
            'id' => $bookingId,
            'schedule_id' => $scheduleId,
            'seats' => $totalSeats,
            'amount' => $totalFare,
            'date' => $date,
            'pickup_point' => 'AAA',
            'dropping_point' => 'BBB',
        ]);

        // foreach ($selectedSeats as $seat) {
        //     Seat::create([
        //         'id' => $bookingId,
        //         'seat_no' => $seat->seat_no,
        //         'status' => $seat->status,
        //         ]);
        // }




    	// return view('pages.home');
    	// dd($selectedSeats);
    	return $selectedSeats;
    	
    }

    public function test()
    {
        
        $date=date_create("2013-03-15");
        $dt= date_format($date,"d"); // using php 
        // $dt = Carbon::now();
        // $dt = "2013-03-15" ;
       //s echo $today = Carbon::today();
        //echo $dt->toDateString(); 
        //echo $date->format('Ymd');  // using carbon     
        //dd($dt);        
        //echo rand(10000, 90000);
        
        //$str = $dt . strtoupper(
          $str1 = bin2hex(random_bytes(4)); 
        var_dump($str1);


    }
}
