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
    //protected $schedules;
    protected $routeId;
    protected $request;
    //protected $seatsByBooking = [];

    public function __construct(Request $request)
    {
        //$this->middleware('auth');
        $this->request = $request;        

    }

    public function index()
    {
    	//dd('test');
    	$cities = City::all();
    	//dd($cities);
    	return view('pages.home', compact('cities'));
    }


    public function search()
    {
       return $test = $this->request->input('firstName');
    }

  //   public function searchTest(Request $request)
  //   {
  //   	$from  = $request->input('from');
		// $to = $request->input('to');
		// $date = $request->input('date');

  //   	return $from . $to ;
  //   }
    public function test1()
    {
 
		// $from  = 'dhaka';
		// $to = 'sylhet';
		// $date = '2017-11-30';
		$from  = 'dhaka';
		$to = 'sylhet';
		$date = '07/12/2010';
        $date = date("Y-m-d", strtotime($date));
  
		
		return $date;

		$route = Rout::where('departure_city', $from)->
						where( 'arrival_city', $to)->first();
		
		$this->routeId = $routeId = $route->id;
	
		// return $schedules = Schedule::where('rout_id', $routeId)->
		// 							with(['bookings' => function($query) use ($date) {
		// 								$query->where('date', $date);
		// 							}])->get();	
		// $schedules = Schedule::where('rout_id', $routeId)->with('bookings')->get();
		// return $schedules;
		

		$schedules = Schedule::where('rout_id', $routeId)->
									with(['bookings' => function($query) use ($date) {
										$query->where('date', $date);
									}])->get();	

		// $schedules = Schedule::with(['bookings' => function($query) use ($date) {
		// 								$query->where('date' , $date);
		// 							}])->get();	

		
		foreach ($schedules as $schedule) {
			//print_r(count($schedule->bookings));
			print_r($schedule->bookings->count());
		}
									
		return $schedules;	

		
    }


    public function searchSchedules()
    {
        $from  = $this->request->input('from');        
		$to = $this->request->input('to');
		$date = $this->request->input('date');

		$date = date("Y-m-d", strtotime($date)); //wk if input date is dd-mm-yyyy format in vue script
		
		$route = Rout::where('departure_city', $from)->
						where( 'arrival_city', $to)->first();
		
		$this->routeId = $routeId = $route->id;
	
		return $schedules = Schedule::where('rout_id', $routeId)->
									with(['bookings' => function($query) use ($date) {
										$query->where('date', $date);
									}])->get();		
    }

    public function searchTicket() {
    // public function test() {   
		
		$error = ['error' => 'No results found'];

		// $route = Rout::where('departure_city', $from)->
		// 				where( 'arrival_city', $to)->first();
		

		// $routeId= $route->id;
	
		// $schedules = Schedule::where('rout_id', $routeId)->
		// 							with(['bookings' => function($query) use ($date) {
		// 								$query->where('date', $date);
		// 							}])->get();		
		//$buses = [];		
		/*** to display seat plan ****
		$scheduleId = 1;
		$busId = 123;
		*/
		//dd($schedules->count());
		//return $schedules = $this->searchSchedules();
		$schedules = $this->searchSchedules();	
		//return $schedules;
		$routeId = $this->routeId;
		
		if ( $schedules->count() ) {
			//return $schedules->count() ; 
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

				//return $schedule->bookings->count();

				if ( $schedule->bookings->count() ) {
					$totalSeatsBooked = 0;
					$availableSeats = 0;
					
					foreach ($schedule->bookings as $booking) {
			     		$totalSeatsBooked = $totalSeatsBooked + $booking->seats; 
		     		}	
		     		$availableSeats = $bus->total_seats - $totalSeatsBooked;
		     		//print_r($availableSeats);
				}
				else {
					$availableSeats = $bus->total_seats;
					//print_r($availableSeats = $bus->total_seats);
				}	
			
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
			return $buses; 
		}
		return $error;		

    }

    public function viewSeats()
    {
    	$scheduleId = $this->request->input('schedule_id'); 
    	$busId = $this->request->input('bus_id'); 

    	$error = ['error' => 'No results found'];

    	$schedules = $this->searchSchedules();

    	//return $schedules;
    	
    	if ( $schedules->count() ) {
			foreach ($schedules as $schedule) {
				
				/* seat plan */
				if ($schedule->id == $scheduleId) {
					//return $schedule;					
					$seatsByBooking = $this->seatsByBooking($schedule, $scheduleId);
				 }
				//$busId = $schedule->bus_id;
				if ($schedule->bus_id == $busId) {
					$seatPlanByBusId = $this->seatPlanByBusId($schedule, $busId);
				}
				
			}
			
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
			if ( count($seatsByBooking) >0 ) {
				$result = array_merge($seatsByBooking, $seatPlanByBusId); //11	
				$viewseats = $this->unique_multidim_array($result,'seat_no'); // can be any key
				sort($viewseats);

				return $viewseats;
				//return $seatPlanByBusId;			
			}
			return $seatPlanByBusId; 
			
			
		}
		return $error;	
                
    }
    
    public function seatsByBooking($schedule, $scheduleId) {
    		if ( $schedule->bookings->count() ) {
    			foreach ($schedule->bookings as $booking) {
					$seats = Seat::where('booking_id', $booking->id)->get(); //collection
					foreach ($seats as $seat) {
						$arr_seats[] = [								
							'seat_no' => $seat->seat_no,
							'status'  => $seat->status,
							'checked' => false	 
						];
					}
				}
				return $arr_seats;

    		}
    		return $arr_seats = [];
			 
    }

    public function seatPlanByBusId($schedule, $busId) {
    		
			$seats = SeatPlan::where('bus_id', $busId)->get(); //collection
			//dd($seats);
			//return $seats;

			foreach ($seats as $seat) {
				$arr_seats[] = [								
					'seat_no' => $seat->seat_no,
					'status'  => $seat->status,
					'checked' => false 	 
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
