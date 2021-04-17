<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','show',]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts',$posts);
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
        $this ->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image'=> 'image|nullable|max:1999' //max image size is 1999, its optional and only accepts image formats like jpeg,png,etc.
        ]);

        //File Upload Handling
        if($request->hasfile('cover_image')){
            //Getting Filename With Extention
            $filenameWithExtention=$request->file('cover_image')->getClientOriginalName();
            //Filename 
            $filename = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
            //Extension
            $ext = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $filename.'_'.time().''.$ext;
            //File Upload
            $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);

        }
        else{
            //if no image present this will be the default image
            $fileNameToStore = 'defaultimage.jpg';
        }

        //Adding the Post to database;
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //Check for user
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Cannot Edit');
        }
        return view('posts.edit')->with('post',$post);
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
        $this ->validate($request,[
            'title' => 'required',
            'body' => 'required'
        ]);

        //File Upload Handling
        if($request->hasfile('cover_image')){
            //Getting Filename With Extention
            $filenameWithExtention=$request->file('cover_image')->getClientOriginalName();
            //Filename 
            $filename = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
            //Extension
            $ext = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore = $filename.'_'.time().''.$ext;
            //File Upload
            $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);

        }

        //Adding the Post to database;
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasfile('cover_image')){
            $post->cover_image =  $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with(['success'=>'Post Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
         //Check for user
         if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Cannot Edit');
        }
        if($post->cover_image != 'defaultimage.jpg'){
            //Delete Cover Image
            Storage::delete('Public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Deleted');
    }
}
