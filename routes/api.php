<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    //flights

    Route::get('/airportCodes', [App\Http\Controllers\Api\Flights\HomeController::class, 'AirportCodesList']);
    Route::get('/offers', [App\Http\Controllers\Api\Flights\OffersController::class, 'index']);
    Route::get('offers/{slug}', [App\Http\Controllers\Api\Flights\OffersController::class, 'OfferDetails']);

    Route::get('/home', [App\Http\Controllers\Api\Flights\HomeController::class, 'home']);
    Route::get('/flight/search', [App\Http\Controllers\Api\Flights\HomeController::class, 'SearchFlights']);

    Route::get('/destinations', [App\Http\Controllers\Api\Flights\DestinationController::class, 'index']);
    Route::get('/destinations/{slug}', [App\Http\Controllers\Api\Flights\DestinationController::class, 'Details']);

    Route::get('/popularEventsNews', [App\Http\Controllers\Api\Flights\PopularEventsNewsController::class, 'index']);
    Route::get('/popularEventsNews/{slug}', [App\Http\Controllers\Api\Flights\PopularEventsNewsController::class, 'Details']);

    Route::get('/packages', [App\Http\Controllers\Api\Flights\PackageController::class, 'index']);

    Route::post('/details', [App\Http\Controllers\Api\Flights\HomeController::class, 'details']);

    Route::post('/savePassangerDetails', [App\Http\Controllers\Api\Flights\HomeController::class, 'SavePassangerDetails']);

    Route::get('/countries', [App\Http\Controllers\Api\Flights\HomeController::class, 'Countries']);

    Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);

    Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'login']);

    // Route::post('/updateProfile', [App\Http\Controllers\Api\UserController::class, 'updateProfile'])->middleware('auth:api');

    Route::group([
        'middleware' => ['auth:api']], function() {
            Route::post('/updateProfile', [App\Http\Controllers\Api\UserController::class, 'updateProfile']);
            Route::post('/UpdatePassword', [App\Http\Controllers\Api\UserController::class, 'UpdatePassword']); 
            Route::delete('deleteAccount', [App\Http\Controllers\Api\UserController::class, 'deleteAccount']);   
            Route::get('userBooking', [App\Http\Controllers\Api\UserController::class, 'bookings']);   
            Route::post('cancelBooking', [App\Http\Controllers\Api\UserController::class, 'cancelBooking']); 
    });

    Route::get('validateCoupon', [App\Http\Controllers\Api\CouponController::class, 'validateCoupon'])->name('validateCoupon');

    Route::get('/appversion', [App\Http\Controllers\Api\GeneralController::class, 'appVersion']);

    Route::post('/paymentGateWay', [App\Http\Controllers\Api\Flights\HomeController::class, 'paymentGateWay']);

    Route::get('/bookflight/{flightbookingId}', [App\Http\Controllers\Api\Flights\HomeController::class, 'bookflight'])->name('app.bookflightTicket');

    Route::get('/redirect', [App\Http\Controllers\Api\GeneralController::class, 'redirect'])->name('redirect');

    // Route::get('/app/response/{booking_id}', [App\Http\Controllers\Api\Flights\PaymentController::class, 'responseprocessing'])->name('app.response');

    Route::get('pnr', [App\Http\Controllers\Api\Flights\HomeController::class, 'pnr']);

    Route::post('forgotPassword', [App\Http\Controllers\Api\Auth\RegisterController::class, 'forgotPassword']);

    Route::get('notifications', [App\Http\Controllers\Api\NotificationsController::class, 'index']);

    //hotels

    Route::get('/hotelCityCodes', [App\Http\Controllers\Api\Land\HomeController::class, 'HotelCityCodes']);

    Route::post('/searchHotels', [App\Http\Controllers\Api\Land\HomeController::class, 'SearchHotels']);

    Route::get('/hotelDetails', [App\Http\Controllers\Api\Land\HomeController::class, 'HotelDetails']);

    Route::get('/preBooking', [App\Http\Controllers\Api\Land\HomeController::class, 'PreBooking']);

    Route::post('/savePassanger', [App\Http\Controllers\Api\Land\HomeController::class, 'SavePassanger']);

    Route::get('/hotelBookingPreview', [App\Http\Controllers\Api\Land\HomeController::class, 'HotelBookingPreview']);

    Route::post('/hotel/paymentGateWay', [App\Http\Controllers\Api\Land\HomeController::class, 'paymentGateWay']);

    Route::get('/hotel/bookHotelRooms/{hotelbookingId}', [App\Http\Controllers\Api\Land\HomeController::class, 'bookHotelRooms'])->name('app.hotelRoombooking');

    
   
});

