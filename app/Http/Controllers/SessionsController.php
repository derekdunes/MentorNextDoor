<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class SessionsController extends Controller
{

	public function __construct(){

		$this->middleware('guest')->except(['destroy']);

	}

    public function create(){

    	return view('sessions.create');
    	
    }

    public function store(Request $req){

        //authenticate the user
        $user = User::where('email', '=', $req->email)->orWhere('password', '=', $req->password )->get();

    	if(isset($user) && count($user) == 1){
            $credentials = $req->only('email','password');
            
            dd(Auth::attempt($credentials));

            if(Auth::attempt($credentials)){
                return redirect()->home();
            }
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
