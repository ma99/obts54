<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function showSession(Request $request)
    {
        // var_dump($_SESSION);
        print_r(session('total_amount'));        
        $data = $request->session()->all();
        print_r($data['booking_id']);        
        dd($data);
    }

    public function admin()
    {
        return view('admin.test_sidebar');
    }



    public function forbidden()
    {
        $user = auth()->user();
        return view('common.forbidden', compact('user') );
    }
}
