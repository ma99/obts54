<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

Use User;

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
        $staffs = Roles::all();
    }
}
