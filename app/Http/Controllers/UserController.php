<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.create');       
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::firstOrNew(['email' =>  $request->email]); 
        
        if($user->exists) { 
            return back()->with("success", "Email already exist!");
        }

        $user->name = $request->name;        
        $user->password = Hash::make($request->password);        
        $user->save();

       

        if(!is_null($user)) { 
            return redirect('/users')->with("success", "Successfully register!");
        }else {
            return back()->with("failed", "Registration failed. Try again.");
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::where('id',$id)->first(); 
        return view('users.edit')->with(array('users'=>$users)); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $users = User::where('id',$id)->update(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password)]); 
        if(!is_null($users)) { 
            return redirect('/users')->with("success", "Successfully updated!");
        }else {
            return back()->with("failed", "Registration failed. Try again.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::where('id',$id)->delete();
        if(!is_null($users)) { 
            return back()->with("success", "Successfully deleted!");
        }else {
            return back()->with("failed", "Deletion failed. Try again.");
        }
    }
}
