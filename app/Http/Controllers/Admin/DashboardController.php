<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Use App\User;
Use App\Role;

class DashboardController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {   
        /*$this->middleware('auth');
        $this->middleware('admin');*/
        $this->request = $request;
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
                    'role_id' => $role->id,
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

    public function destroy()
    {
        if ($this->request->user()->isAdministrator()) {
            $id = $this->request->input('id');
            Role::destroy($id); // Deleting Models                    
            return $this->staffInfo();            
        }
        $actionStatus = ['status' => 'Not Allowed'];
        return $actionStatus;
    }

    public function updateStuffRole()
    {
        if ($this->request->user()->isAdministrator()) {
            $id = $this->request->input('id');
            $role = $this->request->input('role');
            $staff = Role::where('id', $id)->first(); // Deleting Models                    
            if($staff) {
                $staff->update([
                    'name' => $role,
                ]);

            return $this->staffInfo();            
            }
        }
        $actionStatus = ['status' => 'Not Allowed'];
        return $actionStatus;
    }
}
