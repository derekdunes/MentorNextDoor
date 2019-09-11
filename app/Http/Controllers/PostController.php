<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use auth;
use Carbon\Carbon;

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
        //

        $posts = Post::latest()
        	->filter(request(['month', 'year']))
        	->get();

        return view('post.index', compact('posts'));
    }

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
    public function store(Request $request)
    {
        //create a new post using the request data
        // $post = new Post;

        // $post->title = request('title');
        
        // $post->body = request('body');

        // //save it to the database
        // $post->save();

        $this->validate(request(), [

            'title' => 'required',
            'body' => 'required'
        
        ]);

        auth()->user()->publish(new Post(request(['title', 'body'])));

        // Post::create([
        //     'title' => request('title'),
        //     'body' => request('body'),
        //     'user_id' => auth()->id()
        // ]);

        session()->flash('message', 'Your post has now been published');

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
    public function edit($id)
    {
        //
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
        //
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
    }
}
