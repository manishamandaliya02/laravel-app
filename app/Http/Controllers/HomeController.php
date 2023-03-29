<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $name = '';
        if(Auth::guard('customer')->user()){
            $name = Auth::guard('customer')->user()->name;
        }else if(Auth::guard('administrator')->user()){
            $name = Auth::guard('administrator')->user()->name;
        }else if(Auth::guard('user')->user()){
            $name = Auth::guard('user')->user()->name;
        }
        return view('home')->with(array('name'=>$name));
    }
}
