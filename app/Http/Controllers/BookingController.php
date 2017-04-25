<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    

	protected $request;   

    public function __construct(Request $request)
    {
        //$this->middleware('auth');
        $this->request = $request;        

    }

    public function bookSeats()
    {
    	$scheduleId = $this->request->input('schedule_id'); 
    	$busId = $this->request->input('bus_id'); 
    	$totalSeats = $this->request->input('total_seats'); 
    	$totalFare = $this->request->input('total_fare'); 
    	$selectedSeats[] = $this->request->input('selected_seats'); 
    	// return view('pages.home');
    	// dd($selectedSeats);
    	return $selectedSeats;
    	
    }
}
