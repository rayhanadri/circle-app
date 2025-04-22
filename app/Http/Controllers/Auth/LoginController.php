<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login'); // make sure this view exists
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the login form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $loginUser = User::where('email', $request->email)->first();
        // var_dump($loginUser);

        if ($loginUser->member_status != "active") {
            return back()->withErrors([
                'email' => 'Your account is not active. Please contact admin.',
            ])->withInput($request->only('email'));
        }

        //remember
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Attempt to log in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // or wherever
        }

        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
