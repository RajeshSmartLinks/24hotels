<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();


//language
Route::get('/localize/{lang}', [App\Http\Controllers\FrontEnd\GeneralController::class, 'changeLang'])->name('changelang');
Route::get('/currency/{currency}', [App\Http\Controllers\FrontEnd\GeneralController::class, 'changecurrency'])->name('changecurrency');

Route::get('/', [App\Http\Controllers\FrontEnd\HomeController::class, 'index'])->name('home');
Route::get('some-thing-went-wrong', [App\Http\Controllers\FrontEnd\HomeController::class, 'somethingWentWrong'])->name('some-thing-went-wrong');

Route::get('search/flights', [App\Http\Controllers\FrontEnd\HomeController::class, 'SearchFlights'])->name('SearchFlights');
Route::get('autoSuggest', [App\Http\Controllers\FrontEnd\HomeController::class, 'AjaxAirportList'])->name('autoSuggest');
Route::get('contact-us', [App\Http\Controllers\FrontEnd\HomeController::class, 'contactUs'])->name('contactUs');

// Route::post('flight-review', [App\Http\Controllers\FrontEnd\HomeController::class, 'BookingConfirmation'])->name('flight-review');
Route::get('flight-review/{uuid}/{Key}', [App\Http\Controllers\FrontEnd\HomeController::class, 'BookingConfirmation'])->name('flight-review');

// Route::post('book', [App\Http\Controllers\FrontEnd\HomeController::class, 'Book'])->name('Book');
// Route::get('book', [App\Http\Controllers\FrontEnd\HomeController::class, 'Book'])->name('Book');
Route::post('preview', [App\Http\Controllers\FrontEnd\HomeController::class, 'preview'])->name('preview');


Route::get('bookflight/{flightbookingId}', [App\Http\Controllers\FrontEnd\HomeController::class, 'bookflight'])->name('bookflight');

Route::get('pendingPnr', [App\Http\Controllers\FrontEnd\HomeController::class, 'getPendingPnrs'])->name('getPendingPnrs');

Route::get('farerules', [App\Http\Controllers\FrontEnd\HomeController::class, 'farerules'])->name('farerules');

Route::get('pfd/generator', [App\Http\Controllers\FrontEnd\PdfController::class, 'create'])->name('pdf-generator');

Route::get('test', [App\Http\Controllers\FrontEnd\HomeController::class, 'test']);
Route::get('ticket', [App\Http\Controllers\FrontEnd\HomeController::class, 'ticket']);
Route::get('tt', [App\Http\Controllers\FrontEnd\HomeController::class, 'tt']);


//Manual Auth
Route::get('user/signup', [App\Http\Controllers\FrontEnd\HomeController::class, 'Signup'])->name('user-signup');
Route::post('user/creation', [App\Http\Controllers\FrontEnd\HomeController::class, 'CreateFrontEndUser'])->name('user-creation');
Route::get('user/forget-password', [App\Http\Controllers\FrontEnd\ForgotPasswordController::class, 'showForgetPasswordForm'])->name('user-forget.password.get');
Route::post('user/forget-password', [App\Http\Controllers\FrontEnd\ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('user-forget.password.post'); 
Route::get('reset-password/{token}', [App\Http\Controllers\FrontEnd\ForgotPasswordController::class, 'showResetPasswordForm'])->name('user-reset.password.get');
Route::post('reset-password', [App\Http\Controllers\FrontEnd\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('user-reset.password.post');

Route::get('FAQ', [App\Http\Controllers\FrontEnd\GeneralController::class, 'faq'])->name('faq');
Route::get('Terms-of-use', [App\Http\Controllers\FrontEnd\GeneralController::class, 'TermsOfUse'])->name('TermsOfUse');
Route::get('Privacy-Policy', [App\Http\Controllers\FrontEnd\GeneralController::class, 'PrivacyPolicy'])->name('PrivacyPolicy');
/*General pramotion Page*/
Route::get('flight-booking', [App\Http\Controllers\FrontEnd\GeneralController::class, 'flightbooking'])->name('flightbooking');
/*General pramotion page end*/
//offers
Route::get('offers', [App\Http\Controllers\FrontEnd\OffersController::class, 'index'])->name('offers');
Route::get('offers/{slug}', [App\Http\Controllers\FrontEnd\OffersController::class, 'OfferDetails'])->name('offerDetails');

//Package
Route::get('package/{slug}', [App\Http\Controllers\FrontEnd\PackageController::class, 'PackageDetails'])->name('packageDetails');

//Destination
Route::get('destination/{slug}', [App\Http\Controllers\FrontEnd\DestinationController::class, 'DestinationDetails'])->name('destinationDetails');

//Popular Events news details Page
Route::get('popular-events-news/{slug}', [App\Http\Controllers\FrontEnd\PopularEventsNewsController::class, 'Details'])->name('popularEventsNewsDetails');

Route::group([
    'middleware' => ['auth:web']], function() {
        Route::get('/profile', [App\Http\Controllers\FrontEnd\UserController::class, 'profile'])->name('profile');
        Route::post('/profile/{id}', [App\Http\Controllers\FrontEnd\UserController::class, 'updateProfile'])->name('update-user-profile');
        Route::get('/change-password', [App\Http\Controllers\FrontEnd\UserController::class, 'ChangePassword'])->name('change-password');
        Route::post('/change-password', [App\Http\Controllers\FrontEnd\UserController::class, 'UpdatePassword'])->name('updatePassword');
        Route::get('/user-bookings', [App\Http\Controllers\FrontEnd\UserController::class, 'Bookings'])->name('user-bookings');
        Route::post('/cancelBooking', [App\Http\Controllers\FrontEnd\UserController::class, 'CancleBooking'])->name('cancle-booking');
        Route::get('/wallet-logs', [App\Http\Controllers\FrontEnd\UserController::class, 'walletLogs'])->name('wallet-logs');

        Route::get('/agent-dashboard', [App\Http\Controllers\FrontEnd\UserController::class, 'agentDashboard'])->name('agent-dashboard');
        Route::get('/agent-flight-booking', [App\Http\Controllers\FrontEnd\UserController::class, 'agentFlightBooking'])->name('agent-flight-booking');
        Route::get('/agent-hotel-booking', [App\Http\Controllers\FrontEnd\UserController::class, 'agentHotelBooking'])->name('agent-hotel-booking');
        Route::get('addSubAgent', [App\Http\Controllers\FrontEnd\UserController::class, 'addSubAgent'])->name('add-sub-agent');
        Route::post('storeSubAgent', [App\Http\Controllers\FrontEnd\UserController::class, 'storeAgent'])->name('store-sub-agent');
        
        
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('invoice', [App\Http\Controllers\FrontEnd\HomeController::class, 'invoice'])->name('invoice');
Route::get('pnr', [App\Http\Controllers\FrontEnd\HomeController::class, 'pnr'])->name('pnr');

Route::get('validateCoupon', [App\Http\Controllers\FrontEnd\CouponController::class, 'validateCoupon'])->name('web-validateCoupon');


Route::get('flightTicket/{id}', [App\Http\Controllers\FrontEnd\HomeController::class, 'flightTicket'])->name('flightTicket');


//paymentgateway
Route::post('paymentGateWay', [App\Http\Controllers\FrontEnd\HomeController::class, 'paymentGateWay'])->name('paymentGateWay');


//test routes
Route::get('pendingTicket', [App\Http\Controllers\FrontEnd\HomeController::class, 'pendingTicket'])->name('pendingTicket');
Route::get('test', [App\Http\Controllers\FrontEnd\HomeController::class, 'test'])->name('test');


//hotels
Route::get('downloadStaticTBOHotels', [App\Http\Controllers\FrontEnd\Hotel\StaticController::class, 'downloadTBOHoteldDetails'])->name('downloadStaticTBOHotels');
Route::get('dumpTBOHotelsCode', [App\Http\Controllers\FrontEnd\Hotel\StaticController::class, 'dumpTBOHotelsCode']);
Route::get('dumpTBOHotelsDetails', [App\Http\Controllers\FrontEnd\Hotel\StaticController::class, 'getStaticHotelsdata']);
Route::get('dumpTBOHotelsCountry', [App\Http\Controllers\FrontEnd\Hotel\StaticController::class, 'dumpTBOCountrydump']);
Route::get('dumpTBOHotelsCities', [App\Http\Controllers\FrontEnd\Hotel\StaticController::class, 'dumpTBOCitydump']);

Route::get('hotelautoSuggest', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'AjaxHotelCityList'])->name('hotelautoSuggest');
Route::get('search/hotels', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'SearchHotels'])->name('SearchHotels');
Route::get('hotel/details/{hotelCode}/{searchId}', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'HotelDetails'])->name('HotelDetails');
Route::get('hotel/preBooking/{hotelCode}/{bookingCode}/{searchId}', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'PreBooking'])->name('PreBooking');
Route::post('hotel/savePassenger', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'savePassanger'])->name('hotelSavePassenger');

Route::get('hotel/bookingPreview/{bookingId}', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'HotelBookingPreview'])->name('HotelBookingPreview');

Route::post('hotel/updateSearchRequest', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'updatedHotelsearch'])->name('updatedHotelsearch');




//HotelpaymentGateWay
Route::post('HotelpaymentGateWay', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'HotelpaymentGateWay'])->name('HotelpaymentGateWay');

Route::get('bookHotelRooms/{hotelbookingId}', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'bookHotelRooms'])->name('bookHotelRooms');

Route::get('hotel/getBookingDetails', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'getBookingDetails'])->name('getBookingDetails');

Route::get('hotel/hotelReservation', [App\Http\Controllers\FrontEnd\Hotel\HomeController::class, 'hotelReservation'])->name('hotelReservation');

Route::get('getURPnrInfo', [App\Http\Controllers\FrontEnd\HomeController::class, 'getURPnrInfo'])->name('getURPnrInfo');


Route::get('/test-500', function () {
    abort(500);
});

Route::get('remainderPreview/{id}', [App\Http\Controllers\FrontEnd\HomeController::class, 'flightTicketRemainderMaker'])->name('remainderPreview');


Route::get('remainders', [App\Http\Controllers\CronController::class, 'bookingRemainder']);


//static data dump routes

Route::get('webbedsHotelDump', [App\Http\Controllers\FrontEnd\Hotel\StaticController::class, 'WebBedsHoteldata'])->name('webbedsHotelDump');



//webbeds
Route::get('cityCountryList', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'AjaxHotelCityList'])->name('hotelCityAutoSuggest');
Route::get('search/hotelsList', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'SearchHotels'])->name('webbedsSearchHotels');
Route::get('hotel/rooms/details', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'GethotelDetails'])->name('GethotelDetails');
Route::get('hotel/preBookRoom/{hotelCode}/{bookingCode}/{searchId}', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'PreBooking'])->name('PreBookingRoom');
Route::post('hotel/savePassengerDetails', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'savePassanger'])->name('hotelsavePassengerDetails');

Route::get('hotel/bookingPreviewInfo/{bookingId}', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'HotelBookingPreview'])->name('HotelBookingPreviewInfo');

Route::post('agentHotelpaymentGateWay', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'HotelpaymentGateWay'])->name('agentHotelpaymentGateWay');


Route::get('agentbookHotelRooms/{hotelbookingId}', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'bookHotelRooms'])->name('agentbookHotelRooms');





Route::get('hotelTest', [App\Http\Controllers\FrontEnd\Hotel\Webbeds\HomeController::class, 'test']);
