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

//admin
Route::get('/admin/dashboard', 'Admin\DashboardController@index');
Route::get('/staffs', 'Admin\DashboardController@staffInfo');
//bus
Route::get('/bus/ids', 'Admin\BusController@busIds');
Route::post('/bus/seatplan', 'Admin\BusController@storeSeatPlan');
Route::get('/bus/{id}', 'Admin\BusController@showSeat');
//Route::delete('/staffs/{staff}', 'Admin\DashboardController@destroy');
Route::post('/delete', 'Admin\DashboardController@destroy');
Route::post('/update', 'Admin\DashboardController@updateStuffRole');
//Route::get('/staffs/{staff}/edit', 'Admin\DashboardController@destroy');
Route::post('/cities', 'Admin\CityController@store');


Route::get('/home', 'SearchTicketController@index');
Route::get('/search', 'SearchTicketController@searchTicket');
Route::get('/viewseats', 'SearchTicketController@viewSeats');

//Route::get('seatbooking', 'BookingController@store');
Route::post('seatbooking', 'BookingController@store');
Route::post('seatbuying', 'BookingController@store');
Route::get('/cancel/{booking}', 'BookingController@cancelBooking');

//Route::post('seatbuying', 'BuyingController@store');
Route::get('/test', 'BookingController@test');
Route::get('/test1', 'BookingController@test1');

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

