<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DailyDeposit;
use App\Models\DailyFinance;
use App\Models\Seller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class FinanceController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @return Application|Factory|View
     * Seller Side invoice
     */
    public function seller_invoice()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('invoice.view');

        if (!$permission) {
            abort(403);
        }

        if ($user->hasRole('Seller')) {
            $user_details = User::where('id', $user->id)->get();

        } elseif ($user->branch_staff == 1) {
            $user_details = null;

        } else {
            $user_details = Role::where('name', 'Seller')->first()->users;
        }
        return view('finance.seller-invoice')->with(['user_details' => $user_details]);

    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function seller_invoice_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('invoice.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('invoices')
            ->join('sellers', 'sellers.seller_id', '=', 'invoices.seller_id');

        if ($user->hasRole('Seller')) {
            $seller_info = $user->seller;
            $query = $query->where('sellers.seller_id', $seller_info->seller_id);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('orders.pickup_branch_id', [$branch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('invoice_date', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('invoice_date', $request->from_date);
                } else {
                    $query = $query->whereDate('invoice_date', $request->to_date);
                }
            }

            if ($request->payment_status) {
                $query = $query->where('payment_status', $request->payment_status);
            }

            if ($request->seller_id) {
                $query = $query->where('sellers.seller_id', $request->seller_id);
            }
        }

        $query = $query->get();

        return DataTables::of($query)
            ->editColumn('seller_name', function ($query) {
                $seller_info = Seller::find($query->seller_id)->user;
                return $seller_info ? $seller_info->name : 'N/A';
            })
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })
            ->editColumn('pay_status', function ($query) {
                if ($query->payment_status == 1) {
                    $status = '<span class="badge badge-success" > PAYED</span>';
                } else {
                    $status = '<span class="badge badge-danger" > UN-PAYED</span>';
                }

                return $status;
            })
            ->rawColumns(['pay_status', 'action'])
            ->make(true);
    }

    public function daily_finance()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('daily-invoice.view');

        if (!$permission || $user->hasRole('Seller')) {
            abort(403);
        }

        if ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $branch_details = Branch::where('status', '1')->get();
        }

        return view('finance.daily-finance')->with(['branch_details' => $branch_details]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function daily_finance_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('daily-invoice.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('daily_finances')
            ->join('branches', 'branches.branch_id', '=', 'daily_finances.branch_id')
            ->where('payment_status','=',1);

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('branches.branch_id', [$branch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('bill_date', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('bill_date', $request->from_date);
                } else {
                    $query = $query->whereDate('bill_date', $request->to_date);
                }
            }

            if ($request->payment_status) {
                $query = $query->where('payment_status', $request->payment_status);
            }
        }

        $query = $query->get();

        return DataTables::of($query)
            ->editColumn('branch_name', function ($query) {
                $branch = $query->branch_code . ' - ' . $query->branch_name;
                return $branch;
            })
            ->editColumn('payable', function ($query) {
                $daily_deposit_id = $query->daily_deposit_id;
                if(!empty($daily_deposit_id)){
                    $payed_amount = DailyDeposit::find($daily_deposit_id)->payed_amount;
                    return ($query->total_cod_amount - $payed_amount);
                }else{
                    return $query->total_cod_amount;
                }
            })
            ->editColumn('pay_status', function ($query) {
                if ($query->payment_status == 1) {
                    $status = '<span class="badge badge-success" > PAYED</span>';
                } elseif($query->payment_status == 2){
                    $status = '<span class="badge badge-warning" > PENDING</span>';
                } elseif($query->payment_status == 0){
                    $status = '<span class="badge badge-danger" > UN-PAYED</span>';
                }
                return $status;
            })
            ->editColumn('payed_amount', function ($query){
                $daily_deposit_id = $query->daily_deposit_id;
                if(!empty($daily_deposit_id)){
                    return DailyDeposit::find($daily_deposit_id)->payed_amount;
                }else{
                    return 'N/A';
                }
            })
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                $edit = "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";
                return $view . ' ' . $edit;
            })

            ->rawColumns(['pay_status', 'action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function daily_finance_deposit(Request $request): JsonResponse
    {
        $branch_id = request('branch_id');
        $amount = request('amount');
        $from = date('Y-m-d', strtotime(request('from')));
        $to = date('Y-m-d', strtotime(request('to')));
        $description = request('description');

        $deposit_info = null;

        $daily_finance_info = DailyFinance::where('branch_id', $branch_id)->whereBetween('bill_date', [$from, $to]);

        if($daily_finance_info->count() > 0){
            DB::transaction(function () use ($daily_finance_info, $description, $amount, $branch_id, $from, $to, &$deposit_info) {
                $deposit_info = DailyDeposit::create([
                    'payed_amount' => $amount,
                    'remark' => $description,
                    'payed_date' => date('Y-m-d H:i:s'),
                ]);

               $daily_finance_info->update([
                    'payment_status' => 2,
                    'daily_deposit_id' => $deposit_info->daily_deposit_id,
                ]);
            });
        }else{
            $msg = 'There are no any recodes found in this date(range).';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        return response()->json($deposit_info);
    }

    public function daily_Deposit_get(){
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('daily-deposit.view');

        if (!$permission || $user->hasRole('Seller')) {
            abort(403);
        }

        if ($user->branch_staff == 1) {
            $branch_details = $user->staff->branch;
            $branch_details = Branch::whereIn('branch_id', [$branch_details->branch_id])->get();

        } else {
            $branch_details = Branch::where('status', '1')->get();
        }

        return view('finance.daily-deposit')->with(['branch_details' => $branch_details]);
    }

    /**
     * @throws \Exception
     */
    public function daily_deposit_data_table(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('daily-deposit.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('daily_finances')
            ->join('daily_deposits', 'daily_deposits.daily_deposit_id', '=', 'daily_finances.daily_deposit_id')
            ->join('branches', 'branches.branch_id', '=', 'daily_finances.branch_id')
            ->whereIn('payment_status', ['1', '2']);

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch->banch_id;
            $query = $query->whereIn('branches.branch_id', [$branch_id]);
        }

        if ($request->ajax()) {
            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query = $query->whereBetween('payed_date', [$request->from_date, $request->to_date]);
            } elseif (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date)) {
                    $query = $query->whereDate('payed_date', $request->from_date);
                } else {
                    $query = $query->whereDate('payed_date', $request->to_date);
                }
            }

            if ($request->payment_status) {
                $query = $query->where('payment_status', $request->payment_status);
            }
        }

        $query = $query->get();

        return DataTables::of($query)
            ->editColumn('branch_name', function ($query) {
                return $query->branch_code . ' - ' . $query->branch_name;
            })
            ->editColumn('remaining', function ($query) {
                $daily_deposit_id = $query->daily_deposit_id;
                if(!empty($daily_deposit_id)){
                    $payed_amount = DailyDeposit::find($daily_deposit_id)->payed_amount;
                    return ($query->total_cod_amount - $payed_amount);
                }else{
                    return $query->total_cod_amount;
                }
            })
            ->editColumn('pay_status', function ($query) {
                if ($query->payment_status == 1) {
                    $status = '<span class="badge badge-success" > PAYED</span>';
                } elseif($query->payment_status == 2){
                    $status = '<span class="badge badge-warning" > PENDING</span>';
                } elseif($query->payment_status == 0){
                    $status = '<span class="badge badge-danger" > UN-PAYED</span>';
                }
                return $status;
            })
            ->editColumn('payed_amount', function ($query){
                $daily_deposit_id = $query->daily_deposit_id;
                if(!empty($daily_deposit_id)){
                    return DailyDeposit::find($daily_deposit_id)->payed_amount;
                }else{
                    return 'N/A';
                }
            })
            ->editColumn('action', function ($query) {
                $view = "<button type='button' class='btn btn-success btn-icon btn-view' data-id='' data-toggle='tooltip' data-placement='top' title='View'><i data-feather='eye'></i></button>";
                if($query->payment_status != 1){
                    $confirm = "<button type='button' data-id='$query->daily_deposit_id' class='btn btn-danger btn-icon btn-payment-confirm' data-toggle='tooltip' data-placement='top' title='Confirm Payment'><i data-feather='check-circle'></i></button>";
                    return $view . ' ' . $confirm;
                }else{
                    return $view;
                }

            })

            ->rawColumns(['pay_status', 'action'])
            ->make(true);
    }

    public function confirm_deposit(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('daily-deposit.confirm');

        if (!$permission) {
            abort(403);
        }

        $deposit_id = \request('deposit_id');

        $deposit_info = DailyDeposit::find($deposit_id)->dailyFinance->update([
           'payment_status' => '1'
        ]);

        return response()->json($deposit_info);
    }
}
