<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\GuestUser;
use App\Events\SeatStatusUpdatedEvent;
use App\Booking;
use App\Seat;
use App\User;


class BookingController extends Controller
{
    protected $request;   
    //protected $name;
    protected $phone;
    protected $email;
	//protected $travelDate;



    public function __construct(Request $request)
    {
        //$this->middleware('auth');
        $this->request = $request;        

    }

    protected function createOrUpdateGuest()
    {
        $this->validate($this->request, [
                    'name' => 'required',
                    'email' => 'required',
                    'phone' => 'required',                    
                ]); 
                //$busId = $this->request->input('bus_id'); 
                $name = $this->request->input('name');
                $this->email = $email = $this->request->input('email');
                $this->phone = $phone= $this->request->input('phone'); 

                // Save/ Upadte Guest User Info             
                $guestUserIsAvailable = User::where('phone', $phone)
                                                ->orWhere('email', $email)
                                                ->first();  // user available or not in guest_user table
                if ( $guestUserIsAvailable ) {
                    //$guestUserIsAvailable->delete();
                    $guestUserIsAvailable->update([
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone, 
                    ]);
                }
                else {
                    $password = bin2hex(random_bytes(4));
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'password' => bcrypt($password),
                    ]);
                    
                    // mail2user $password about account & password
                    /*$user = new User;
                    $user->name = $name;
                    $user->email = $email;
                    $user->phone = $phone;
                    $user->password = bcrypt($password);
                    $user->save();*/

                    //updating roles table with guest role. Later on we can based on this we can delete guest user.
                    $user->roles()->create([
                                    'name' => 'guest',
                        ]);
                }
    }

    public function checkUserRole()
    {
        return auth()->user()->isNormalUser() ? '':  $this->createOrUpdateGuest();    
    }
    public function getInputsInfo()
    {
        # code...$scheduleId = $this->request->input('schedule_id');
          $travelDate = $this->request->input('date');

          // //user
          // if ( auth()->check() ) {
          //    if (!auth()->user()->isNormalUser()) {
          //       $this->createOrUpdateGuest();    
          //    }
          // } else {
          //   $this->createOrUpdateGuest();
          // }
        auth()->check() ? $this->checkUserRole() : $this->createOrUpdateGuest();

           return $infos = [ 
                    "scheduleId" => $this->request->input('schedule_id'), 
                    "totalSeats" => $this->request->input('total_seats'),
                    "totalFare" => (float) $this->request->input('total_fare'), 
                    "travelDate" => $this->request->input('date'),
                    "selectedSeats" => $this->request->input('selected_seats'),             
                    "bookingId" => strtoupper(bin2hex(random_bytes(4))),
                    "date" => date("Y-m-d", strtotime($travelDate))
              ]; 


    }

    public function createBooking($inputsInfo)
    {
        extract($inputsInfo);

        if (auth()->check()) {
            /*$user = auth()->user(); // authenticated user's object
            $userId = $user->id;*/
            if ( auth()->user()->isNormalUser() ) {
                $userId = auth()->id();    // Auth::id() , Auth::user()            
            }
            //role: admin/staff
            //m-1
            /*if ( $user->roles()->role == 'normal') {  
                $userId = $user->id;
            }*/
            //m-2 collect info from roles tble for this user. if no info found means he is normal user.  
            /*if (!$user->roles->count()) {  
                $userId = $user->id;
            }*/


        } else {

            //$user = GuestUser::where('phone', $this->phone)->first();
            $user = User::where('phone', $this->phone)->first();
            $userId = $user->id;
        }

        //$this->request->user()->bookings()->create([ 
            Booking::create([                       
                'id' => $bookingId,
                'user_id' => $userId,
                'schedule_id' => $scheduleId,
                'total_seats' => $totalSeats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);
    }

    public function createSeat($inputsInfo)
    {
        extract($inputsInfo);
        $selectedSeats = json_decode(json_encode($selectedSeats), FALSE); // array to object
            $seatNo = '';
            foreach ($selectedSeats as $seat ) {
               $seatNo = $seatNo .' '. $seat->seat_no;
                Seat::create([
                    'booking_id' => $bookingId,
                    'seat_no' => $seat->seat_no,
                    'status' => $seat->status,
                    ]);
                broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            }
            //return $seatNo;
            $seats = trim($seatNo);

            return response()->json([
                'booking_id' => $bookingId,
                //'schedule_id' => $scheduleId,
                'total_seats' => $totalSeats,
                'seat_no' => $seats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);
    }

    public function store()
    {
        // user/ stuff/ guest
        // For Registered USER
        //(Auth::check()
        //if ( auth()->check() ) {
            /*
            $scheduleId = $this->request->input('schedule_id'); 
            $totalSeats = $this->request->input('total_seats'); 
            $totalFare = (float) $this->request->input('total_fare'); 
            $date = $travelDate = $this->request->input('date');
            $selectedSeats = $this->request->input('selected_seats'); //
            $dt = date_format(date_create($date),"Ymd");        
            $bookingId = strtoupper(bin2hex(random_bytes(4)));            
            
            $date = date("Y-m-d", strtotime($date));  */  
            //extract($this.getInputsInfo());

            $inputsInfo = $this->getInputsInfo();
            $this->createBooking($inputsInfo);
            return $this->createSeat($inputsInfo);

            /*$this->request->user()->bookings()->create([            
                'id' => $bookingId,
                'schedule_id' => $scheduleId,
                'seats' => $totalSeats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);*/

            /*
            $selectedSeats = json_decode(json_encode($selectedSeats), FALSE); // array to object
            $seatNo = '';
            foreach ($selectedSeats as $seat ) {
               $seatNo = $seatNo .' '. $seat->seat_no;
                Seat::create([
                    'booking_id' => $bookingId,
                    'seat_no' => $seat->seat_no,
                    'status' => $seat->status,
                    ]);
                broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            }
            //return $seatNo;
            $seats = trim($seatNo);

            return response()->json([
                'booking_id' => $bookingId,
                //'schedule_id' => $scheduleId,
                'seats' => $totalSeats,
                'seat_no' => $seats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);*/

       // } auth chk end if
        
        //**** For GUEST user      

        //     $this->validate($this->request, [
        //         'name' => 'required',
        //         "email" => 'required',
        //         "phone" => 'required',            
        //     ]); 
        //     //$busId = $this->request->input('bus_id'); 
        //     $name = $this->request->input('name');
        //     $email = $this->request->input('email');
        //     $phone = $this->request->input('phone');
        //     // $scheduleId = $this->request->input('booking_id'); 
        //     $scheduleId = $this->request->input('schedule_id'); 
        //     $totalSeats = $this->request->input('total_seats'); 
        //     $totalFare = (float) $this->request->input('total_fare'); 
        //     $date = $travelDate = $this->request->input('date');
        //     $selectedSeats = $this->request->input('selected_seats'); //

        //     $dt = date_format(date_create($date),"Ymd");        
        //     $bookingId = strtoupper(bin2hex(random_bytes(4)));            

        //     $date = date("Y-m-d", strtotime($date));            
        //     //return 'success';

        //     // Storing Guest User Info             
        //     $guestUserIsAvailable = GuestUser::where('phone', $phone)->first();  // user available or not in guest_user table
        //     if ( $guestUserIsAvailable ) {
        //         $guestUserIsAvailable->delete();
        //         GuestUser::create([
        //             'name' => $name,
        //             'email' => $email,
        //             'phone' => $phone, 
        //         ]);
        //     }
        //     else {
        //         GuestUser::create([
        //             'name' => $name,
        //             'email' => $email,
        //             'phone' => $phone,
        //         ]);
        //     }

            

        // //****storing booking info corrosponding guest user ***
        //     //GuestUser::bookings()->create([            
        //     Booking::create([            
        //         'id' => $bookingId,
        //         'schedule_id' => $scheduleId,
        //         'user_id' => $phone, // guest phn as user id
        //         'seats' => $totalSeats,
        //         'amount' => $totalFare,
        //         'date' => $date,
        //         'pickup_point' => 'AAA',
        //         'dropping_point' => 'BBB',
        //     ]);

           
        //     /** User + Guest User **/

        //     $selectedSeats = json_decode(json_encode($selectedSeats), FALSE); // array to object
        //     $seatNo = '';
        //     foreach ($selectedSeats as $seat ) {
        //        $seatNo = $seatNo .' '. $seat->seat_no;
        //        Seat::create([
        //             'booking_id' => $bookingId,
        //             'seat_no' => $seat->seat_no,
        //             'status' => $seat->status,
        //             ]);
        //         // fire broadcast event 
        //         broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
        //     }
        //     //return $seatNo;
        //     $seats = trim($seatNo);

        //     return response()->json([
        //         'name' => $name,
        //         'email' => $email,
        //         'phone' => $phone,           
        //         'booking_id' => $bookingId,
        //         //'schedule_id' => $scheduleId,
        //         'seats' => $totalSeats,
        //         'seat_no' => $seats,
        //         'amount' => $totalFare,
        //         'date' => $date,
        //         'pickup_point' => 'AAA',
        //         'dropping_point' => 'BBB',
        //     ]);
    	
    }

    /** Prev code
    public function store()
    {
        
        // For Registered USER
        //(Auth::check()
        if ( auth()->check() ) {
            $scheduleId = $this->request->input('schedule_id'); 
            $totalSeats = $this->request->input('total_seats'); 
            $totalFare = (float) $this->request->input('total_fare'); 
            $date = $travelDate = $this->request->input('date');
            $selectedSeats = $this->request->input('selected_seats'); //
            $dt = date_format(date_create($date),"Ymd");        
            $bookingId = strtoupper(bin2hex(random_bytes(4)));            
            
            $date = date("Y-m-d", strtotime($date));    

            $this->request->user()->bookings()->create([            
                'id' => $bookingId,
                'schedule_id' => $scheduleId,
                'seats' => $totalSeats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);

            $selectedSeats = json_decode(json_encode($selectedSeats), FALSE); // array to object
            $seatNo = '';
            foreach ($selectedSeats as $seat ) {
               $seatNo = $seatNo .' '. $seat->seat_no;
                Seat::create([
                    'booking_id' => $bookingId,
                    'seat_no' => $seat->seat_no,
                    'status' => $seat->status,
                    ]);
                broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            }
            //return $seatNo;
            $seats = trim($seatNo);

            return response()->json([
                'booking_id' => $bookingId,
                //'schedule_id' => $scheduleId,
                'seats' => $totalSeats,
                'seat_no' => $seats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);

        }
        
        // For GUEST user      

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
            $date = $travelDate = $this->request->input('date');
            $selectedSeats = $this->request->input('selected_seats'); //

            $dt = date_format(date_create($date),"Ymd");        
            $bookingId = strtoupper(bin2hex(random_bytes(4)));            

            $date = date("Y-m-d", strtotime($date));            
            //return 'success';

            // Storing Guest User Info             
            $guestUserIsAvailable = GuestUser::where('phone', $phone)->first();  // user available or not in guest_user table
            if ( $guestUserIsAvailable ) {
                $guestUserIsAvailable->delete();
                GuestUser::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone, 
                ]);
            }
            else {
                GuestUser::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                ]);
            }

            

        //storing booking info corrosponding guest user ***
            //GuestUser::bookings()->create([            
            Booking::create([            
                'id' => $bookingId,
                'schedule_id' => $scheduleId,
                'user_id' => $phone, // guest phn as user id
                'seats' => $totalSeats,
                'amount' => $totalFare,
                'date' => $date,
                'pickup_point' => 'AAA',
                'dropping_point' => 'BBB',
            ]);

           
            // User + Guest User *

            $selectedSeats = json_decode(json_encode($selectedSeats), FALSE); // array to object
            $seatNo = '';
            foreach ($selectedSeats as $seat ) {
               $seatNo = $seatNo .' '. $seat->seat_no;
               Seat::create([
                    'booking_id' => $bookingId,
                    'seat_no' => $seat->seat_no,
                    'status' => $seat->status,
                    ]);
                // fire broadcast event 
                broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            }
            //return $seatNo;
            $seats = trim($seatNo);

            return response()->json([
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
        
    }  
    ***/
    public function test1(Request $request)
    {
       //dd($request->user());
        //$roles = auth()->user()->roles()->get();
        
        //$role = $request->user()->roles->contains('role', 'admin');
      //  $role = auth()->user()->roles->contains('name', 'user');
        
        //dd($roles->contains('role','admin'));
        dd(auth()->user()->isNormalUser());
        
    }
    public function test()
    {        
        $user = $this->request->user();
        dd($user->isAdministrator());
        
    }
    public function getVsfirst()
    {
        //collection explained
        
        //get() ---> collection (multiple objects)
        $bookings = Booking::where('id', 'C9A310BD')->with('seats')->get(); 
        foreach ($bookings as $booking) {
            echo $booking->seats;
            foreach ($booking->seats as $seat) {
                echo $seat->seat_no;
            }
        return;
        }
        // first() -----> Single Object
        $booking = Booking::where('id', 'C9A310BD')->with('seats')->first(); //Single Object
        echo $booking->seats;        
        foreach ($booking->seats as $seat) {
            echo $seat->seat_no;
        }
        return;
    }    
}
