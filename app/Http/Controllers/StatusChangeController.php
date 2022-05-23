<?php

namespace App\Http\Controllers;

use App\Models\AssignToAgent;
use App\Models\Order;
use App\Models\Package;
use App\Models\previousReRoute;
use App\Models\Receiver;
use App\Models\Reschedule;
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

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('pickup_branch_id', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if ($order_details->first()->status != 1 || $order_details->first()->status == 2) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }


        $order_details = $order_details->update([
            'status' => 2,
            'st_2_at' => date('Y-m-d H:i:s'),
            'st_2_by' => $user->id,
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

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('pickup_branch_id', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if ($order_details->first()->status != 2 || $order_details->first()->status == 3) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }


        $order_details = $order_details->update([
            'status' => 3,
            'st_3_at' => date('Y-m-d H:i:s'),
            'st_3_by' => $user->id,
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
        if (empty($weight)) {
            $weight = 1;
        }

        if (empty(request('dis_id')) || empty(request('city_id'))) {
            $msg = 'District or City can not be empty.';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        $order_details = Order::where('waybill_id', $waybill_id);

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if (($order_details->first()->status != 3 && $order_details->first()->status != 11) || $order_details->first()->status == 4) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        $ord = null;
        DB::transaction(function () use ($order_details, $user, $waybill_id, $weight, &$ord) {
            $ord = $order_details->update([
                'status' => 4,
                'st_4_at' => date('Y-m-d H:i:s'),
                'st_4_by' => $user->id,
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
        $permission = $user->can('order-dispatch.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $branch_id = request('branch_id');
        if (empty($branch_id)) {
            $msg = 'Brach can not be empty.';
            return response()->json(['response' => 0, 'msg' => $msg]);
        }

        $order_details = Order::where('waybill_id', $waybill_id);

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($order_details->first()->status != 4 || $order_details->first()->status == 5) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        DB::transaction(function () use ($order_details, $user, $branch_id) {
            $order_details = $order_details->update([
                'status' => 5,
                'st_5_at' => date('Y-m-d H:i:s'),
                'st_5_by' => $user->id,
                'branch_id' => $branch_id,
            ]);
        });


        return response()->json($order_details);
    }

    public function dis_received(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-received.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $branch_id = request('branch_id');
        $order_details = Order::where('waybill_id', $waybill_id);

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }


        if ($order_details->first()->status != 5 || $order_details->first()->status == 6) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        DB::transaction(function () use ($order_details, $user, $branch_id) {
            $order_details = $order_details->update([
                'status' => 6,
                'st_6_at' => date('Y-m-d H:i:s'),
                'st_6_by' => $user->id,
                'st_6_branch' => $branch_id,
            ]);
        });


        return response()->json($order_details);
    }

    public function hand_assign_to_agent(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-assign-to-agent.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $order_details = Order::where('waybill_id', $waybill_id);
        $assign_details = '';

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('branch_id', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        $reschedule_info = $order_details->first()->reschedule->where('status','1');

        if($reschedule_info->count() > 0 && $reschedule_info->first()->reassign == 0){
            $msg = 'Seller did not approve!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if (($order_details->first()->status != 6 && $order_details->first()->status != 8) || $order_details->first()->status == 7) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if($order_details->first()->branch_id != $order_details->first()->st_6_branch){
            $msg = 'Received to wrong brnach. Please re-route.';
            return response()->json(['response' => '0', 'msg' => $msg]);

        }

        DB::transaction(function () use ($order_details, $user, &$assign_details) {
            $order_details->update([
                'status' => 7,
            ]);

            AssignToAgent::where('order_id', $order_details->first()->order_id)->update([
                'status' => '0'
            ]);

            $assign_details = AssignToAgent::create([
                'assign_date' => date('Y-m-d H:i:s'),
                'staff_id' => request('staff_id'),
                'order_id' => $order_details->first()->order_id,
                'assign_by' => $user->id,
                'assign_at' => date('Y-m-d H:i:s'),
            ]);
        });


        return response()->json($assign_details);
    }

    public function hand_delivered(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-delivered.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $order_details = Order::where('waybill_id', $waybill_id);

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('branch_id', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if ($order_details->first()->status != 7 || $order_details->first()->status == 9) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        //calculate delivery charege
        $seller_info = $order_details->first()->seller;
        $package_info = $order_details->first()->package;

        $extra_price_rate = $seller_info->extra_price;
        if(empty($extra_price_rate)){
            $msg = 'Seller extra rate error!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        //regulaer_price
        $regular_price = $seller_info->regular_price;
        if(empty($regular_price)){
            $msg = 'Seller regular rate error!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        //extra_price
        $extra_weight = ($package_info->package_weight) - 1;
        $extra_price = $extra_weight*$extra_price_rate;

        //tot delivery
        $total_delivery_cost = $regular_price + $extra_price;

        //cod amount
        $cod = $order_details->first()->cod_amount;

        //net prce
        $net_price = $cod - $total_delivery_cost;



        $order_details = $order_details->update([
            'status' => 9,
            'delivery_cost' => $total_delivery_cost,
            'net_price' => $net_price,
            'st_9_at' => date('Y-m-d H:i:s'),
            'st_9_by' => $user->id,
        ]);

        return response()->json($order_details);
    }

    public function hand_reschedule(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-reschedule.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $reason_id = request('reason_id');

        $order_details = Order::where('waybill_id', $waybill_id);
        $reschedule_details = '';

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('branch_id', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if ($order_details->first()->status != 7 || $order_details->first()->status == 8) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        DB::transaction(function () use ($order_details, $reason_id, $user, &$reschedule_details) {
            $order_details->update([
                'status' => 8,
            ]);

            Reschedule::where('order_id', $order_details->first()->order_id)->update([
                'status' => '0'
            ]);

            $reschedule_details = Reschedule::create([
                'reschedule_date' => date('Y-m-d H:i:s'),
                'reason_id' => $reason_id,
                'order_id' => $order_details->first()->order_id,
                'reschedule_by' => $user->id,
                'reschedule_at' => date('Y-m-d H:i:s'),
            ]);
        });


        return response()->json($reschedule_details);
    }

    public function hand_deliver_fail(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-delivered.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');
        $reason_id = request('reason_id');

        $order_details = Order::where('waybill_id', $waybill_id);

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('branch_id', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if ($order_details->first()->status != 7 || $order_details->first()->status == 10) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        //calculate delivery charge
        $seller_info = $order_details->first()->seller;
        $package_info = $order_details->first()->package;

        $extra_price_rate = $seller_info->extra_price;
        if(empty($extra_price_rate)){
            $msg = 'Seller extra rate error!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        //regular_price
        $regular_price = $seller_info->regular_price;
        if(empty($regular_price)){
            $msg = 'Seller regular rate error!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        //extra_price
        $extra_weight = ($package_info->package_weight) - 1;
        $extra_price = $extra_weight*$extra_price_rate;

        //tot delivery
        $total_delivery_cost = $regular_price + $extra_price;

        //net price
        $net_price =  (-$total_delivery_cost);

        $order_details = $order_details->update([
            'status' => 10,
            'delivery_cost' => $total_delivery_cost,
            'net_price' => $net_price,
            'st_10_at' => date('Y-m-d H:i:s'),
            'st_10_by' => $user->id,
            'st_10_reason' => $reason_id,
        ]);

        return response()->json($order_details);
    }

    public function fail_re_route(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('order-re-route.mark');

        if (!$permission) {
            abort(403);
        }

        $waybill_id = request('waybill_id');

        $order_details = Order::where('waybill_id', $waybill_id);

        if (empty($order_details->first())) {
            $msg = 'Invalid waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if ($user->branch_staff == 1) {
            $branch_id = $user->staff->branch_id;
            $order_details = $order_details->whereIn('st_6_branch', [$branch_id]);

            if (empty($order_details->first())) {
                $msg = 'Invalid waybill number!';
                return response()->json(['response' => '0', 'msg' => $msg]);
            }
        }

        if (($order_details->first()->status != 6 && $order_details->first()->status != 5) || $order_details->first()->status == 11) {
            $msg = 'Invalid/ Already maked waybill number!';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        if($order_details->first()->branch_id == $order_details->first()->st_6_branch){
            $msg = 'Correct order. you can\'t re-route this order.';
            return response()->json(['response' => '0', 'msg' => $msg]);
        }

        DB::transaction(function() use($order_details, $user){

            previousReRoute::create([
                'order_id' => $order_details->first()->order_id,
                'st_4_at' => $order_details->first()->st_4_at,
                'st_4_by' => $order_details->first()->st_4_by,
                'st_5_at' => $order_details->first()->st_5_at,
                'st_5_by' => $order_details->first()->st_5_by,
                'st_6_at' => $order_details->first()->st_6_at,
                'st_6_by' => $order_details->first()->st_6_by,
                'st_6_branch' => $order_details->first()->st_6_branch,
                'reroute_by' => $user->id,
                'reroute_at' =>date('Y-m-d H:i:s')
            ]);

            $order_details = $order_details->update([
                'status' => 11,
                'st_11_at' => date('Y-m-d H:i:s'),
                'st_11_by' => $user->id,

                'st_4_at' => null,
                'st_4_by' => null,
                'st_5_at' => null,
                'st_5_by' => null,
                'st_6_at' => null,
                'st_6_by' => null,
                'st_6_branch' => null,
            ]);
        });



        return response()->json($order_details);
    }
}
