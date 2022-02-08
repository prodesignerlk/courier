<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Package;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create_order_get()
    {
        /** @var User $user */
        $user = Auth::user();

        $permission = $user->can('order.create') || $user->can('order.view');

        if (!$permission) {
            abort(403);
        }

        $district_details = District::all();
        $city_details = City::all();
        $branche_details = Branch::where('status', '1')->get();

        return view('order-management.create-order')->with(['district_details' => $district_details, 'city_details' => $city_details, 'branche_details' => $branche_details]);
    }

    public function create_order_post(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $permission = $user->can('order.create');

        if (!$permission) {
            abort(403);
        }

        $request->validate([
            'waybill_number' => 'required|exists:packages,waybill_id',
            'seller_id' => 'required|exists:sellers,seller_id',
            'cus_name' => 'required',
            'cus_contact' => 'required|digits:10',
            'cus_contact_2' => 'nullable|digits:10',
            'district_id' => 'required|exists:districts,district_id',
            'city_id' => 'required|exists:cities,city_id',
            'order_description' => 'nullable',
            'cod' => 'required|numeric',
            'pickup_branch_id' => 'required|exists:branches,branch_id',
        ]);

        $package_info = Package::where('waybill_id', request('waybill_number'))->first();
        $package_used_status = $package_info->package_used_status;

        if ($package_used_status == 1) {
            return back()->with(['error' => 'Waybill number already used.', 'error_type' => 'warning']);
        }

        try {
            DB::transaction(function () use ($package_info) {
                $package_info->update([
                    'package_used_status' => 1,
                ]);

                $receiver_info = Receiver::create([
                    'receiver_name' => request('cus_name'),
                    'receiver_contact' => request('cus_contact'),
                    'receiver_conatct_2' => request('cus_contact_2'),
                    'receiver_address' => request('cus_address'),
                    'receiver_city_id' => request('city_id'),
                    'receiver_district_id' => request('district_id'),
                ]);

                Order::create([
                    'waybill_id' => request('waybill_number'),
                    'status' => 1,
                    'st_1_at' => date('Y-m-d H:i:s'),
                    'st_1_by' => Auth::user()->id,
                    'seller_id' => request('seller_id'),
                    'cod_amount' => request('cod'),
                    'pickup_branch_id' => request('pickup_branch_id'),
                    'receiver_id' => $receiver_info->receiver_id,
                    'seller_id' => request('seller_id'),
                ]);
            });
        } catch (Throwable $e) {
            // dd($e);
            return back()->with(['error' => 'Order create failed.', 'error_type' => 'error']);
        }

        return back()->with(['success' => 'Order Created']);
    }

    public function my_order_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('orders.view');

        if (!$permission) {
            abort(403);
        }

        return view('order-management.my-orders');
    }

    public function my_order_data_table()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('orders.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        $query = $query->get();


        return DataTables::of($query)
            ->editColumn('pickup_branch', function ($query) {
                if ($query->pickup_branch_id) {
                    $branch_info = Branch::find($query->pickup_branch_id);
                    return $branch_info->branch_code . ' - ' . $branch_info->branch_name;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('receiver_conatct_2', function ($query) {
                if ($query->receiver_conatct_2) return $query->receiver_conatct_2;
                else return 'N/A';
            })
            ->editColumn('branch', function ($query) {
                if ($query->branch_id) {
                    $branch_info = Branch::find($query->branch_id);
                    return $branch_info->branch_code . ' - ' . $branch_info->branch_name;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('status', function($query){
                $badge = "<span class='badge badge-1'>$query->status</span>";
                return $badge;
            })
            ->rawColumns(['status'])
            ->make(true);
    }
}
