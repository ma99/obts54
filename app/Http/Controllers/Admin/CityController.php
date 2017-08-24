<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;

class CityController extends Controller
{
    public function store(Request $request)
    {
    	$this->validate($request, [
            'city_name' => 'required|max:50',
            'division_name' => 'required|max:50'
            //'code' => 'required|max:25',
        ]);

    	$cityCode = $request->input('city_id');
    	$cityName = $request->input('city_name');
        $divisionName = $request->input('division_name');

        City::updateOrCreate(
            ['code' => $cityCode],
            ['name' => $cityName, 'division' => $divisionName]            
        );
    	return 'successfully added';
    }

    public function destroy(Request $request)
    {
        $error = ['error' => 'No results found'];
        $cityCode = $request->input('city_code');
        $city = City::where('code', $cityCode)->first();
        if($city) {
            $city->delete();
            return 'success';            
        }
        return $error;
    }
}
