<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function get_all_seller_details()
    {
        /** @var User $user */
        $user = Auth::user();

        $permission = $user->can('seller.view');

        if(!$permission){abort(403);}

        $seller_details = Role::where('name', 'Seller')->first()->users;

        return response()->json($seller_details);
    }
}
