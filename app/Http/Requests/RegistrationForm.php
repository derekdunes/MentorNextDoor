<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\User;

use App\Mail\Welcome;

use Auth;   

class RegistrationForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ];
    }

    public function persist(){

        //create and save the user
        $user = User::create($this->only(['name','email','password']));

        //sign in the user
        auth::login($user);

        //welcome new user via mail
        //Mail::to($user)->send(new Email($user));

    }
}
