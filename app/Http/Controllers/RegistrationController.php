<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\User;

// use App\Mail\welcome;

//use Auth;

use App\Http\Requests\RegistrationForm;


class RegistrationController extends Controller
{
    
    public function create(){

    	return view('registration.create');
    	
    }

    public function store(RegistrationForm $Form){
 
    	//validate the form

    	// $this->validate(request(), [
    	// 	'name' => 'required',
    	// 	'email' => 'required|email',
    	// 	'password' => 'required|confirmed'
    	// ]);

    	// //create and save the user
    	// $user = User::create(request(['name','email','password']));

    	// //sign in the user
    	// auth::login($user);

     //    //welcome new user via mail
     //    \Mail::to($user)->send(new Email($user));

    	//Redirect to the home page

        $Form->persist();

        session()->flash('message', 'Thanks so much for signing up!');

    	return redirect()->home();


    }

}    