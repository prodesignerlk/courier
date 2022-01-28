<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Admin - Settings
Route::view('/sms-settings','admin.settings.sms')->name('sms-settings');
//Admin - Order Management
Route::view('/waybill-reservation','admin.order-management.waybill-reservation')->name('waybill-reservation');
Route::view('/create-order','admin.order-management.create-order')->name('create-order');
Route::view('/my-orders','admin.order-management.my-orders')->name('my-orders');
Route::view('/barcode-print','admin.order-management.barcode-print')->name('barcode-print');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
