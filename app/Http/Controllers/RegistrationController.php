<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\User;

// use App\Mail\welcome;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\RegistrationForm;


class RegistrationController extends Controller
{
    
    public function create(){

    	return view('registration.create');
    	
    }

    public function store(RegistrationForm $Form){
 
    	//validate the form

    	$this->validate(request(), [
    		'name' => 'required',
    		'email' => 'required|email',
    		'password' => 'required|confirmed'
    	]);


		
		//check if user Email exist in the database
		$user = User::where('email', '=', request('email'));

		if(isset($user)){

			return back()->withErrors([

                'message' => 'Email already exist in our database. Try login'

        	]);

		}else {
			//create and save the user
			$user = new User;

			$user->name = request('name');
			$user->email = request('email');
			$user->password = bcrypt(request('password'));
			$user->save();

			//sign in the user
			//auth::login($user);

			if(isset($user) && count($user) == 1){
            	$credentials = $request->only('email','password');
            }

            if(Auth::attempt($credentials)){
				
				session()->flash('message', 'Thanks so much for signing up!');
                return redirect()->home();
            }
	
			//welcome new user via mail
			//\Mail::to($user)->send(new Email($user));
	
			//Redirect to the home page
	
			//$Form->persist();
		
			return redirect()->home();

		}
    	


    }

}    