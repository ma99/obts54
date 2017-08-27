<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Stop;

class StopController extends Controller
{
    public function store(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required|max:50',
            //'division_name' => 'required|max:50'
            //'code' => 'required|max:25',
        ]);

    	$stopName = $request->input('name');
        //$stopId = $request->input('id');
        $cityCode = $request->input('city_id');
        

        Stop::updateOrCreate(
            ['city_id' => $cityCode, 'name' => $cityName ],
            ['name' => $cityName]            
        );
    	return 'successfully added';
    }

    public function destroy(Request $request)
    {
        //$error = ['error' => 'No results found'];
        $stopId = $request->input('stop_id');                
        Stop::destroy($stopId);
        return 'success';
    }
}
