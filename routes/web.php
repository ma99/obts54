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

//Route::get('/home', 'HomeController@index');

Route::get('/home', 'SearchTicketController@index');

Route::get('/search', 'SearchTicketController@searchTicket');

Route::get('/viewseats', 'SearchTicketController@viewSeats');

Route::post('seatbooking', 'BookingController@store');
Route::post('seatbuying', 'BuyingController@store');
Route::get('/test', 'BookingController@test');

Route::get('/pay/{booking}', 'PaymentController@payNow')->name('payment');

/* Explicit route model binding see RouteServiceProvider.php

Route::get('users/{user}', function(\App\User $user) {
    return $user;
});

*/





//Route::post('/home', 'SearchTicketController@search');
//Route::get('/test', 'SearchTicketController@test1');

