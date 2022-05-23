<?php

namespace App\Http\Controllers;

use App\Imports\OrderBulkImport;
use App\Models\AssignToAgent;
use App\Models\Branch;
use App\Models\City;
use App\Models\DeliverFailReason;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Package;
use App\Models\Receiver;
use App\Models\RescheduleReason;
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

    public function create_bulk_order_post(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $permission = $user->can('order.create');

        if (!$permission) {
            abort(403);
        }

        $file = request()->file('select_file');

        $rules = [
            'select_file'  => 'required|mimes:xls,xlsx',
            'bulk_pickup_branch_id' => 'required'
        ];

        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $file = $request->file('select_file')->store('imports');
        $data = [
            'pickup_branch_id' => request('bulk_pickup_branch_id')
        ];

        $import = new OrderBulkImport($data);
        $import->import($file);

        if (count($import->errors()) > 0) {
            return back()->with(['alert' => 'fail', 'error' => 'Bulk Upload Fail']);
        } else {
            return back()->with(['alert' => 'done']);
        }
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
            $user_details = User::where('idi', $user->id)->get();
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

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        $search_st = "st_1_at";

        if ($request->ajax()) {

            if (!empty($request->status)) {
                $search_st = 'st_' . $request->status . '_at';
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
                $query = $query->where('branch_id', $request->branch_id);
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
            ->editColumn('date', function ($query) use ($search_st) {
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

    //pickup
    public function pick_up_pending_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-pending.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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

        if ($user->branch_staff == 1) {
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
                $query = $query->where('pickup_branch_id', $request->branch_id);
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
            $user_details = User::where('idi', $user->id)->get();
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

        if ($user->branch_staff == 1) {
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
                $query = $query->where('pickup_branch_id', $request->branch_id);
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
            $user_details = User::where('idi', $user->id)->get();
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

        if ($user->branch_staff == 1) {
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
                $query = $query->where('pickup_branch_id', $request->branch_id);
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

    //distribute
    public function dis_collected_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
            ->join('packages', 'orders.waybill_id', 'packages.waybill_id')
            ->where('orders.status', '4');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
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
                $query = $query->where('pickup_branch_id', $request->branch_id);
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
        $permission = $user->can('order-dispatched.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        $permission = $user->can('order-dispatched.view');

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

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
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
                $query = $query->where('branch_id', $request->branch_id);
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

    public function dis_to_be_receive_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-to-be-receive.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        return view('process.distribute.dis-to-be-receive')->with(['all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function dis_to_be_receive_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-to-be-receive.view');

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

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
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
                $query = $query->where('branch_id', $request->branch_id);
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

    public function dis_received_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-received.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        return view('process.distribute.dis-received')->with(['all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function dis_received_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-received.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '6');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_6_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_6_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_6_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
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
            ->setRowClass(function ($query) {
                return $query->branch_id != $query->st_6_branch ? 'alert-warning' : '';
            })
            ->make(true);
    }

    //handover
    public function hand_assign_to_agent_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-assign-to-agent.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        $active_riders = Role::where('name', 'Rider')->first()->users->where('user_status', '1');
        return view('process.handover.hand-assign-to-agent')->with(['active_riders' => $active_riders, 'all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function hand_assign_to_agent_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-ssign-to-agent.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->join('assign_to_agents', 'orders.order_id', '=', 'assign_to_agents.order_id')
            ->where([['orders.status', '7'], ['assign_to_agents.status', '1']]);

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('assign_date', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('assign_date', $request->from_date);
                } else {
                    $query = $query->whereDate('assign_date', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }

            if ($request->staff_id) {
                $query = $query->where('assign_to_agents.staff_id', $request->staff_id);
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
            ->editColumn('attemp', function ($query) {
                return $attemp_count = AssignToAgent::where('order_id', $query->order_id)->count();
            })
            ->editColumn('rider_name', function ($query) {
                $rider = AssignToAgent::where('order_id', $query->order_id)->orderByDesc('assign_to_agent_id')->first()->staff->user;
                if (!empty($rider)) {
                    return $rider->name;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('assign_date', function ($query) {
                $assign = AssignToAgent::where('order_id', $query->order_id)->orderByDesc('assign_to_agent_id')->first();
                if (!empty($assign)) {
                    return $assign->assign_date;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function hand_delivered_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-delivered.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        $active_riders = Role::where('name', 'Rider')->first()->users->where('user_status', '1');
        return view('process.handover.hand-deliverd')->with(['active_riders' => $active_riders, 'all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function hand_delivered_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-delivered.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->join('assign_to_agents', 'orders.order_id', '=', 'assign_to_agents.order_id')
            ->where([['orders.status', '9'], ['assign_to_agents.status', '1']]);

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_9_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_9_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_9_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }

            if ($request->staff_id) {
                $query = $query->where('assign_to_agents.staff_id', $request->staff_id);
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

    public function hand_reschedule_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-reschedule.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        $active_riders = Role::where('name', 'Rider')->first()->users->where('user_status', '1');
        $reschedule_reason = RescheduleReason::all();

        return view('process.handover.hand-reshedule')->with(['reschedule_reason' => $reschedule_reason, 'active_riders' => $active_riders, 'all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function hand_reschedule_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-reschedule.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->join('assign_to_agents', 'orders.order_id', '=', 'assign_to_agents.order_id')
            ->join('reschedules', 'orders.order_id', '=', 'reschedules.order_id')
            ->where([['orders.status', '8'], ['assign_to_agents.status', '1'], ['reschedules.status', '1']]);

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('reschedule_date', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('reschedule_date', $request->from_date);
                } else {
                    $query = $query->whereDate('reschedule_date', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }

            if ($request->staff_id) {
                $query = $query->where('assign_to_agents.staff_id', $request->staff_id);
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
            ->editColumn('attemp', function ($query) {
                return $attemp_count = AssignToAgent::where('order_id', $query->order_id)->count();
            })
            ->editColumn('reason', function ($query) {
                $reason = RescheduleReason::find($query->reason_id);
                if (!empty($reason)) {
                    return $reason->reason;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('rider_name', function ($query) {
                $rider = AssignToAgent::where('order_id', $query->order_id)->orderByDesc('assign_to_agent_id')->first()->staff->user;
                if (!empty($rider)) {
                    return $rider->name;
                } else {
                    return 'N/A';
                }
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function hand_deliver_fail_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-deliver-fail.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
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
        $active_riders = Role::where('name', 'Rider')->first()->users->where('user_status', '1');
        $deliver_fail_reason = DeliverFailReason::all();

        return view('process.handover.hand-fails')->with(['deliver_fail_reason' => $deliver_fail_reason, 'active_riders' => $active_riders, 'all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function hand_deliver_fail_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-deliver-fail.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->join('assign_to_agents', 'orders.order_id', '=', 'assign_to_agents.order_id')
            ->where([['orders.status', '10'], ['assign_to_agents.status', '1']]);

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_10_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_10_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_10_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }

            if ($request->staff_id) {
                $query = $query->where('assign_to_agents.staff_id', $request->staff_id);
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
            ->editColumn('attemp', function ($query) {
                return $attemp_count = AssignToAgent::where('order_id', $query->order_id)->count();
            })
            ->editColumn('reason', function ($query) {
                $reason = DeliverFailReason::find($query->st_10_reason);
                if (!empty($reason)) {
                    return $reason->reason;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('rider_name', function ($query) {
                $rider = AssignToAgent::where('order_id', $query->order_id)->orderByDesc('assign_to_agent_id')->first()->staff->user;
                if (!empty($rider)) {
                    return $rider->name;
                } else {
                    return 'N/A';
                }
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function hand_miss_route_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-miss-route.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('idi', $user->id)->get();
            $branch_details = Branch::where('status', '1')->get();
        } elseif ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $user_details = null;
            $branch_details = Branch::whereIn('st_6_by', [$branch_details->branch_id])->get();
        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
            $branch_details = Branch::where('status', '1')->get();
        }

        $district_details = District::all();
        $city_details = City::all();
        $all_branch = Branch::where('status', '1')->get();

        return view('process.fail.fail-mis-route')->with(['all_branch' => $all_branch, 'branch_details' => $branch_details, 'user_details' => $user_details, 'district_details' => $district_details, 'city_details' => $city_details]);
    }

    public function hand_miss_route_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-miss-route.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '6')
            ->whereColumn('st_6_branch', '!=', 'orders.branch_id');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_6_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_6_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_6_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
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
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='$query->waybill_id' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->editColumn('received_branch', function ($query) {
                if ($query->st_6_branch) {
                    $branch_info = Branch::find($query->st_6_branch);
                    return $branch_info->branch_code . ' - ' . $branch_info->branch_name;
                } else {
                    return 'N/A';
                }
            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }

    public function fail_re_route_orders_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-re-route.view');

        if (!$permission) {
            abort(403);
        }

        return view('process.fail.fail-re-route')->with([]);
    }

    public function fail_re_route_orders_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-deliver-fail.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('orders')
            ->join('sellers', 'sellers.seller_id', '=', 'orders.seller_id')
            ->join('receivers', 'receivers.receiver_id', '=', 'orders.receiver_id')
            ->join('order_statuses', 'order_status_id', '=', 'orders.status')
            ->where('orders.status', '11');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $banch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.branch_id', [$banch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('st_11_at', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('st_11_at', $request->from_date);
                } else {
                    $query = $query->whereDate('st_11_at', $request->to_date);
                }
            }

            if ($request->branch_id) {
                $query = $query->where('branch_id', $request->branch_id);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }

            if ($request->staff_id) {
                $query = $query->where('assign_to_agents.staff_id', $request->staff_id);
            }
        }

        $query = $query->get();

        return DataTables::of($query)->make(true);
    }
}
