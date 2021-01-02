<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Post;
use App\Bits;
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
        
        ]);

        //dd($req->type);
        // dd(count($req->type));

        //if validation passes
        $image = Input::file('photo');

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
            
            
            if ($title)
                $post->title = $title;
            
            if ($image)
                $post->image = $fullname;

            if(auth())
                $post->user_id = auth()->id();

            $post->save();

            //auth()->user()->publish($post); 

            // Post::create([
            //     'title' => request('title'),
            //     'body' => request('body'),
            //     'user_id' => auth()->id()
            // ]);

           // add the array bits by looping through the contents 

           //check if type and body have thesame length
           $heads = $req->head;
           $types = $req->type;
           $images = $req->image;
           $texts = $req->text;
           $embeds = $req->embed;

           if (isset($types)) {
               
                //loop through types
                // whether the number of types of images, texts and embeds rhymes
                //keep count of number of types
                //add the types and increment the 
                $heds = 0; $imges = 0; $txts = 0; $embds = 0;
                
                for ($i=0; $i < count($types); $i++) {

                    $type = $types[$i];

                    if ($type == 0) {
                        $heds = $heds + 1;
                    }

                    if ($type == 1) {
                       $txts = $txts + 1;  
                    }

                    if ($type == 2) {
                       $imges = $imges + 1;  
                    }

                    if ($type == 3) {
                       $embds = $embds + 1;  
                    }

                    //check for last loop
                    if (count($types) - 1 == $i) {
                        
                        $headTest = false; $imgTest = false; $txtTest = false; $embedTest = false;

                        if (isset($heads) && count($heads) > 0) {
                            $headTest = $heds == count($heads);
                        }

                        if (isset($images) && count($images) > 0) {
                            $imgTest = $imges == count($images);
                        }

                        if (isset($texts) && count($texts) > 0) {
                            $txtTest = $txts == count($texts);             
                        }

                        if (isset($embeds) && count($embeds) > 0) {
                            $embedTest = $embds == count($embeds);
                        }

                        if ($headTest || $imgTest || $txtTest || $embedTest) {
                            //call function to insert the data into the database

                            $hd = 0; $im = 0; $tx = 0; $em = 0;

                            for ($i=0; $i < count($types); $i++) { 
                                
                                $type = $types[$i];

                                //0 for mini Headers
                                if ($type == 0) {
                                    $body = $heads[$hd];
                                    $hd = $hd + 1;

                                    $bit = new Bits;
                                    $bit->post_id = $post->id;
                                    $bit->body_type = $type;
                                    $bit->body = $body;
                                    $bit->save();
                                }

                                //1 for text content or 3 for embed content
                                if ($type == 1 ) {  
                                    $body = $texts[$tx];
                                    $tx = $tx + 1;

                                    $bit = new Bits;
                                    $bit->post_id = $post->id;
                                    $bit->body_type = $type;
                                    $bit->body = $body;
                                    $bit->save();
                                }

                                //1 for text content or 3 for embed content
                                if ($type == 3) {
                                    $body = $embeds[$em];
                                    $em = $em + 1;

                                    $bit = new Bits;
                                    $bit->post_id = $post->id;
                                    $bit->body_type = $type;
                                    $bit->body = $body;
                                    $bit->save();
                                }

                                //2 means image
                                if ($type == 2){
                                    $body = $images[$im];
                                    $im = $im + 1;

                                    $filename = $body->getClientOriginalName();

                                    $filename = pathinfo($filename, PATHINFO_FILENAME);

                                    //in production check if url/image file name already exist
                                    //make url friendly
                                    $fullname = Str::slug(Str::random(8).$filename) . '.' . $body->getClientOriginalExtension();

                                    //upload image to upload folder then make a thumbnail from the upload image
                                    $upload = $body->move(Config::get('image.upload_folder'), $fullname);


                                    if ($upload) {
                                        $bit = new Bits;
                                        $bit->post_id = $post->id;
                                        $bit->body_type = $type;
                                        $bit->body = $fullname;
                                        $bit->save();
                                    }

                                }

                            }

                        } else {
                            session()->flash('message', 'Your post has a mismatch, please fix');
                        }
                    }

                }

           }

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
    public function show($post)
    {
        $post = Post::with('bits')->findOrFail($post);

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
        $post = Post::with('bits')->findOrFail($post);

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

        if ($req->hasFile('photo')) {

        //if validation passes
        $image = Input::file('photo');

        $filename = $image->getClientOriginalName();

        $filename = pathinfo($filename, PATHINFO_FILENAME);

        //in production check if url/image file name already exist
        //make url friendly
        $fullname = Str::slug(Str::random(8).$filename) . '.' . $image->getClientOriginalExtension();

        //upload image to upload folder then make a thumbnail from the upload image
        $upload = $image->move(Config::get('image.upload_folder'), $fullname);
        
        if ($upload) {

            $title = $req->title;
            $image = $fullname;

            if ($title)
                $post->title = $title;
            
            if ($image)
                $post->image = $image;

            $post->save();

            // Post::create([
            //     'title' => request('title'),
            //     'body' => request('body'),
            //     'user_id' => auth()->id()
            // ]);



            session()->flash('message', 'Your post has been Updated'); 

        } else {

            $title = $req->title;

            if ($title)
                $post->title = $title;
            
            $post->save();

            // Post::create([
            //     'title' => request('title'),
            //     'body' => request('body'),
            //     'user_id' => auth()->id()
            // ]);

            session()->flash('message', 'Your post has been Updated without any Image');    
        }

    }else {

        $title = $req->title;
        
        if ($title)
            $post->title = $title;
        
       $post->save(); 
    }
           //check if type and body have thesame length
           $heads = $req->head;
           $types = $req->type;
           $images = $req->image;
           $texts = $req->text;
           $embeds = $req->embed;

           if (isset($types)) {
               
                //loop through types
                // whether the number of types of images, texts and embeds rhymes
                //keep count of number of types
                //add the types and increment the 
                $heds = 0; $imges = 0; $txts = 0; $embds = 0;
                
                for ($i=0; $i < count($types); $i++) {

                    $type = $types[$i];

                    if ($type == 0) {
                        $heds = $heds + 1;
                    }

                    if ($type == 1) {
                       $txts = $txts + 1;  
                    }

                    if ($type == 2) {
                       $imges = $imges + 1;  
                    }

                    if ($type == 3) {
                       $embds = $embds + 1;  
                    }

                    //check for last loop
                    if (count($types) - 1 == $i) {
                        
                        $headTest = false; $imgTest = false; $txtTest = false; $embedTest = false;

                        if (isset($heads) && count($heads) > 0) {
                            $headTest = $heds == count($heads);
                        }

                        if (isset($images) && count($images) > 0) {
                            $imgTest = $imges == count($images);
                        }

                        if (isset($texts) && count($texts) > 0) {
                            $txtTest = $txts == count($texts);             
                        }

                        if (isset($embeds) && count($embeds) > 0) {
                            $embedTest = $embds == count($embeds);
                        }

                        if ($headTest || $imgTest || $txtTest || $embedTest) {
                            //call function to insert the data into the database

                            $hd = 0; $im = 0; $tx = 0; $em = 0;

                            for ($i=0; $i < count($types); $i++) { 
                                
                                $type = $types[$i];

                                //0 for mini Headers
                                if ($type == 0) {
                                    $body = $heads[$hd];
                                    $hd = $hd + 1;

                                    $bit = new Bits;
                                    $bit->post_id = $post->id;
                                    $bit->body_type = $type;
                                    $bit->body = $body;
                                    $bit->save();
                                }

                                //1 for text content or 3 for embed content
                                if ($type == 1 ) {
                                    $body = $texts[$tx];
                                    $tx = $tx + 1;

                                    $bit = new Bits;
                                    $bit->post_id = $post->id;
                                    $bit->body_type = $type;
                                    $bit->body = $body;
                                    $bit->save();
                                }

                                //1 for text content or 3 for embed content
                                if ($type == 3) {
                                    $body = $embeds[$em];
                                    $em = $em + 1;

                                    $bit = new Bits;
                                    $bit->post_id = $post->id;
                                    $bit->body_type = $type;
                                    $bit->body = $body;
                                    $bit->save();
                                }

                                //2 means image
                                if ($type == 2){
                                    $body = $images[$im];
                                    $im = $im + 1;

                                    $filename = $body->getClientOriginalName();

                                    $filename = pathinfo($filename, PATHINFO_FILENAME);

                                    //in production check if url/image file name already exist
                                    //make url friendly
                                    $fullname = Str::slug(Str::random(8).$filename) . '.' . $body->getClientOriginalExtension();

                                    //upload image to upload folder then make a thumbnail from the upload image
                                    $upload = $body->move(Config::get('image.upload_folder'), $fullname);


                                    if ($upload) {
                                        $bit = new Bits;
                                        $bit->post_id = $post->id;
                                        $bit->body_type = $type;
                                        $bit->body = $fullname;
                                        $bit->save();
                                    }

                                }

                            }

                        } else {
                            session()->flash('message', 'Your post has a mismatch, please fix');
                        }
                    }

                }

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
        $post = Post::with('bits')->delete($id);

        session()->flash('message', 'Your post has been deleted');

        // And then redirect to the home page
        return redirect('/');
    }
}
