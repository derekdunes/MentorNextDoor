<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Post;
use Config;
use File;
use auth;
use DB;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){

    	$this->middleware('auth')->except(['index', 'show']);
    
    }

    public function index()
    {
        $posts = Post::latest()
        	->filter(request(['month', 'year']))
            ->get();
            
        $headPost = Post::latest()->get();

        return view('post.index', compact('posts', 'headPost'));
    }

    // public function edit(Post $post)
    // {
    //     $posts = Post::latest()
    //         ->filter(request(['month', 'year']))
    //         ->get();

    //     return view('post.index', compact('post','posts'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //create a new post using the request data
        // $post = new Post;

        // $post->title = request('title');
        
        // $post->body = request('body');

        // //save it to the database
        // $post->save();

        $this->validate(request(), [

            'title' => 'required|min:5',
            'body' => 'required'
        
        ]);

        //if validation passes
        $image = Input::file('image');

        $filename = $image->getClientOriginalName();

        $filename = pathinfo($filename, PATHINFO_FILENAME);

        //in production check if url/image file name already exist
        //make url friendly
        $fullname = Str::slug(Str::random(8).$filename) . '.' . $image->getClientOriginalExtension();

        //upload image to upload folder then make a thumbnail from the upload image
        $upload = $image->move(Config::get('image.upload_folder'), $fullname);

        if($upload){
            $post = new Post;

            $title = $req->title;
            $body = $req->body;
            $image = $fullname;
            $description = $req->description;

            if ($title)
                $post->title = $title;
            
            if ($body)
                $post->body = $body;

            if ($image)
                $post->image = $image;

            if ($description)
                $post->description = $description;

           auth()->user()->publish($post); 

            // Post::create([
            //     'title' => request('title'),
            //     'body' => request('body'),
            //     'user_id' => auth()->id()
            // ]);

            session()->flash('message', 'Your post has now been published');

        } else {
            session()->flash('message', 'Your image was not updated successfully');

            return back();
        }

        // And then redirect to the home page
        return redirect('/');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post)
    {
        //
        $post = Post::find($post);

            $posts = Post::latest()
            ->filter(request(['month', 'year']))
            ->get();

        return view('post.edit', compact('post','posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $post)
    {

        // create a new post using the request data
        // $post = new Post;

        // $post->title = request('title');
        
        // $post->body = request('body');

        // //save it to the database
        // $post->save();

        $post = Post::find($post);

        if ($req->hasFile('image')) {
        //if validation passes
        $image = Input::file('image');

        $filename = $image->getClientOriginalName();

        $filename = pathinfo($filename, PATHINFO_FILENAME);

        //in production check if url/image file name already exist
        //make url friendly
        $fullname = Str::slug(Str::random(8).$filename) . '.' . $image->getClientOriginalExtension();

        //upload image to upload folder then make a thumbnail from the upload image
        $upload = $image->move(Config::get('image.upload_folder'), $fullname);
        
        if ($upload) {

            $title = $req->title;
            $body = $req->body;
            $image = $fullname;
            $description = $req->description;

            if ($title)
                $post->title = $title;
            
            if ($body)
                $post->body = $body;

            if ($image)
                $post->image = $image;

            if ($description)
                $post->description = $description;

            auth()->user()->publish($post);

            // Post::create([
            //     'title' => request('title'),
            //     'body' => request('body'),
            //     'user_id' => auth()->id()
            // ]);

            session()->flash('message', 'Your post has been Updated');    
        } else {

            $title = $req->title;
            $body = $req->body;
            $description = $req->description;

            if ($title)
                $post->title = $title;
            
            if ($body)
                $post->body = $body;

            if ($description)
                $post->description = $description;

            auth()->user()->publish($post);

            // Post::create([
            //     'title' => request('title'),
            //     'body' => request('body'),
            //     'user_id' => auth()->id()
            // ]);

            session()->flash('message', 'Your post has been Updated without any Image');    
        }

    }else {
        $title = $req->title;
        $body = $req->body;
        $description = $req->description;

        if ($title)
            $post->title = $title;
        
        if ($body)
            $post->body = $body;

        if ($description)
            $post->description = $description;

        auth()->user()->publish($post); 
    }

        // And then redirect to the home page
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Post::delete($id);

        session()->flash('message', 'Your post has been deleted');

        // And then redirect to the home page
        return redirect('/');
    }
}
