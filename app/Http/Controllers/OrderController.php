<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Package;
use App\Models\Receiver;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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
            'remark' => 'nullable',
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
                    'remark' => request('remark')
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
        $permission = $user->can('order.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where($user->id)->get();
            $branch_details = Branch::where('status', '1')->get();

        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }

        $status_details = OrderStatus::all();

        return view('order-management.my-orders')->with(['branch_details' => $branch_details, 'user_details' => $user_details, 'status_details' => $status_details]);
    }

    public function my_order_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order.view');

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

        if($user->branch_staff == 1){
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }
        
        $search_st = "st_1_at";

        if ($request->ajax()) {

            if(!empty($request->status)){
                $search_st = 'st_'.$request->status.'_at';
            }
            
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween($search_st, [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate($search_st, $request->from_date);
                } else {
                    $query = $query->whereDate($search_st, $request->to_date);
                }
            }

            if ($request->status) {
                $query = $query->where('orders.status', $request->status);
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_i);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
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
            ->editColumn('date', function($query) use($search_st){
                return $query->$search_st;
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
            ->editColumn('status', function ($query) {
                $badge = "<span class='badge badge-1'>$query->status</span>";
                return $badge;
            })
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function pick_up_pending_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-pending.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where($user->id)->get();
            $branch_details = Branch::where('status', '1')->get();
            
        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }
        return view('process.pickup.pick-pending')->with(['branch_details' => $branch_details, 'user_details' => $user_details]);
    }

    public function pick_up_pending_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-pending.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '1');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if($user->branch_staff == 1){
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.pickup_branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_1_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_1_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_1_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('pickup_branch_id', $request->branch_i);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
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
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function pick_up_collected_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-collected.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where($user->id)->get();
            $branch_details = Branch::where('status', '1')->get();
            
        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }

        return view('process.pickup.pick-collect')->with(['branch_details' => $branch_details, 'user_details' => $user_details]);
    }

    public function pick_up_collected_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-collected.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '2');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if($user->branch_staff == 1){
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.pickup_branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_2_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_2_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_2_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_i);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
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
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function pick_up_dispatched_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-dispatched.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where($user->id)->get();
            $branch_details = Branch::where('status', '1')->get();
            
        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }

        return view('process.pickup.pick-dispatch')->with(['branch_details' => $branch_details, 'user_details' => $user_details]);
    }

    public function pick_up_dispatched_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-dispatched.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '3');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if($user->branch_staff == 1){
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.pickup_branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_3_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_3_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_3_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_i);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
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
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function dis_collected_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where($user->id)->get();
            $branch_details = Branch::where('status', '1')->get();
            
        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }

        $district_details = District::all();
        $city_details = City::all();
        return view('process.distribute.dis-collect')->with(['branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function dis_collected_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '4');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if($user->branch_staff == 1){
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.pickup_branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_4_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_4_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_4_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('pickup_branch_id', $request->branch_i);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
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
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function dis_dispatched_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where($user->id)->get();
            $branch_details = Branch::where('status', '1')->get();
            
        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }

        $district_details = District::all();
        $city_details = City::all();
        $all_branch = Branch::where('status', '1')->get();
        return view('process.distribute.dis-dispatch')->with(['all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function dis_dispatched_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '5');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if($user->branch_staff == 1){
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.pickup_branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_5_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_5_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_5_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_i);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
        }

        $query = $query->get();

        return DataTables::of($query)
            ->editColumn('branch', function ($query) {
                if ($query->branch_id) {
                    $branch_info = Branch::find($query->branch_id);
                    return $branch_info->branch_code . ' - ' . $branch_info->branch_name;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('receiver_conatct_2', function ($query) {
                if ($query->receiver_conatct_2) return $query->receiver_conatct_2;
                else return 'N/A';
            })
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }
}
