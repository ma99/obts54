<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rout;
use App\Stop;
use App\City;
use App\Division;
use App\District;

class SearchCitiesController extends Controller
{
   
   protected $request;

   public function __construct(Request $request)
   {
        $this->request = $request;  
   } 
   public function index(Request $request)
   {
        $city_name = 'sylhet';
        //dd($city_name);
        $cities = Rout::where('departure_city', $city_name)->get();
        dd($cities);
   }

   public function cityTo()
   {
        //$city_name = $request->input('name');
        //$city_name= 'dhaka';
        $error = ['error' => 'No results found'];
        
	        $city_name = $this->request->input('q');
	        $cities = Rout::where('departure_city', $city_name)->get();
	       // dd($cities);
	        return $cities->count() ? $cities : $error;
	        //return $cities;
       
   }

   public function pickupPoints()
   {
        //$city_name = $request->input('name');
        //$city_name= 'dhaka';
        $error = ['error' => 'No results found'];
        
          $cityName = $this->request->input('q');
          // $city = City::where('name', $city_name)->first();
          // $cityId = $city->id;
          $cityId = $this->findCityIdByCityName($cityName);

          $stops = Stop::where('city_id', $cityId)->get();
         // dd($cities);
          return $stops->count() ? $stops : $error;
          //return $cities;
       
   }

   public function droppingPoints()
   {
        $error = ['error' => 'No results found'];

        $cityName = $this->request->input('q');        
        $cityId = $this->findCityIdByCityName($cityName);

        $stops = Stop::where('city_id', $cityId)->get();
        // dd($cities);
        return $stops->count() ? $stops : $error;
        //return $cities;
   }

   public function findCityIdByCityName($cityName)
   {
      $city = City::where('name', $cityName)->first();
      return $city->id;
   }

   public function cityList()
   {
    $error = ['error' => 'City Not Found for Bus Service']; 

    //$divisionId = $this->request->input('q');
    $cities = City::all();
    return $cities->count() ? $cities : $error;
   }

   public function districtList()
   {
    $error = ['error' => 'City Not Found']; 

    $divisionId = $this->request->input('q');
    $districts = District::where('division_id', $divisionId)->get();
    return $districts->count() ? $districts : $error;
   }

   public function divisionList()
   {
    $error = ['error' => 'No results found']; 
    $divisions = Division::all();
    return $divisions->count() ? $divisions : $error;
   }

   public function cityName(Request $request)
   {
     $city_code = $request->input('q');
     //$client = new Client(['base_uri' => 'https://foo.com/api/']);
     $client = new Client(['base_uri' => 'https://ziptasticapi.com/']);
      // Send a request to https://foo.com/api/test
      $response = $client->request('GET', $city_code );
      return $response->getBody();
   }


   public function testApi(Request $request)
   {
     # code...
    $city_code = $request->input('q');
     //$client = new Client(['base_uri' => 'https://foo.com/api/']);
     //$client = new Client(['base_uri' => 'https://ziptasticapi.com/']);
     $client = new Client(['base_uri' => 'http://www.mocky.io/v2/']);
      // Send a request to https://foo.com/api/test
     // http://obts.dev/api/testapi?q=30303
     //$response = $client->request('GET', $city_code );
      $response = $client->request('GET', '59103024110000f504591914' );
      //return $response->hello;
     $r = $response->getBody();

     //read json data from Guzzle response
     $obj = json_decode($r); // https://laracasts.com/discuss/channels/requests/request
     //dd($obj);
      return $obj->hello . '/' . $obj->i . '/' . $obj->status  ; //responsecountry;

   }

  
}
