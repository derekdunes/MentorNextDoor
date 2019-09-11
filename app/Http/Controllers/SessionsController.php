<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class SessionsController extends Controller
{

	public function __construct(){

		$this->middleware('guest')->except(['destroy']);

	}

    public function create(){

    	return view('sessions.create');
    	
    }

    public function store(){

    	//authenticate the user
    	if(auth()->attempt(request(['email', 'password']))){
    		  
            return redirect()->home();
		
		}

        return back()->withErrors([

                'message' => 'Please check your credentials and try again'

        ]);

		

    }

    public function destroy(){
    	
    	auth()->logout();
    	
    	return redirect()->home();

    }

}
