<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    //
    public function create()
    {
        //dd('SessionController.create');
        return view('auth.login');
    }

    public function store()
    {
        //dd(request()->all());

        // validate the user
        $attributes = request()->validate([
           'email'    => ['required', 'email'],
           'password' => ['required']
        ]);

        // attempt to login the user
        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.'
            ]);
        }

        // Succeed then regenerate the session token
        request()->session()->regenerate();

        // Redirect
        return redirect('/jobs');
    }

    public function destroy()
    {
        //dd('SessionController.destroy');
        Auth::logout();

        return redirect('/');
    }

}
