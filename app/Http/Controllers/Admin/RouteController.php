<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Use App\User;
//Use App\Bus;
Use App\Rout;
Use App\Fare;
//Use App\SeatPlan;

class RouteController extends Controller
{
    protected $request;
    //protected $id;
    //protected $user_id;
    //protected $user;

    public function __construct(Request $request)
    {   
        /*$this->middleware('auth');
        $this->middleware('admin');*/
        $this->request = $request;

        // $this->id = $request->input('id');
        // $this->role = $request->input('role');
        // $this->user_id = $request->input('user_id');
        // //$this->user = $request->user();

        $this->middleware(['auth', 'admin']);
    }

    // public function index()
    // {
    // 	return view('pages.admin');
    // }

    
    /*public function destroy()
    {
        $error = ['error' => 'No results found'];
        $cityCode = $this->request->input('city_code');
        $city = City::where('code', $cityCode)->first();
        if($city) {
            $city->delete();
            return 'success';            
        }
        return $error;
    }*/

    public function store()
    {        
        $this->validate($this->request, [
            'arrival_city' => 'required|max:50',
            'departure_city' => 'required|max:50'
        ]);

        $arraivalCity = $this->request->input('arrival_city');
        $departureCity = $this->request->input('departure_city');
        $distance = $this->request->input('distance');
        
        // $fare_ac = $this->request->input('fare.ac');
        // $fare_non_ac = $this->request->input('fare.non_ac');
        // $fare_delux = $this->request->input('fare.delux');
        
        // $fareDetails = [
        //     'ac' => $this->request->input('fare.ac'),
        //     'non_ac' => $this->request->input('fare.non_ac'),
        //     'deluxe' => $this->request->input('fare.deluxe')
        // ];
        $fareDetails = $this->request->input('fare');
        
       $route = Rout::updateOrCreate(
            ['departure_city' => $departureCity, 'arrival_city' => $arraivalCity ],
            ['distance' => $distance]
        );

        $fare = $route->fare()->updateOrCreate(
            ['rout_id' => $route->id],
            ['details' => $fareDetails]
        );

        return 'Success';

    }

    public function destroy()
    {
        $error = ['error' => 'No results found'];
        $routeId = $this->request->input('route_id');
        $route = Rout::where('id', $routeId)->first();
        if ($route) {
            $route->delete();
            return 'success';            
        }
        return $error;
    }
    public function updateFare()
    {
        $error = ['error' => 'No results found'];
        $routeId = $this->request->input('route_id');
        $fareDetails = $this->request->input('fare');

        Fare::updateOrCreate(
            ['rout_id' => $routeId],
            ['details' => $fareDetails]
        );

        return 'Success';
    }
   
}
