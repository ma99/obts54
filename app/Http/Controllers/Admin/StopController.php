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
            'stop_list.*.name' => 'required|max:50',       // array validation     
        ]);

        $stopList = $request->input('stop_list');    	
        $cityCode = $request->input('city_id');

        
        foreach ($stopList as $stop) {                
           Stop::updateOrCreate(
                ['city_id' => $stop['city_id'], 'name' => $stop['name'] ],
                ['name' => $stop['name']]            
            );
        }
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
