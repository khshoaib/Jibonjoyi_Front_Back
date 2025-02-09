<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminPanel;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function handleSignup(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:admin_panel,Email',
            'password' => 'required|min:8',
        ]);

        try {
            AdminPanel::create([
                'Role' => 'user',
                'Username' => $request->username,
                'Email' => $request->email,
                'Password' => Hash::make($request->password),
            ]);

            return redirect('https://jibonjoyi.ridgebenit.com/')->with('success', 'Account created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating account. Please try again.');
        }
    }

    public function showAdminSignupForm()
    {
        return view('authentication.admin_signup');
    }

    public function handleAdminSignup(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:admin_panel,Email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,moderator', // Ensure the role is either 'admin' or 'moderator'
        ]);

        try {
            // Save the admin or moderator to the admin_panel table
            AdminPanel::create([
                'Role' => $request->role, // Store the selected role
                'Username' => $request->username,
                'Email' => $request->email,
                'Password' => Hash::make($request->password), // Hash the password for security
            ]);

            // Redirect based on the selected role
            if ($request->role === 'admin') {
                return redirect()->route('stories.create')->with('success', 'Admin account created successfully.');
            } elseif ($request->role === 'moderator') {
                return redirect()->route('stories.create')->with('success', 'Moderator account created successfully.');
            }

            return redirect()->route('index')->with('success', 'Account created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the account. Please try again.');
        }
    }

    public function handleSignin(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user exists in the admin_panel table
        $admin = AdminPanel::where('Email', $request->email)->first();

        // Verify the password
        if ($admin && Hash::check($request->password, $admin->Password)) {
            // Manually set the session for authentication
            session(['admin_id' => $admin->id, 'role' => $admin->Role, 'username' => $admin->Username]);

            // Check the role and redirect accordingly
            if ($admin->Role === 'admin' || $admin->Role === 'moderator') {
                return redirect()->route('stories.create')->with('success', 'Signed in successfully.');
            } else {
                return redirect()->route('index')->with('success', 'Signed in successfully.');
            }
        }

        // If sign-in fails, return to the sign-in page with an error message
        return back()->withErrors(['Invalid email or password.'])->withInput();
    }
    public function logout()
    {
        session()->flush(); // Clear session data
        return redirect()->route('signin')->with('success', 'Logged out successfully.');
    }
}
