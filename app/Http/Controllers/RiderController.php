<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use App\Models\Rider;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Yajra\DataTables\Facades\DataTables;

class RiderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function rider_view_and_create()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('rider.view');

        if (!$permission) {
            abort(403);
        }

        $branchDetails = Branch::where('status', 1)->orderBy('branch_name', 'asc')->get();
        return view('user-management.rider-reg')->with(['branchDetails', $branchDetails]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * Rider register
     */
    public function rider_register(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('rider.create');

        if (!$permission) {
            abort(403);
        }

        $request->validate([
            'rider_name' => 'required|string|max:255',
            'staff_contact_1' => 'required|string|size:10',
            'staff_contact_2' => 'nullable|string|size:10',
            'staff_nic' => 'required|min:10,max:12',
            'vehicle_no_1' => 'required|max:7',
            'vehicle_no_2' => 'nullable|max:7',
            'staff_address' => 'nullable|string:255',
        ]);

        try {
            DB::transaction(function () use($request){
                $userInfo = User::create([
                    'name' => $request->rider_name,
                    'email' => $request->staff_contact_1,
                    'password' => Hash::make($request->staff_nic),
                    'branch_staff' => 1
                ]);

                $staffInfo = Staff::create(array_merge($request->all(), ['staff_position' => 'Rider', 'user_id' => $userInfo->id]));

                Rider::create(array_merge($request->all(), ['staff_id' => $staffInfo->staff_id]));

                $userInfo->assignRole('Rider');
            });
        } catch (\Throwable $e) {
           return back()->with(['error' => $e->getMessage(), 'error_type' => 'error']);
        }

        return back()->with(['success' => 'Rider registered']);
    }

    public function rider_view_table(){
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('rider.view');

        if (!$permission) {
            abort(403);
        }

        $query = DB::table('users')
            ->join('staff', 'staff.user_id', '=', 'users.id')
            ->join('riders', 'riders.staff_id', '=', 'staff.staff_id')
            ->orderBy('rider_name', 'asc')
            ->get();

        return DataTables::of($query)
            ->editColumn('staff_contact_no', function ($query) {
                $contactNo = $query->staff_contact_1;
                if($query->staff_contact_2){
                    $contactNo .= "/ $query->staff_contact_2";
                }

                return $contactNo;
            })

            ->editColumn('vehicle_no', function ($query) {
                $vehicleNo = $query->vehicle_no_1;
                if($query->vehicle_no_2){
                    $vehicleNo .= "/ $query->vehicle_no_2";
                }

                return $vehicleNo;
            })

            ->editColumn('action', function ($query) {
                return "<button type='button' class='btn btn-warning btn-icon btn-email' data-toggle='tooltip' data-placement='top' title='Edit'><i data-feather='edit'></i></button>";

            })
            ->rawColumns(['status', 'action'])

            ->make(true);
    }
}
