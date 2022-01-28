<?php

use App\Http\Controllers\HomeController;
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
Route::view('/sms-settings','admin.settings.sms')->name('sms-settings');

//Order Mgt
Route::get('/waybill-reservation', [WaybillController::class, 'waybill_reservation_get'])->name('waybill-reservation');


Route::view('/create-order','admin.order-management.create-order')->name('create-order');
Route::view('/my-orders','admin.order-management.my-orders')->name('my-orders');
Route::view('/barcode-print','admin.order-management.barcode-print')->name('barcode-print');

//logout
Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
});

