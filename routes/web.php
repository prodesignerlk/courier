<?php

use App\Http\Controllers\DistrictCityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusChangeController;
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

//Order Mgt ================================================================================================================================
Route::get('/waybill-reservation', [WaybillController::class, 'waybill_reservation_get'])->name('waybill_reservation_get');
Route::post('/waybill-reservation', [WaybillController::class, 'waybill_reservation_post'])->name('waybill_reservation_post');

Route::get('/create-order',[OrderController::class, 'create_order_get'])->name('create_order_get');
Route::post('/create-order',[OrderController::class, 'create_order_post'])->name('create_order_post');
Route::post('/bulk-create-order',[OrderController::class, 'create_bulk_order_post'])->name('create_bulk_order_post');

Route::get('/my-orders',[OrderController::class, 'my_order_get'])->name('my-orders');
Route::get('/data-table-my-orders',[OrderController::class, 'my_order_data_table'])->name('my_order_data_table');

Route::view('/barcode-print','order-management.barcode-print')->name('barcode-print');


//Order Mgt ================================================================================================================================

//pick-ups
Route::get('/pick-up/pending-orders',[OrderController::class, 'pick_up_pending_orders_get'])->name('pick_up_pending_orders_get');
Route::get('/pick-up/data-table-pending-orders',[OrderController::class, 'pick_up_pending_orders_data_table'])->name('pick_up_pending_orders_data_table');

Route::get('/pick-up/collected',[OrderController::class, 'pick_up_collected_orders_get'])->name('pick_up_collected_orders_get');
Route::get('/pick-up/data-table-collected-orders',[OrderController::class, 'pick_up_collected_orders_data_table'])->name('pick_up_collected_orders_data_table');
Route::post('/pick-up/collected',[StatusChangeController::class, 'pickup_collected'])->name('pickup_collected');

Route::get('/pick-up/dispatched',[OrderController::class, 'pick_up_dispatched_orders_get'])->name('pick_up_dispatched_orders_get');
Route::get('/pick-up/data-table-dispatched_-orders',[OrderController::class, 'pick_up_dispatched_orders_data_table'])->name('pick_up_dispatched_orders_data_table');
Route::post('/pick-up/dispatched',[StatusChangeController::class, 'pickup_dispatched'])->name('pickup_dispatched');

//Distribute
Route::get('/dis/collect-ord',[OrderController::class, 'dis_collected_orders_get'])->name('dis_collected_orders_get');
Route::get('/dis/data-table-collected-orders',[OrderController::class, 'dis_collected_orders_data_table'])->name('dis_collected_orders_data_table');
Route::post('/dis/collected-odr',[StatusChangeController::class, 'dis_collected'])->name('dis_collected');

Route::get('/dis/dispatched-ord',[OrderController::class, 'dis_dispatched_orders_get'])->name('dis_dispatched_orders_get');
Route::get('/dis/data-table-dispatched-orders',[OrderController::class, 'dis_dispatched_orders_data_table'])->name('dis_dispatched_orders_data_table');
Route::post('/dis/dispatched-odr',[StatusChangeController::class, 'dis_dispatched'])->name('dis_dispatched');

// Comman Ajax================================================================================================================================
Route::post('/ajax/get-sellers-details', [SellerController::class, 'get_all_seller_details'])->name('get_seller_details');
Route::post('/ajaz/get-package-details', [WaybillController::class, 'get_waybill_details'])->name('get_waybill_details');
Route::post('/ajaz/get-district-city', [DistrictCityController::class, 'districts_city'])->name('districts_city');



//logout
Route::get('/logout', function() {Auth::logout(); return redirect('/login');});

Route::get('/getuser', [HomeController::class, 'getuser'])->name('getuser');

Route::get('/general-settings', function () {return view('/settings/general');})->name('general-settings');
Route::get('/default-settings', function () {return view('/settings/default-settings');})->name('default-settings');




// Process Operation


//distribute

// To be Receive Packages 
Route::get('/dis/to-be-receive', function () {
    return view('/process/distribute/dis-to-be-receive');
});
// Received Packages 
Route::get('/dis/received', function () {
    return view('/process/distribute/dis-received');
});

// handover
// Assign To Agent
Route::get('/hand/assign-to-agent', function () {
    return view('/process/handover/hand-assign-to-agent');
});
// deliverd order
Route::get('/hand/deliverd', function () {
    return view('/process/handover/hand-deliverd');
});
// reschedule
Route::get('/hand/reshedule', function () {
    return view('/process/handover/hand-reshedule');
});
// deliver fails
Route::get('/hand/fails', function () {
    return view('/process/handover/hand-fails');
});

// Fails 
// mis-route
Route::get('/fail/mis-route', function () {
    return view('/process/fail/fail-mis-route');
});
// re-route
Route::get('/fail/re-route', function () {
    return view('/process/fail/fail-re-route');
});
// HO (Returns) 
Route::get('/fail/received-ho', function () {
    return view('/process/fail/fail-received-ho');
});
// Return to Client 
Route::get('/fail/return', function () {
    return view('/process/fail/fail-return');
});

// Return to Client 
Route::get('/client-registration', function () {
    return view('/client-reg');
});
