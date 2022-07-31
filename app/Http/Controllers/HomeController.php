<?php

namespace App\Http\Controllers;

use App\Models\InvoiceFail;
use App\Models\Order;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('Super Admin') || $user->hasRole('Seller')) {
            $orders = Order::all();

            $allOrd = $orders->count();
            $sellers = User::role('Seller')->count();
            $deliveredOrd = $orders->where('status', '9');

            $processingOrd = $orders->whereIn('status', ['1', '2', '3']);
            $collectedOrd = $orders->where('status', '4');
            $assignedOrd = $orders->where('status', '7');
            $missRoutOrd = DB::table('orders')
                ->join('order_statuses', 'order_status_id', '=', 'orders.status')
                ->where('orders.status', '6')
                ->whereColumn('st_6_branch', '!=', 'orders.branch_id');
            $rescheduleOrd = $orders->where('status', '8');
            $failed = $orders->where('status', '10');
            $return = $orders->whereIn('status', ['12', '13', '14']);

            if($user->hasRole('Seller')){
                $sellerId = $user->seller->seller_id;
                $deliveredOrd = $deliveredOrd->where('seller_id', $sellerId);
                $processingOrd = $processingOrd->where('seller_id', $sellerId);
                $collectedOrd = $collectedOrd->where('seller_id', $sellerId);
                $assignedOrd = $assignedOrd->where('seller_id', $sellerId);
                $deliveredOrd = $deliveredOrd->where('seller_id', $sellerId);
                $missRoutOrd = $missRoutOrd->where('orders.seller_id', $sellerId);
                $rescheduleOrd = $rescheduleOrd->where('orders.seller_id', $sellerId);
                $failed = $failed->where('orders.seller_id', $sellerId);
                $return = $return->where('orders.seller_id', $sellerId);
            }

            $deliveredOrd = $deliveredOrd->count();
            $processingOrd = $processingOrd->count();
            $collectedOrd = $collectedOrd->count();
            $assignedOrd = $assignedOrd->count();
            $missRoutOrd = $missRoutOrd->count();
            $rescheduleOrd = $rescheduleOrd->count();
            $failed = $failed->count();
            $return = $return->count();

            $deliveryRate = ($allOrd != 0) ? $deliveredOrd / $allOrd : 0;

            $systemStatic = [
                'allOrd' => $allOrd,
                'sellers' => $sellers,
                'deliveryRate' => $deliveryRate,
            ];

            $orderStatics = [
                'processingOrd' => $processingOrd,
                'collectedOrd' => $collectedOrd,
                'assignedOrd' => $assignedOrd,
                'missRoutOrd' => $missRoutOrd,
                'rescheduleOrd' => $rescheduleOrd,
                'failed' => $failed,
                'return' => $return,
                'deliveredOrd' => $deliveredOrd,
            ];

            return view('welcome', ['systemStatic' => $systemStatic, 'orderStatics' => $orderStatics]);
        }

        return view('home');
    }

    public function getuser()
    {
        return Datatables::of(User::query())->make(true);
    }
}
