<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Organization;
use App\Models\Package;
use App\Models\Seller;
use App\Models\Setting;
use App\Models\User;
use App\Models\WaybillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class WaybillController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function waybill_reservation_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-reservation.view') || $user->can('waybill-reservation.create');

        if (!$permission) {
            abort(403);
        }

        $waybill_type_details = WaybillType::all();
        $seller_details = Role::where('name', 'Seller')->first()->users;

        $waybill_unused =  Package::select(DB::raw('count(*) as qnt'), DB::raw('max(waybill_id) as max_waybill'), DB::raw('min(waybill_id) as min_waybill'), 'batch_number')->where('package_used_status', '0')->groupBy('batch_number');

        if ($user->hasRole('Seller')) {
            $seller_info = User::find(Auth::user()->id)->seller;
            $waybill_unused = $waybill_unused->where('seller_id', $seller_info->seller_id);
        }

        $waybill_unused = $waybill_unused->get();
        return view('order-management.waybill-reservation')->with(['waybill_type_details' => $waybill_type_details, 'seller_details' => $seller_details, 'waybill_unused' => $waybill_unused]);
    }

    public function waybill_reservation_post(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-reservation.create');

        if (!$permission) {
            abort(403);
        }

        $request->validate([
            'waybill_type' => 'required',
            'user_id' => 'required',
            'reserve_from' => 'required|numeric',
            'reserve_to' => 'required|numeric|gte:reserve_from',
        ]);

        //batch number
        $final_bach_no = Package::orderByDesc('package_id')->first();
        if ($final_bach_no == NULL) {
            $final_bach_no = 0;
        } else {
            $final_bach_no = $final_bach_no->batch_number;
        }

        //waybill type
        $waybill_type = WaybillType::find(request('waybill_type'))->type;

        $seller_id = Seller::where('user_id', request('user_id'))->first()->seller_id;

        if($waybill_type == 'No Prefix'){
            try {
                DB::transaction(function () use ($final_bach_no, $seller_id, $waybill_type) {
                    for ($i = request('reserve_from'); $i <= request('reserve_to'); $i++) {
                        Package::create([
                            'waybill_id' => $i,
                            'waybill_type' => request('waybill_type'),
                            'package_used_status' => '0',
                            'batch_number' => ($final_bach_no + 1),
                            'reserved_date' => date('Y-m-d H:i:s'),
                            'seller_id' => $seller_id,
                        ]);
                    }
                });
            } catch (Throwable $e) {
                // dd($e);
                return back()->with(['error' => 'Waybill reserved failed.', 'error_type' => 'error']);
            }
        }else{
            try {
                DB::transaction(function () use ($final_bach_no, $seller_id, $waybill_type) {
                    for ($i = request('reserve_from'); $i <= request('reserve_to'); $i++) {
                        Package::create([
                            'waybill_id' => $waybill_type . $i,
                            'waybill_type' => request('waybill_type'),
                            'package_used_status' => '0',
                            'batch_number' => ($final_bach_no + 1),
                            'reserved_date' => date('Y-m-d H:i:s'),
                            'seller_id' => $seller_id,
                        ]);
                    }
                });
            } catch (Throwable $e) {
                // dd($e);
                return back()->with(['error' => 'Waybill reserved failed.', 'error_type' => 'error']);
            }
        }

        return back()->with(['success' => 'Waybill reserved successful.']);
    }

    public function get_waybill_details(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $waybill_id = request('waybill_id');
        $package_details = Package::where('waybill_id',  $waybill_id);

        if($user->hasRole('Seller')){
            $seller_id = Seller::where('user_id', $user->id)->first()->seller_id;
            $package_details = $package_details->where('seller_id', $seller_id);
        }

        if($package_details->count() > 0){
            $package_details = $package_details->first();

            $seller_details = $package_details->seller;
            $order_details = $package_details->order;

            if(!empty($order_details)){
                $receiver_details = $order_details->receiver;
                $city_details = $receiver_details->city;
                $district_details = $receiver_details->district;
            }else{
                $receiver_details = 'null';
                $order_details = 'null';
                $city_details = 'null';
                $district_details = 'null';
            }
        }else{
            $seller_details = 'null';
            $receiver_details = 'null';
            $package_details = 'null';
            $order_details = 'null';
            $city_details = 'null';
            $district_details = 'null';
        }

        return response()->json(['district_details' => $district_details, 'city_details' => $city_details, 'seller_details' => $seller_details, 'package_details' => $package_details, 'receiver_details' => $receiver_details, 'order_details' => $order_details]);
    }
}
