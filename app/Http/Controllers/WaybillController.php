<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $permission = $user->can('waybill_reservation.view') || $user->can('waybill_reservation.create');

        if(!$permission){
            abort(403);
        }

        return view('order-management.waybill-reservation');
    }

    public function waybill_reservation_post(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill_reservation.create');

        if(!$permission){abort(403);}
    }
}
