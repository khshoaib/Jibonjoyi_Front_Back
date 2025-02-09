<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    // Show the Forgot Password view
    public function forgotPassword()
    {
        return view('authentication/forgotPassword');
    }

    // Show the Sign In view
    public function signIn()
    {
        return view('authentication/signin');
    }

    // Show the Sign Up view
    public function signUp()
    {
        return view('authentication/signup');
    }

    // Show the Admin Signup view
    public function adminSignUp()
    {
        return view('authentication/adminSignUp'); // Ensure this view exists
    }
}
