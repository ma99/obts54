<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Schedule;

class ScheduleController extends Controller
{
    protected $request;

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

    public function store()
    {        
        $this->validate($this->request, [
            'arrival_time' => 'required',
            'departure_time' => 'required',
            'route_id' => 'required',
            'bus_id' => 'required'
        ]);

        $arrivalTime = $this->request->input('arrival_time');
        $departureTime = $this->request->input('departure_time');
        $busId = $this->request->input('bus_id');
        $routeId = $this->request->input('route_id');
        
        
       $Schedule = Schedule::updateOrCreate(
            ['rout_id' => $routeId, 'bus_id' => $busId ],
            ['departure_time' => $departureTime, 'arrival_time' => $arrivalTime]
        );

        return 'Success';

    }

}
