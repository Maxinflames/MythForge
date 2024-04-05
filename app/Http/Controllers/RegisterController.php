<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function index()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::has('active_user')){
            return redirect('/');
        }
        else{
            return view('auth.register');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create()
    {
        $this->validate(request(), [
            'user_name' => 'required|string|unique:user|max:50',
            'user_first_name' => 'required|string|max:50',
            'user_last_name' => 'required|string|max:50',
            'user_email_address' =>'required|string|email|unique:user|max:255',
            'user_password' => 'required|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
        ]);

        $userId = User::insertGetId([
            'user_name' => request('user_name'),
            'user_first_name' => request('user_first_name'),
            'user_last_name' => request('user_last_name'),
            'user_email_address' => request('user_email_address'),
            'user_password' => bcrypt(request('user_password')),
        ]);

        $user = User::where('user_id', $userId)->get();

        session()->put('active_user', 'true');
        session()->put('user_id', $user[0]->user_id);
        session()->put('user_name', $user[0]->user_name);
        session()->put('first_name', $user[0]->user_first_name);
        session()->put('last_name', $user[0]->user_last_name);
        session()->put('email', $user[0]->user_email_address);

        return redirect('/');
    }
}
