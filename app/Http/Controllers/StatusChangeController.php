<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function dis_collected(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $weight = request('weight');
        if(empty($weight)){
            $weight = 1;
        }

        if(empty(request('dis_id')) || empty(request('city_id'))){
            $msg = 'District or City can not be empty.';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

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

        if(($order_details->first()->status != 3 && $order_details->first()->status != 11) || $order_details->first()->status == 4){
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }
        $ord = null;
        DB::transaction(function() use($order_details, $waybill_id, $weight, &$ord){
            $ord = $order_details->update([
                'status' => 4,
                'st_4_at' => date('Y-m-d H:i:s'),
                'st_4_by' =>Auth::user()->id,
            ]);

            Package::where('waybill_id', $waybill_id)->update([
                'package_weight' => $weight,
            ]);
            
            Receiver::find($order_details->first()->receiver_id)->update([
                'receiver_district_id' => request('dis_id'),
                'receiver_city_id' => request('city_id'),
            ]);

        });
        

        return response()->json($order_details);
    }

    public function dis_dispatched(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-collected.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $branch_id = request('branch_id');
        if(empty($branch_id)){
            $msg = 'Brach can not be empty.';
            return response()->json(['response' => 0, 'msg' => $msg]);
        }

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

        if($order_details->first()->status != 4 || $order_details->first()->status == 5){
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }
        
        DB::transaction(function() use($order_details, $branch_id){
            $order_details = $order_details->update([
                'status' => 5,
                'st_5_at' => date('Y-m-d H:i:s'),
                'st_5_by' =>Auth::user()->id,
                'branch_id' => $branch_id,
            ]);

        });
        

        return response()->json($order_details);
    }
}
