<?php 
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin web" middleware group. Now create something great!
|
*/
Route::get('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm']);
Route::post('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login']);
Route::get('admin', function () {
    return redirect('admin/login');
});

Route::group([
    'name' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth:admin'],
], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');
    Route::resource('faq', App\Http\Controllers\Admin\FaqController::class);
    Route::resource('offers', App\Http\Controllers\Admin\OffersController::class);
    Route::resource('popular-events-news', App\Http\Controllers\Admin\PopularEventsNewsController::class); // popular events news
    Route::resource('translation', \App\Http\Controllers\Admin\TranslationController::class);//Translation
    Route::resource('role', \App\Http\Controllers\Admin\RoleController::class);//Roles
    Route::resource('permission', \App\Http\Controllers\Admin\PermissionController::class);//Permissions
    Route::resource('destinations', \App\Http\Controllers\Admin\DestinationController::class);//Destinations
    Route::resource('agents', \App\Http\Controllers\Admin\AgentController::class);//Agents
    Route::resource('operator', \App\Http\Controllers\Admin\OperatorController::class);//Operator
    Route::resource('currency', \App\Http\Controllers\Admin\CurrencyController::class);//currency
    Route::resource('markups', \App\Http\Controllers\Admin\MarkUpsController::class);//markups
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);//packages
    Route::resource('app', \App\Http\Controllers\Admin\AppController::class);//app
    Route::resource('notifications', \App\Http\Controllers\Admin\PushNotificationsController::class);//notifications
    Route::post('agents/updatePassword/{id}', [\App\Http\Controllers\Admin\AgentController::class, 'updatePassword'])->name('updateAgentPassword');

    Route::post('agents/addWalletBalance/{id}', [\App\Http\Controllers\Admin\AgentController::class, 'addWalletBalance'])->name('addWalletBalance');
    Route::get('agents/view/{id}', [\App\Http\Controllers\Admin\AgentController::class, 'view'])->name('agents.view');
    Route::post('agents/markup/{id}', [\App\Http\Controllers\Admin\AgentController::class, 'updateMarkUp'])->name('agentsUpdateMarkUp');
   

    Route::get('sendNotification/{id}' , [App\Http\Controllers\Admin\PushNotificationsController::class, 'sendNotification'])->name('sendNotification');
    // Ajax update thing
    Route::post('ajax/translation/update', [\App\Http\Controllers\Admin\TranslationController::class, 'ajaxUpdate'])->name('translation.ajax.update');
    Route::get('/customer', [App\Http\Controllers\Admin\HomeController::class, 'CustomerList'])->name('admin.customerList');
    Route::get('/user', [App\Http\Controllers\Admin\UserController::class, 'UserList'])->name('admin.userList');
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'bookingsList'])->name('admin.bookingsList');
    Route::get('/hotelBookings', [App\Http\Controllers\Admin\BookingController::class, 'hotelBookingsList'])->name('admin.hotelbookingsList');

    Route::get('/edit', [App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('admin.editUser');
    Route::post('/updateUser/{id}', [App\Http\Controllers\Admin\UserController::class, 'updateUser'])->name('admin.updateUser');

    Route::get('/changePassword', [App\Http\Controllers\Admin\UserController::class, 'changePassword'])->name('admin.changePassword');
    Route::post('/UpdatePassword', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.updatePassword');

    Route::post('/cancleBooking', [App\Http\Controllers\Admin\BookingController::class, 'cancleBooking'])->name('admin.cancleBooking');

    Route::get('/additionalPrice/edit/{id}', [App\Http\Controllers\Admin\MarkUpsController::class, 'additionalPriceedit'])->name('additionalPriceedit');
    Route::post('/additionalPrice/update/{id}', [App\Http\Controllers\Admin\MarkUpsController::class, 'updateadditionalPrice'])->name('updateadditionalPrice');

    Route::get('/hotelMarkup/edit/{id}', [App\Http\Controllers\Admin\MarkUpsController::class, 'hoteledit'])->name('hotelMarkupedit');
    Route::post('/hotelMarkup/update/{id}', [App\Http\Controllers\Admin\MarkUpsController::class, 'updateHotelMarkupPrice'])->name('updateHotelMarkupPrice');
    Route::get('/hoteladditionalPrice/edit/{id}', [App\Http\Controllers\Admin\MarkUpsController::class, 'hoteladditionalPriceedit'])->name('hoteladditionalPriceedit');
    Route::post('/hoteladditionalPrice/update/{id}', [App\Http\Controllers\Admin\MarkUpsController::class, 'hotelupdateadditionalPrice'])->name('hotelupdateadditionalPrice');

    Route::post('/hotelcancleBooking', [App\Http\Controllers\Admin\BookingController::class, 'hotelcancleBooking'])->name('admin.hotel.cancleBooking');

    Route::get('/appAds/add', [App\Http\Controllers\Admin\AppController::class, 'create'])->name('appads.create');
    Route::post('/appAds/add', [App\Http\Controllers\Admin\AppController::class, 'storeAds'])->name('appads.store');
    Route::get('/appAds/edit/{id}', [App\Http\Controllers\Admin\AppController::class, 'editAds'])->name('appads.edit');
    Route::put('/appAds/update/{id}', [App\Http\Controllers\Admin\AppController::class, 'updateAds'])->name('appads.update');
    //coupon code
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);//Coupon
    Route::resource('seo', \App\Http\Controllers\Admin\SeoController::class);//Seo

    Route::resource('setting', \App\Http\Controllers\Admin\SettingsController::class);//Settings
    Route::resource('popup', \App\Http\Controllers\Admin\PopUpController::class);//popup
    Route::resource('agency', \App\Http\Controllers\Admin\AgencyController::class);//agency

    Route::post('agency/addAgencyWalletBalance/{id}', [\App\Http\Controllers\Admin\AgencyController::class, 'addAgencyWalletBalance'])->name('addAgencyWalletBalance');
    Route::post('agency/markup/{id}', [\App\Http\Controllers\Admin\AgencyController::class, 'updateMarkUp'])->name('agencyUpdateMarkUp');
    Route::get('currencyConverter', [\App\Http\Controllers\Admin\CurrencyController::class, 'currencyConverter'])->name('currencyConverter');

});

Route::get('updateCurrencyByCron', [App\Http\Controllers\Admin\CurrencyController::class, 'updateCurrencyByCron']); // cron currency update
Route::post('admin/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');
?>