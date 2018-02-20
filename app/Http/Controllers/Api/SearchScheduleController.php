<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Schedule;

class SearchScheduleController extends Controller
{
    protected $request;

   public function __construct(Request $request)
   {
        $this->request = $request;  
   } 

   public function scheduleList()
   {
        
        $error = ['error' => 'No results found'];

        $schedules = Schedule::all();
        return $schedules->count() ? $schedules : $error;        
        
   }
}
