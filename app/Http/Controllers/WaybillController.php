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
        $permission = $user->can('waybill-reservation.view');
        
        if(!$permission){
            Auth::logout();
            abort(403);
        }

        return view('order-management.waybill-reservation');


    }
}
