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
Route::post('/waybill-type-get', [SettingController::class, 'getWaybillTypes'])->name('getWaybillTypes');
Route::get('/fill-waybill-type-table', [SettingController::class, 'fill_waybill_type_table'])->name('fill_waybill_type_table');