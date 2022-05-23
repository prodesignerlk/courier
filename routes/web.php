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


Route::get('/dis/to-be-receive',[OrderController::class, 'dis_to_be_receive_orders_get'])->name('dis_to_be_receive_orders_get');
Route::get('/dis/data-table-receive-orders',[OrderController::class, 'dis_to_be_receive_orders_data_table'])->name('dis_to_be_receive_orders_data_table');

Route::get('/dis/received-ord',[OrderController::class, 'dis_received_orders_get'])->name('dis_received_orders_get');
Route::get('/dis/data-table-received-orders',[OrderController::class, 'dis_received_orders_data_table'])->name('dis_received_orders_data_table');
Route::post('/dis/received-odr',[StatusChangeController::class, 'dis_received'])->name('dis_received');

//handle
Route::get('/hand/assign-to-agent-ord',[OrderController::class, 'hand_assign_to_agent_orders_get'])->name('hand_assign_to_agent_orders_get');
Route::get('/hand/data-table-assign-to-agent-orders',[OrderController::class, 'hand_assign_to_agent_orders_data_table'])->name('hand_assign_to_agent_orders_data_table');
Route::post('/hand/assign-to-agent-odr',[StatusChangeController::class, 'hand_assign_to_agent'])->name('hand_assign_to_agent');

Route::get('/hand/deliverd-ord',[OrderController::class, 'hand_delivered_orders_get'])->name('hand_delivered_orders_get');
Route::get('/hand/data-table-deliverd-orders',[OrderController::class, 'hand_delivered_orders_data_table'])->name('hand_delivered_orders_data_table');
Route::post('/hand/deliverd-odr',[StatusChangeController::class, 'hand_delivered'])->name('hand_delivered');

Route::get('/hand/reschedule-ord',[OrderController::class, 'hand_reschedule_orders_get'])->name('hand_reschedule_orders_get');
Route::get('/hand/data-table-reschedule-orders',[OrderController::class, 'hand_reschedule_orders_data_table'])->name('hand_reschedule_orders_data_table');
Route::post('/hand/reschedule-odr',[StatusChangeController::class, 'hand_reschedule'])->name('hand_reschedule');

Route::get('/hand/deliver-fail-ord',[OrderController::class, 'hand_deliver_fail_orders_get'])->name('hand_deliver_fail_orders_get');
Route::get('/hand/data-table-deliver-fail-orders',[OrderController::class, 'hand_deliver_fail_orders_data_table'])->name('hand_deliver_fail_orders_data_table');
Route::post('/hand/deliver-fail-odr',[StatusChangeController::class, 'hand_deliver_fail'])->name('hand_deliver_fail');

//Fail
Route::get('/hand/miss-route',[OrderController::class, 'hand_miss_route_orders_get'])->name('hand_miss_route_orders_get');
Route::get('/hand/data-table-miss-route',[OrderController::class, 'hand_miss_route_data_table'])->name('hand_miss_route_data_table');

Route::get('/fail/re-route-ord',[OrderController::class, 'fail_re_route_orders_get'])->name('fail_re_route_orders_get');
Route::get('/fail/data-table-re-route-orders',[OrderController::class, 'fail_re_route_orders_data_table'])->name('fail_re_route_orders_data_table');
Route::post('/fail/re-route-odr',[StatusChangeController::class, 'fail_re_route'])->name('fail_re_route');


/**
 * Finance
 */
//seller invoice
Route::get('/seller-invoice', [\App\Http\Controllers\FinanceController::class, 'seller_invoice'])->name('seller_invoice');
Route::get('/invoice/data-table-seller-invoice',[\App\Http\Controllers\FinanceController::class, 'seller_invoice_data_table'])->name('seller_invoice_data_table');

//daily branch invoice
Route::get('/finance/daily-finance', [\App\Http\Controllers\FinanceController::class, 'daily_finance'])->name('daily_finance');
Route::get('/finance/daily/data-table-daily-finance',[\App\Http\Controllers\FinanceController::class, 'daily_finance_data_table'])->name('daily_finance_data_table');
Route::post('/finance/daily/branch-daily-invoice',[\App\Http\Controllers\FinanceController::class, 'daily_finance_deposit'])->name('daily_finance_deposit');

Route::get('/finance/daily-deposit', [\App\Http\Controllers\FinanceController::class, 'daily_Deposit_get'])->name('daily_Deposit_get');
Route::get('/finance/data-table-daily-deposit', [\App\Http\Controllers\FinanceController::class, 'daily_deposit_data_table'])->name('daily_deposit_data_table');
Route::post('/finance/make-payment-confirm', [\App\Http\Controllers\FinanceController::class, 'confirm_deposit'])->name('confirm_deposit');

// Common Ajax================================================================================================================================
Route::post('/ajax/get-sellers-details', [SellerController::class, 'get_all_seller_details'])->name('get_seller_details');
Route::post('/ajaz/get-package-details', [WaybillController::class, 'get_waybill_details'])->name('get_waybill_details');
Route::post('/ajaz/get-district-city', [DistrictCityController::class, 'districts_city'])->name('districts_city');


//logout
Route::get('/logout', function() {Auth::logout(); return redirect('/login');});

Route::get('/getuser', [HomeController::class, 'getuser'])->name('getuser');

Route::get('/general-settings', function () {return view('/settings/general');})->name('general-settings');
Route::get('/default-settings', function () {return view('/settings/default-settings');})->name('default-settings');


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

// Finance

// Barcode Layout
Route::get('/barcode', function () {
    return view('/order-management/barcode');
});

// login
Route::get('/new-login', function () {
    return view('/auth/new-login');
});

Route::get('/new-register', function () {
    return view('/auth/new-register');
});

Route::get('/new-verify-contact', function () {
    return view('/auth/new-verify-contact');
});

Route::get('/new-verify-email', function () {
    return view('/auth/new-verify-email');
});
