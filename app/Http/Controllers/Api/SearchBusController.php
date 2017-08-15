<?php

namespace App\Http\Controllers\Api;

//use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Bus;


class SearchBusController extends Controller
{
   
   protected $request;

   public function __construct(Request $request)
   {
        $this->request = $request;  
   } 
   

   public function busInfo()
   {
        //$city_name = $request->input('name');
        //$city_name= 'dhaka';
        $error = ['error' => 'No results found'];
        
	        $busId = $this->request->input('q');
          $busInfo = Bus::where('id', $busId)->first(); 

          //$array = json_decode(json_encode($object), true);  // object to array          
         
          return ($busInfo == null) ? $error : $busInfo;
   }
}
