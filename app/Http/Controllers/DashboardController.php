<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user(); // Get the currently authenticated user
        $projects = $user->projects; // Get the projects associated with the user

        return view('dashboard', ['user' => $user, 'projects' => $projects]); // Pass user data to the dashboard view
    }
}
