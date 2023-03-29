<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        if(\Auth::guard('user')->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect('/posts')->with("success", "Login successfully");
        }
        return redirect('/login')->with("failed", "Login failed");
    }

    public function perform()
    {
        Session::flush();
        
       // Auth::logout();
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return  redirect('/login');
        }
        return  redirect('/login');
    }
}
