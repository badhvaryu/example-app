<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validation
        $attributes = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email'     => ['required', 'email'],
            'password'  => ['required', Password::min(6), 'confirmed'] // PW is required, min 5 chars and confirm pw should match with given pw
        ]);

//        dd($attributes);

        // Create the user
        $user = User::create($attributes);

        // Log in
        Auth::login($user);

        // Redirect
        return redirect('/jobs');
    }
}
