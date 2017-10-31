<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/session', 'HomeController@showSession');
// Route::get('/admin', 'HomeController@admin');

/*Route::get('/{vue?}', function () {
    return view('pages.admin');
})->where('vue', '[\/\w\.-]*');*/

Route::get('admin/{vue?}', function () {
    return view('admin.admin');
})->where('vue', '[\/\w\.-]*')->middleware('auth', 'admin');

// Route::get('admin/{subs?}', ['middleware' => 'auth', function () {
//     return view('pages.admin');
// }])->where(['subs' => '.*']);

Route::get('/forbidden', 'HomeController@forbidden');

//admin staff
Route::get('/admin/dashboard', 'Admin\DashboardController@index');
Route::get('/staffs', 'Admin\DashboardController@staffInfo');
Route::post('/delete', 'Admin\DashboardController@destroy');
Route::post('/update', 'Admin\DashboardController@updateStuffRole');

//bus
Route::get('/bus/ids', 'Admin\BusController@busIds');
Route::get('/bus/{id}', 'Admin\BusController@showSeat');
Route::post('/bus', 'Admin\BusController@storeBus');
Route::post('/bus/seatplan', 'Admin\BusController@storeSeatPlan');
Route::post('/delete/bus', 'Admin\BusController@destroy');

//route
Route::post('/route', 'Admin\RouteController@store');
Route::post('/delete/route', 'Admin\RouteController@destroy');
Route::post('/update/fare', 'Admin\RouteController@updateFare');

//city
Route::post('/cities', 'Admin\CityController@store');
Route::post('/delete/city', 'Admin\CityController@destroy');

//schedule
Route::post('/schedule', 'Admin\ScheduleController@store');
Route::post('/edit/schedule', 'Admin\ScheduleController@editSchedule');
Route::post('/delete/schedule', 'Admin\ScheduleController@destroy');


//stop
Route::post('/stops', 'Admin\StopController@store');
Route::post('/delete/stop', 'Admin\StopController@destroy');

Route::get('/home', 'SearchTicketController@index');
Route::get('/search', 'SearchTicketController@searchTicket');
Route::get('/viewseats', 'SearchTicketController@viewSeats');

Route::get('/fare/{route}', 'SearchTicketController@test1');

//Route::get('seatbooking', 'BookingController@store');
Route::post('seatbooking', 'BookingController@store');
Route::post('seatbuying', 'BookingController@store');
Route::get('/cancel/{booking}', 'BookingController@cancelBooking');

//Route::post('seatbuying', 'BuyingController@store');
Route::get('/test', 'BookingController@test');
Route::get('/test1', 'BookingController@test1');

//payment
//Route::get('/pay/{booking}', 'Payment\PaymentController@payNow')->name('payment');
Route::get('/pay/{booking}', 'Payment\PaymentController@payNow')->name('payment');
// Route::post('/sslcommerz/payment/success', 'Payment\PaymentController@success')->name('success');
// Route::post('/sslcommerz/payment/fail', 'Payment\PaymentController@fail')->name('fail');
// Route::post('/sslcommerz/payment/cancel', 'Payment\PaymentController@cancel')->name('cancel');
Route::post('/sslcommerz/payment/success', 'Payment\PaymentSuccessController@payment')->name('success');
Route::post('/sslcommerz/payment/fail', 'Payment\PaymentFailedController@payment')->name('fail');
Route::post('/sslcommerz/payment/cancel', 'Payment\PaymentCancelledController@payment')->name('cancel');


Route::get('/test2', function(){
	return view('payment.cancelled');
});
/* Explicit route model binding see RouteServiceProvider.php

Route::get('users/{user}', function(\App\User $user) {
    return $user;
});

*/

//Route::post('/home', 'SearchTicketController@search');
//Route::get('/test', 'SearchTicketController@test1');

