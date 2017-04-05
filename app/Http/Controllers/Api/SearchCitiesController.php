<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rout;

class SearchCitiesController extends Controller
{
   public function index(Request $request)
   {
        $city_name = 'sylhet';
        //dd($city_name);
        $cities = Rout::where('departure_city', $city_name)->get();
        dd($cities);
   }

   public function cityTo(Request $request)
   {
        //$city_name = $request->input('name');
        //$city_name= 'dhaka';
        $error = ['error' => 'No results found'];
        
	        $city_name = $request->input('q');
	        $cities = Rout::where('departure_city', $city_name)->get();
	       // dd($cities);
	        return $cities->count() ? $cities : $error;
	        //return $cities;
       
   }


}
