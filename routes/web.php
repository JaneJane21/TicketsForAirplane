<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AirplaneController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SeatInPlaneController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class,'welcome'])->name('welcome');

Route::get('guest/auth',[PageController::class,'login'])->name('login');
Route::get('guest/registration',[PageController::class,'reg'])->name('reg');

Route::get('user/profile',[PageController::class,'profile'])->name('profile');
Route::get('user/ticket',[PageController::class,'my_ticket'])->name('my_ticket');
Route::get('user/profile/block',[UserController::class,'block_data'])->name('block_data');


Route::post('guest/auth/send',[UserController::class,'auth'])->name('auth');
Route::post('guest/registration/save',[UserController::class,'store'])->name('save_user');

Route::get('user/logout',[UserController::class,'logout'])->name('logout');

Route::get('user/flight/index',[FlightController::class,'index_valid'])->name('get_valid_flights');
Route::get('user/city/index',[CityController::class,'index'])->name('welcome_get_cities');
Route::get('user/flight/popular',[TicketController::class,'welcome_get_popular'])->name('welcome_get_popular');

Route::get('user/ticket/index',[TicketController::class,'my_index'])->name('get_user_ticket');
Route::get('user/ticket/airport',[AirportController::class,'index'])->name('get_user_airport');
Route::post('user/ticket/sort',[TicketController::class,'sort_tickets'])->name('sort_tickets');
Route::post('user/ticket/filter',[TicketController::class,'filter_tickets'])->name('filter_tickets');


Route::get('user/ticket/cancel/{id?}',[TicketController::class,'cancel'])->name('cancel_ticket');


Route::post('user/catalog',[PageController::class,'catalog'])->name('catalog');
Route::get('user/catalog/show',[PageController::class,'show_catalog'])->name('show_catalog');
Route::post('user/catalog/flight/filter',[FlightController::class,'filter_flights'])->name('filter_flights');


Route::post('user/catalog/index',[FlightController::class,'index_valid'])->name('get_catalog_flights');

Route::get('user/catalog/city',[CityController::class,'index'])->name('get_catalog_city');
Route::get('user/catalog/airplane',[AirplaneController::class,'index'])->name('get_catalog_airplane');
Route::get('user/catalog/airport',[AirportController::class,'index'])->name('get_catalog_airport');

Route::get('user/catalog/buy/{id?}',[PageController::class,'detail'])->name('detail');

Route::post('user/detail/flight',[FlightController::class,'get_flight'])->name('get_flight');
Route::post('user/detail/airplane',[AirplaneController::class,'get_airplane'])->name('get_airplane');
Route::post('user/detail/ticket',[TicketController::class,'store'])->name('buy_ticket');


Route::get('guest/contacts',[PageController::class,'contact'])->name('contact');


Route::group(['middleware'=>['admin','auth'],'prefix'=>'admin'],function(){
    Route::get('control/city',[AdminPageController::class,'control_city'])->name('control_city');
    Route::get('control/airplane',[AdminPageController::class,'control_airplane'])->name('control_airplane');
    Route::get('control/airport',[AdminPageController::class,'control_airport'])->name('control_airport');
    Route::get('control/seat',[AdminPageController::class,'control_seat'])->name('control_seat');
    Route::get('control/seat_in_plane',[AdminPageController::class,'control_seat_in_plane'])->name('control_seat_in_plane');
    Route::get('control/flight',[AdminPageController::class,'control_flight'])->name('control_flight');
    Route::get('control/ticket',[AdminPageController::class,'control_ticket'])->name('control_ticket');
    Route::get('control/user',[AdminPageController::class,'control_user'])->name('control_user');


    Route::post('control/city/save',[CityController::class,'store'])->name('city_store');
    Route::post('control/airport/save',[AirportController::class,'store'])->name('airport_store');
    Route::post('control/airplane/save',[AirplaneController::class,'store'])->name('airplane_store');
    Route::post('control/seat/save',[SeatController::class,'store'])->name('seat_store');
    Route::post('control/seat_in_plane/save',[SeatInPlaneController::class,'store'])->name('seat_in_plane_store');
    Route::post('control/flight/save',[FlightController::class,'store'])->name('flight_store');
    Route::post('control/user/save',[UserController::class,'store'])->name('user_store');


    Route::get('control/city/index',[CityController::class,'index'])->name('get_cities');
    Route::get('control/airplane/index',[AirplaneController::class,'index'])->name('get_airplanes');
    Route::get('control/airport/index',[AirportController::class,'index'])->name('get_airports');
    Route::get('control/seat/index',[SeatController::class,'index'])->name('get_seats');
    Route::get('control/seat_on_plane/index',[SeatInPlaneController::class,'index'])->name('get_seats_in_plane');
    Route::get('control/flight/index',[FlightController::class,'index'])->name('get_flights');
    Route::get('control/ticket/index',[TicketController::class,'index'])->name('get_tickets');
    Route::get('control/user/index',[UserController::class,'index'])->name('get_users');


    Route::get('control/city/destroy/{id?}',[CityController::class,'destroy'])->name('city_destroy');
    Route::get('control/airplane/destroy/{id?}',[AirplaneController::class,'destroy'])->name('airplane_destroy');
    Route::get('control/airport/destroy/{id?}',[AirportController::class,'destroy'])->name('airport_destroy');
    Route::get('control/seat/destroy/{id?}',[SeatController::class,'destroy'])->name('seat_destroy');
    Route::get('control/seat_in_plane/destroy/{id?}',[SeatInPlaneController::class,'destroy'])->name('seat_in_plane_destroy');
    Route::get('control/flight/destroy/{id?}',[FlightController::class,'destroy'])->name('flight_destroy');
    Route::get('control/user/destroy/{id?}',[UserController::class,'destroy'])->name('user_destroy');


    Route::post('control/city/edit/{city?}',[CityController::class,'update'])->name('city_edit');
    Route::post('control/airplane/edit/{airplane?}',[AirplaneController::class,'update'])->name('airplane_edit');
    Route::post('control/airport/edit/{airport?}',[AirportController::class,'update'])->name('airport_edit');
    Route::post('control/seat/edit/{seat?}',[SeatController::class,'update'])->name('seat_edit');
    Route::post('control/flight/edit/{flight?}',[FlightController::class,'update'])->name('flight_edit');
    Route::post('control/seat_in_plane/edit/{seat_in_plane?}',[SeatInPlaneController::class,'update'])->name('seat_in_plane_edit');
    Route::post('control/user/edit/{user?}',[UserController::class,'update'])->name('user_edit');

    Route::post('control/ticket/filter',[TicketController::class,'admin_filter_tickets'])->name('admin_filter_tickets');

});
