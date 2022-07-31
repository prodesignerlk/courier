<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;


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

    public function seller_view_and_create(){
        $cityDetails = City::orderBy('city_name', 'asc')->get();
        $districtDetails = District::orderBy('district_name', 'asc')->get();
        session(['userMode' => 'admin']);

        return view('user-management.client-reg')->with(['cityDetails' => $cityDetails, 'districtDetails' => $districtDetails]);
    }

    public function seller_view_table(Request $request){
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('seller.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('users')
            ->join('sellers', 'sellers.user_id', '=', 'users.id')
            ->join('banks', 'banks.seller_id', '=', 'sellers.seller_id')
            ->orderBy('name', 'asc')
            ->get();

        return DataTables::of($query)
            ->editColumn('city', function ($query) {
                if ($query->city_id) {
                    return City::find($query->city_id)->city_name;
                }

                return 'N/A';
            })

            ->editColumn('district', function ($query) {
                if ($query->district_id) {
                    return District::find($query->district_id)->district_name;
                }

                return 'N/A';
            })

            ->editColumn('payment_period', function ($query) {
                return $query->payment_period.' days';
            })

            ->editColumn('action', function ($query) {
                return "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";

            })
            ->rawColumns(['action'])

            ->make(true);
    }

}
