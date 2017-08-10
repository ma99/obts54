<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Use App\User;
Use App\Bus;

class BusController extends Controller
{
    protected $request;
    protected $id;
    protected $user_id;
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

    public function busIds()
    {
       $error = ['error' => 'No results found'];
       //users with roles
         $busIds = Bus::pluck('id')->all(); //->get();         
         
         
         
         /*$staffs =json_decode(json_encode($staffs), FALSE); // object <-- works         
         foreach ($staffs as $staff) {
            //echo $staff['name']; //accesing as array
            echo $staff->name;    // accessing as object
         }*/         
         
         return $busIds;
         //return response()->json($staffs);
         //return json_decode(json_encode($staffs), FALSE);
        // return $error;
    }

    public function destroy()
    {
        $user = $this->request->user();
        //if ($this->request->user()->isAdministrator()) {
        if ($user->isAdministrator()) {
            //$id = $this->request->input('id');
            $id = $this->id;
            Role::destroy($id); // Deleting Models               
            $this->addToRoleLogs($user, 'Deleted');                 
            return $this->staffInfo();            
        }
        $actionStatus = ['status' => 'Not Allowed'];
        return $actionStatus;
    }

    public function updateStuffRole()
    {
        $user = $this->request->user();
        //if ($this->request->user()->isAdministrator()) {
        if ($user->isAdministrator()) {
            //$id = $this->request->input('id');
            //$role = $this->request->input('role');
            $id = $this->id;
            $role = $this->role;
            $staff = Role::where('id', $id)->first();                    
            if($staff) {
                $staff->update([
                    'name' => $role,
                ]);
            $action = 'Changed to '. $role;            
            $this->addToRoleLogs($user, $action);    
            return $this->staffInfo();            
            }
        }
        $actionStatus = ['status' => 'Not Allowed'];
        return $actionStatus;
    }
    public function addToRoleLogs($adminUser, $action)    
    {
        $user = User::find($this->user_id);
        RoleLog::create([
            //'role_id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $user->name,
            //'email' => $user->email,
            'action' => $action,
            'by' => $adminUser->name
        ]);
    }
}
