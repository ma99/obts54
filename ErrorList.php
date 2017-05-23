
1. (15/05/2017)

Action: Cliciking on View Button
http://obts.dev/viewseats?from=Dhaka&to=Sylhet&date=15-05-2017&schedule_id=2&bus_id=234&bus_fare=400

Error:
ErrorException in SearchTicketController.php line 298:
Undefined variable: arr_seats

Reason: Data Saved in 'bookings' Table BUT correspoding data not saved in 'seats' table. 
So clicking on view find entry in 'bookings' but no for this booking in 'seats' table.

Solution: should have some checking if data not saved in seats, that booking should be deleted from bookings table.  

**************************


2. 23/05/2017
Error:
ErrorException in VerifyCsrfToken.php line 156: Trying to get property of non-object laravel middleware

Reason: Instead of returning route path was returning string in middleware class handle().
			//return 'You are not allowed'; ---> not correct
            //return view('errors.503'); ---> not correct
            return redirect('/forbidden'); ==> Correct
web.php 
Route::get('/forbidden', 'HomeController@forbidden');
HomeController.php
public function forbidden()
    {
        $user = auth()->user();
        return view('common.forbidden', compact('user') );
    }            

****************************