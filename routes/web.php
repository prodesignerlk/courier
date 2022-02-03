<?php

use App\Http\Controllers\HomeController;
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

//Settings
Route::view('/sms-settings','settings.sms')->name('sms-settings');

//Order Mgt
Route::get('/waybill-reservation', [WaybillController::class, 'waybill_reservation_get'])->name('waybill-reservation');

Route::view('/create-order','admin.order-management.create-order')->name('create-order');
Route::view('/my-orders','admin.order-management.my-orders')->name('my-orders');
Route::view('/barcode-print','admin.order-management.barcode-print')->name('barcode-print');

//logout
Route::get('/logout', function() {Auth::logout(); return redirect('/login');});

Route::get('/getuser', [HomeController::class, 'getuser'])->name('getuser');

Route::get('/general-settings', function () {return view('/settings/general');})->name('general-settings');
Route::get('/waybill-settings', function () {return view('/settings/waybill-settings');})->name('waybill-settings');
Route::get('/default-settings', function () {return view('/settings/default-settings');})->name('default-settings');

//Waybill Type Insert
Route::post('/waybill-type-add', [SettingController::class, 'waybill_type_input'])->name('waybill_type_input');

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