<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;

class CityController extends Controller
{
    public function store(Request $request)
    {
    	// $this->validate($request, [
     //        'name' => 'required|max:25',
     //        //'code' => 'required|max:25',
     //    ]);
    	return 'success';
    }
}
