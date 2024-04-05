<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        $user = User::where('user_id', Session::get('user_id'))->first();

        return view('user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User)
    {
        session()->forget('active_campaign');
        session()->forget('player_id');

        if (Session::has('user_id')) {
            $user = User::where('user_id', Session::get('user_id'))->first();

            return view('user.edit', compact('user'));
        } else {
            return view('auth.login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::where('user_id', Session::get('user_id'))->first();

        if ($user->user_name == request('user_name') && $user->user_email_address == request('user_email_address')) {
            $this->validate(request(), [
                'user_id' => 'required|exists:user,user_id',
                'user_first_name' => 'required|string|max:50',
                'user_last_name' => 'required|string|max:50',
                'user_description' => 'nullable|string|max:255',
                'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
            ]);
        } else if ($user->user_name == request('user_name')) {
            $this->validate(request(), [
                'user_id' => 'required|exists:user,user_id',
                'user_first_name' => 'required|string|max:50',
                'user_last_name' => 'required|string|max:50',
                'user_description' => 'nullable|string|max:255',
                'user_email_address' => 'required|string|email|unique:user|max:255',
                'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
            ]);
        } else if ($user->user_email_address == request('user_email_address')) {
            $this->validate(request(), [
                'user_id' => 'required|exists:user,user_id',
                'user_name' => 'required|string|unique:user|max:50',
                'user_first_name' => 'required|string|max:50',
                'user_last_name' => 'required|string|max:50',
                'user_description' => 'nullable|string|max:255',
                'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
            ]);
        } else {
            $this->validate(request(), [
                'user_id' => 'required|exists:user,user_id',
                'user_name' => 'required|string|unique:user|max:50',
                'user_first_name' => 'required|string|max:50',
                'user_last_name' => 'required|string|max:50',
                'user_description' => 'nullable|string|max:255',
                'user_email_address' => 'required|string|email|unique:user|max:255',
                'user_password' => 'nullable|string|min:6|required_with:password_confirmation|same:password_confirmation|max:255',
            ]);
        }
        if (request('user_password') == "" || request('user_password') == null) {
            User::where('user_id', request('user_id'))->update([
                'user_name' => request('user_name'),
                'user_first_name' => request('user_first_name'),
                'user_last_name' => request('user_last_name'),
                'user_description' => request('user_description'),
                'user_email_address' => request('user_email_address'),
            ]);
        } else {
            User::where('user_id', request('user_id'))->update([
                'user_name' => request('user_name'),
                'user_first_name' => request('user_first_name'),
                'user_last_name' => request('user_last_name'),
                'user_description' => request('user_description'),
                'user_email_address' => request('user_email_address'),
                'user_password' => bcrypt(request('user_password')),
            ]);
        }
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $User)
    {
        //
    }
}
