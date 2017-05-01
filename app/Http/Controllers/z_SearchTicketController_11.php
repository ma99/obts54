<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Bus;
use App\City;
use App\Fare;
use App\Rout;
use App\Schedule;
use App\Seat;
use App\SeatPlan;


use Illuminate\Http\Request;

class SearchTicketController extends Controller
{
    protected $schedules;
    //protected $seatsByBooking = [];

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
    	//dd('test');
    	$cities = City::all();
    	//dd($cities);
    	return view('pages.home', compact('cities'));
    }


    public function search(Request $request)
    {
       return $test = $request->input('firstName');
    }

    public function searchTest(Request $request)
    {
    	$from  = $request->input('from');
		$to = $request->input('to');
		$date = $request->input('date');
		
    	return $from . $to ;
    }

    public function searchTicket(Request $request) {
    	$from  = $request->input('from');
		$to = $request->input('to');
		$date = $request->input('date');

		// $from  = 'dhaka';
		// $to = 'sylhet';
		// $date = '2017-04-12';
		
		$error = ['error' => 'No results found'];

		$route = Rout::where('departure_city', $from)->
						where( 'arrival_city', $to)->first();
		

		$routeId= $route->id;
	
		$schedules = Schedule::where('rout_id', $routeId)->
									with(['bookings' => function($query) use ($date) {
										$query->where('date', $date);
									}])->get();		
		//$buses = [];		
		/*** to display seat plan ****
		$scheduleId = 1;
		$busId = 123;
		*/
		//dd($schedules->count());
		if ( $schedules->count() ) {
			foreach ($schedules as $schedule) {
				
				/** display plan
				if ($schedule->id == $scheduleId) {
					$seatsByBooking = $this->seatsByBooking($schedule, $scheduleId);
				}
				//$busId = $schedule->bus_id;
				if ($schedule->bus_id == $busId) {
					$seatPlanByBusId = $this->seatPlanByBusId($schedule, $busId);
				}
				*/
				
				//return $seatsByBooking;
				$bus = Bus::where('id', $schedule->bus_id)->first();			
				$totalSeatsBooked = 0;
				$availableSeats = 0;

			    foreach ($schedule->bookings as $booking) {
		     		$totalSeatsBooked = $totalSeatsBooked + $booking->seats;   		     				     		
		     	}	
		        //echo 'SeatsBooked = ' . $totalSeatsBooked;
		        $availableSeats = $bus->total_seats - $totalSeatsBooked;
		        $bus_type = $bus->type;
		        //fare
		        if ($bus_type  == 'ac-deluxe') { 

				    $fare_ac = Fare::where('rout_id', $routeId)->
								 	 where('type', 'ac')->value('amount');
				     
				     $fare_delux = Fare::where('rout_id', $routeId)->
										 where('type', 'deluxe')->value('amount');

					$fare = $fare_ac .'/'. $fare_delux ;
				}
				else 
					$fare = Fare::where('rout_id', $routeId)->
							  	  where('type', $bus_type)->value('amount');

				//echo '5. fare = '. $fare;
				$buses[] = [
					'departure_time' => $schedule->departure_time,
					'arrival_time' => $schedule->arrival_time,
					'bus_type' => $bus->type,
					'available_seats' => $availableSeats,
					'fare' => $fare,
					'schedule_id' => $schedule->id,
					'bus_id' => $schedule->bus_id,
				];
			}
			// //dd($buses);

			$buses = $object = json_decode(json_encode($buses), FALSE);		
			// foreach ($buses as $bus) {
			//  	//echo $bus['fare'];
			//  	echo $bus->fare;
			//  	echo "\n";
			// }
			//return $seatsByBooking;
			//$result = array_merge($seatPlanByBusId, $seatsByBooking);
			
			/*********************************************
			print_r($seatPlanByBusId);
			echo "<Br>";
			print_r('__________________');
			echo "<Br>";
			print_r($seatsByBooking);
			$result = array_merge($seatsByBooking, $seatPlanByBusId); //11	
			$details = $this->unique_multidim_array($result,'seat_no'); // can be any key
			sort($details);
			dd($details);
			**************************************/

			//return $seatPlanByBusId;			
			return $buses; 
		}
		return $error;		

    }

    public function seatsByBooking($schedule, $scheduleId) {

			foreach ($schedule->bookings as $booking) {
				$seats = Seat::where('booking_id', $booking->id)->get(); //collection
				foreach ($seats as $seat) {
					$arr_seats[] = [								
						'seat_no' => $seat->seat_no,
						'status'  => $seat->status 	 
					];
				}
			}
			return $arr_seats; 
    }

    public function seatPlanByBusId($schedule, $busId) {
    		
			$seats = SeatPlan::where('bus_id', $busId)->get(); //collection
			//dd($seats);
			foreach ($seats as $seat) {
				$arr_seats[] = [								
					'seat_no' => $seat->seat_no,
					'status'  => $seat->status 	 
				];

			}						
			return $arr_seats; 
			
    }

    public function unique_multidim_array($array, $key) {
	    $temp_array = [] ;// = array();
	    $i = 0;
	    $key_array = []; // array();
	   
	    foreach($array as $val) {
	        if (!in_array($val[$key], $key_array)) {
	            $key_array[$i] = $val[$key];
	            $temp_array[$i] = $val;
	        }
	        $i++;
	    }
	    return $temp_array;
	} 
}
