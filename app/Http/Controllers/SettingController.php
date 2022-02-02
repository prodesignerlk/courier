<?php

namespace App\Http\Controllers;

use App\Models\WaybillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

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
            'org_id' => $user->org_id,
        ]);

        return response()->json($type_description);
    }
}
