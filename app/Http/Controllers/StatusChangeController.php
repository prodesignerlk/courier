<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function pickup_collected(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-collected.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');

        $order_details = Order::where('waybill_id', $waybill_id);

        if(empty($order_details->first())){
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if($user->branch_staff == 1){
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('pickup_branch_id', [$branch_id]);
            
            if(empty($order_details->first())){
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if($order_details->first()->status != 1 || $order_details->first()->status == 2){
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }


        $order_details = $order_details->update([
            'status' => 2,
            'st_2_at' => date('Y-m-d H:i:s'),
            'st_2_by' =>Auth::user()->id,
        ]);

        return response()->json($order_details);
    }

    public function pickup_dispatched(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('pickup-dispatched.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');

        $order_details = Order::where('waybill_id', $waybill_id);

        if(empty($order_details->first())){
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if($user->branch_staff == 1){
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('pickup_branch_id', [$branch_id]);
            
            if(empty($order_details->first())){
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if($order_details->first()->status != 2 || $order_details->first()->status == 3){
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }


        $order_details = $order_details->update([
            'status' => 3,
            'st_3_at' => date('Y-m-d H:i:s'),
            'st_3_by' =>Auth::user()->id,
        ]);

        return response()->json($order_details);
    }
}
