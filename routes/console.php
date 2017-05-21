<?php

use Illuminate\Foundation\Inspiring;
use Carbon\Carbon;

use App\Events\SeatStatusUpdatedEvent;
use App\User;
use App\Booking;
use App\Seat;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

//
Artisan::command('cancel:buying', function () 
{
    $now = Carbon::now(3); // UTC+0.3:00 
    $this->comment("Now: {$now} ");
    //$seats = Seat::where('status','buying')->with('bookings')->get();  // eager
    $seats = Seat::where('status','buying')->get();
    //if ($seats)
    if ($seats->count() > 0)
    {
      $count = 0;
      foreach ($seats as $seat) 
      {
        // $this->comment("mmmmNowmm: {$now} ");
        $count++; 
        $before = $seat->updated_at;
        //$this->info("Before: {$before} ");
        // $diff = $now->diffInMinutes($before);
        //$diff = $now->diffInSeconds($before);
        $diff = $now->diffInSeconds($before);
        //$this->info("Difference {$diff} ");
        if($diff > 559) 
        {
          $booking = Booking::find($seat->booking_id); // relatedBooking

          if($booking) 
          {
            $bookingId = $booking->id;
            $scheduleId = $booking->schedule_id;       
            $travelDate = date("d-m-Y", strtotime($booking->date)) ;            
            // for multiple seats with same booking id
            if ($booking->total_seats == $count) {  
              $booking->delete();
            }
            //response()->json([]); // could be used
            $updateSeatInfo = [
                          'seat_no' => $seat->seat_no,
                          'status' => 'available',
                      ];
            $seat->delete();
            $updateSeatInfo = json_decode(json_encode($updateSeatInfo), FALSE); //object

            broadcast(new SeatStatusUpdatedEvent($updateSeatInfo, $scheduleId, $travelDate))->toOthers();
          }
          $this->info(" {$count}. Done ");
        }
        // $this->error("Woops! Nothing to cancel");
        //return;
      }
      return;
    }
    //return;
    $this->error("Woops! Not Found");
})->describe('Cancel All Buying');


//
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');



// php artisan user 1
Artisan::command('user {userId}', function () {
   $userId = $this->argument('userId');	
   $user = User::find($userId);
   if ($user) {
	   $this->comment("Here are the infos of User");
	   $this->info("Name: {$user->name} ");
	   $this->info("Email: {$user->email}");
	   $this->info("phone: {$user->phone}");
	   return;   	
   }
   $this->error("Woops! User doesn't exist");
})->describe('Display User Info');
