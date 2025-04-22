<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $register_key_submitted = $request->input('register_key');
        $register_key_env = env('REGISTER_KEY');

        if ($register_key_submitted !== $register_key_env) {
            return back()->withErrors([
                'register_key' => 'Register key is invalid.',
            ])->withInput($request->only('register_key'));
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
        }

        // Auth::login($user);

        return redirect('/login')->with('success', 'Registration successful. You can now log in.');
    }
}
