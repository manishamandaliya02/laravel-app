<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Events\UserRegisterPostEvent;
use Auth;

class PostController extends Controller
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
        $posts = Post::all(); 
        $userId = 0;
        $users = array();
        if(Auth::guard('user')->check()){
        $userId = Auth::guard('user')->user()->id;
        $users = User::where('id', '!=', $userId)->get();
        }
        return view('posts.index')->with(array('posts'=>$posts,'users'=>$users,'userId'=>$userId));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::guard('user')->user()->id;

        $file = $request->file('image');

        $imageName = time().'.'.$file->extension();  
     
        $request->image->move(public_path('images'), $imageName);

        $post = new Post();
        $post->name = $request->name;        
        $post->description = $request->description;        
        $post->image = $imageName;        
        $post->date = $request->date;             
        $post->createBy = $userId;             
        $post->accessUser = json_encode(array());             
        $post->save();
        
        $users = User::where('id', '!=', $userId)->get();

        event(new UserRegisterPostEvent($users));       

        if(!is_null($post)) { 
            return redirect('/posts')->with("success", "Successfully added post!");
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
        $posts = Post::where('id',$id)->first(); 
        return view('posts.edit')->with(array('posts'=>$posts)); 
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
        $posts = Post::where('id',$id)->first(); 

        $file = $request->file('image');
        if(isset($file)){
            $imageName = time().'.'.$file->extension();  
        
            $request->image->move(public_path('images'), $imageName);
        }else{
            $imageName = $posts->image;
        }

        $posts = Post::where('id',$id)->update(['name'=>$request->name,'description'=>$request->description,'image'=>$imageName,'date'=>$request->date]); 
        if(!is_null($posts)) { 
            return redirect('/posts')->with("success", "Successfully updated!");
        }else {
            return back()->with("failed", "Registration failed. Try again.");
        }
    }


    public function share(Request $request){
        $posts = Post::where('id',$request->postid)->update(['accessUser'=>$request->users]); 
        if(!is_null($posts)) { 
            return back()->with("success", "Successfully updated!");
        }else {
            return back()->with("failed", "Registration failed. Try again.");
        }
    }

        
}
