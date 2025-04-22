<?php

namespace App\Http\Controllers;

use App\Models\User_Project;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user(); // Get the currently authenticated user
        $projects = $user->projects; // Get the projects associated with the user

        return view('users', ['users' => $projects]); // Pass user data to the dashboard view
    }

    public function storeUserInProject(Request $request)
    {
        $id = $request->post('user_id');
        $user_role = $request->post('user_role');
        $id_project = $request->post('project_id');

        $user_project = User_Project::create([
            'id_user' => $id,
            'id_project' => $id_project,
            'user_role' => $user_role
        ]);

        $user_project->save();

        return redirect()->back()->with('success', 'User added successfully.');
    }


    public function deleteFromProject(Request $request)
    {
        $id_user_project = $request->input('id');

        $user_project = User_Project::where('id', $id_user_project)->first();

        // Check if the user_project exists
        if ($user_project) {
            $user_project->delete();
        }

        return redirect()->back()->with('success', 'User removed successfully.');
    }


}
