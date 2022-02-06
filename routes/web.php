<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WaybillController;
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

//dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

//Settings =================================================================================================================================

//sms settings
Route::view('/sms-settings','settings.sms')->name('sms-settings');

//Waybill setting
Route::get('/waybill-settings', [SettingController::class, 'waybill_setting_get'])->name('waybill_setting_get');

Route::post('/waybill-description', [SettingController::class, 'waybill_description_get'])->name('waybill_description_get');
Route::post('/waybill-type-add', [SettingController::class, 'waybill_type_input'])->name('waybill_type_input');
Route::post('/waybill-type-get', [SettingController::class, 'get_waybill_types'])->name('get_waybill_types');

Route::get('/fill-waybill-type-table', [SettingController::class, 'fill_waybill_type_table'])->name('fill_waybill_type_table');
Route::post('/set-waybill-type', [SettingController::class, 'set_waybill_type'])->name('set_waybill_type');
// =========================================================================================================================================

//Order Mgt ================================================================================================================================
Route::get('/waybill-reservation', [WaybillController::class, 'waybill_reservation_get'])->name('wayb');
Route::post('/waybill-reservation', [WaybillController::class, 'waybill_reservation_post'])->name('waybill_reservation_post');

Route::view('/create-order','admin.order-management.create-order')->name('create-order');
Route::view('/my-orders','admin.order-management.my-orders')->name('my-orders');
Route::view('/barcode-print','admin.order-management.barcode-print')->name('barcode-print');

// ==========================================================================================================================================

//Seller=====================================================================================================================================
Route::post('/ajax/get-sellers-details', [SellerController::class, 'get_seller_details'])->name('get_seller_details');

//logout
Route::get('/logout', function() {Auth::logout(); return redirect('/login');});

Route::get('/getuser', [HomeController::class, 'getuser'])->name('getuser');

Route::get('/general-settings', function () {return view('/settings/general');})->name('general-settings');
Route::get('/default-settings', function () {return view('/settings/default-settings');})->name('default-settings');




// Process Operation

// pickups
// pending
Route::get('/pickup/pending', function () {
    return view('/process/pick-pending');
});
// collect
Route::get('/pickup/collected', function () {
    return view('/process/pick-collect');
});
// Dispatched
Route::get('/pickup/dispatched', function () {
    return view('/process/pick-dispatch');
});

//distribute
// collect
Route::get('/dis/collect', function () {
    return view('/process/dis-collect');
});
// dispatch
Route::get('/dis/dispatch', function () {
    return view('/process/dis-dispatch');
});
// To be Receive Packages 
Route::get('/dis/to-be-receive', function () {
    return view('/process/dis-to-be-receive');
});
// Received Packages 
Route::get('/dis/received', function () {
    return view('/process/dis-received');
});

// handover
// Assign To Agent
Route::get('/hand/assign-to-agent', function () {
    return view('/process/hand-assign-to-agent');
});
// deliverd order
Route::get('/hand/deliverd', function () {
    return view('/process/hand-deliverd');
});
// reschedule
Route::get('/hand/reshedule', function () {
    return view('/process/hand-reshedule');
});
// deliver fails
Route::get('/hand/fails', function () {
    return view('/process/hand-fails');
});

// Fails 
// mis-route
Route::get('/fail/mis-route', function () {
    return view('/process/fail-mis-route');
});
// re-route
Route::get('/fail/re-route', function () {
    return view('/process/fail-re-route');
});
// HO (Returns) 
Route::get('/fail/received-ho', function () {
    return view('/process/fail-received-ho');
});
// Return to Client 
Route::get('/fail/return', function () {
    return view('/process/fail-return');
});
