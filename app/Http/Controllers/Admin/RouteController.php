<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Use App\User;
//Use App\Bus;
Use App\Rout;
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
        // SeatPlan::create([
        //     //'role_id' => $this->id,
        //     'bus_id' => $busId,
        //     'seat_list' => $seatList            
        // ]);        
        Rout::updateOrCreate(
            ['departure_city' => $departureCity, 'arrival_city' => $arraivalCity ],
            ['distance' => $distance]
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
   
}
