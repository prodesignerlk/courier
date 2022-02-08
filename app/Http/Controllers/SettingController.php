<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WaybillOption;
use App\Models\WaybillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function waybill_type_input(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-type.add');

        if (!$permission) {
            abort(403);
        }

        $type_name = request('type_name');
        $type_description = request('type_description');

        $data_save = WaybillType::create([
            'type' => $type_name,
            'description' => $type_description,
        ]);

        return response()->json($data_save);
    }

    public function waybill_setting_get()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-setting.view') || $user->can('waybill-setting.create');

        if(!$permission){
            Auth::logout();
            abort(403);
        }

        return view('settings.waybill-settings');
    }

    public function get_waybill_types()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-type.view');

        if (!$permission) {
            abort(403);
        }

        $waybill_types = WaybillType::all();
        $waybill_option = WaybillOption::all();

        return response()->json(['waybill_types' => $waybill_types, 'waybill_option' => $waybill_option]);
    }

    public function fill_waybill_type_table()
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-type.view');

        if (!$permission) {
            abort(403);
        }
        
        return Datatables::of(WaybillType::query())->make(true);

    }

    public function waybill_description_get(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-type.set');

        if(!$permission){
            Auth::logout();
            abort(403);
        }
        
        $waybill_type_id = request('wayabill_type');
        $waybill_details = WaybillOption::find($waybill_type_id)->description;
        
        return response()->json($waybill_details);
    }

    public function set_waybill_type(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $permission = $user->can('waybill-type.set');

        if(!$permission){
            Auth::logout();
            abort(403);
        }
        
        $waybill_type_id = request('wayabill_type');
            $waybill_option = Setting::where('feature', 'waybill_option')->update([
                'option' => $waybill_type_id,
            ]);
        
            return response()->json($waybill_option);
    }
}
