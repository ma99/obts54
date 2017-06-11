<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('auth');
        $this->middleware('admin');*/
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
    	return view('pages.admin');
    }

    public function staffInfo()
    {
       $error = ['error' => 'No results found'];
       //users with roles
         $users = User::with(['roles' => function($qry) {
            $qry->where('name', 'admin')
                ->orWhere('name', 'staff');
         }])->get();         
         
         foreach ($users as $user) {            
            foreach ($user->roles as $role) {                
                $staffs[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'role' => $role->name
                ];                
            }
         }         
         
         /*$staffs =json_decode(json_encode($staffs), FALSE); // object <-- works         
         foreach ($staffs as $staff) {
            //echo $staff['name']; //accesing as array
            echo $staff->name;    // accessing as object
         }*/         
         return $staffs;
         //return response()->json($staffs);
         //return json_decode(json_encode($staffs), FALSE);
        // return $error;
    }
}
