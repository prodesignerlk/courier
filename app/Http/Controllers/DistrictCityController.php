<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictCityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function districts_city(Request $request)
    {
        $district_id = request('district_id');
        $city_id = request('city_id');
        
        if($district_id){
            $city_details = District::find($district_id)->city;
            $district_details = NUll;
        }elseif($city_id){
            $district_details = City::find($city_id)->district;
            $city_details = NUll;
        }

        return response()->json(['city_details' => $city_details, 'district_details' => $district_details]);
    }
}
