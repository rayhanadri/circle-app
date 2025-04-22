<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\User_Project;
use App\Models\Submission;

class ProjectController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        // Get the projects associated with the user
        $projects = Project::all();
        $users = User::all();


        // Pass user data to the dashboard view
        return view('projects/projects', ['user' => $user, 'projects' => $projects, 'users' => $users]);
    }

    public function storeProject(Request $request)
    {
        // Validate the request data
        $name = $request->post('name');
        $description = $request->post('description');
        $fandom = $request->post('fandom');
        $project_manager = $request->post('project_manager');

        // Create a new project
        $project = Project::create([
            'name' => $name,
            'description' => $description,
            'fandom' => $fandom,
            'status' => "Open",
            'cover_bg' => "",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $project->save();

        $id = $project->id;
        $file = $request->file('file');
        if ($file) {
            $file_extension = $file->getClientOriginalExtension();
            $file->move('resources/images/projects/', $id . '_' . 'project.' . $file_extension);

            $file_path = 'resources/images/projects/' . $id . '_' . 'project.' . $file_extension;
        } else {
            $file_path = null; // Handle the case where no file is uploaded
        }

        $project->cover_bg = $file_path;
        $project->save();

        $user_project = User_Project::create([
            'id_user' => $project_manager,
            'id_project' => $id,
            'user_role' => 'Manager',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user_project->save();

        // Redirect back to the projects page with a success message
        return redirect()->back()->with('success', 'Project created successfully.');
    }

    function updateProject(Request $request)
    {
        // Validate the request data
        $id = $request->input('id');
        $name = $request->post('name');
        $description = $request->post('description');
        $fandom = $request->post('fandom');
        $status = $request->post('status');
        $manager = $request->post('manager');
        $file = $request->file('file');

        // Find the project by ID
        $project = Project::find($id);

        // Update the project details
        if ($project) {
            $project->name = $name;
            $project->description = $description;
            $project->fandom = $fandom;
            $project->status = $status;
            $project->save();
        }

        // user_projects
        $user_project = User_Project::where('id_project', $id)->where('user_role', 'Manager')->first();
        if ($user_project) {
            $user_project->user_role = "Staff";
            $user_project->save();
        }

        $new_user_project = User_Project::where('id_project', $id)->where('id_user', $manager)->first();
        if ($new_user_project) {
            $new_user_project->user_role = "Manager";
            $new_user_project->save();
        }

        if ($file) {
            // Handle file upload
            $file = $request->file('file');
            if ($file) {
                $file_extension = $file->getClientOriginalExtension();
                $file->move('resources/images/projects/', $id . '_' . 'project.' . $file_extension);

                $file_path = 'resources/images/projects/' . $id . '_' . 'project.' . $file_extension;
            } else {
                $file_path = null; // Handle the case where no file is uploaded
            }

            $project->cover_bg = $file_path;
            $project->save();
        }

        // Redirect back to the projects page with a success message
        return redirect()->back()->with('success', 'Project updated successfully.');
    }

    public function closeProject(Request $request)
    {
        // Validate the request data
        $id = $request->input('id');

        // Find the project by ID
        $project = Project::find($id);

        // Update the project details
        if ($project) {
            $project->status = "Closed";
            $project->save();
        }

        // Redirect back to the projects page with a success message
        return redirect()->back()->with('success', 'Project closed successfully.');
    }

    public function projectDetail(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        $id = $request->input('id');
        // Get the project associated with the user
        $project = Project::find($id);

        // Pass user data to the dashboard view
        return view('projects/projects_detail', ['user' => $user, 'project' => $project]);
    }

    public function projectView2(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        $id = $request->input('id');
        // Get the project associated with the user
        $project = Project::find($id);

        // Artworks
        $artworks = $project->artworks()->get();
        // Designs
        $designs = $project->designs()->get();
        // Related Submissions
        $related = $artworks;

        // User
        $user_projects = $project->user_projects()->get();


        // Pass user data to the dashboard view
        return view('projects/projects_view', ['user' => $user, 'artworks' => $artworks, 'designs' => $designs, 'user_projects' => $user_projects, 'project' => $project, 'related' => $related]);
    }

    public function projectArtwork(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        $id = $request->input('id');
        // Get the project associated with the user
        $project = Project::find($id);

        // Artworks
        $artworks = $project->artworks()->whereNot('status', 'Rejected')->get();

        // Pass user data to the dashboard view
        return view('projects/projects_artwork', ['user' => $user, 'project' => $project, 'artworks' => $artworks]);
    }

    public function projectDesign(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();


        //id project
        $id = $request->input('id');
        // Get the project associated with the user
        $project = Project::find($id);

        // Get the submissions associated with the user
        $submissions = new Submission();
        $submissions = $submissions->where('project_id', $id)->where('type', 'Design')->whereNot('status', 'Rejected')->get();


        $related = new Submission();
        $related = $related->where('project_id', $id)->where('type', 'Artwork')->with('project')->get();


        // Pass submission to the dashboard view
        return view('projects/projects_design', ['user' => $user, 'project' => $project, 'submissions' => $submissions, 'related' => $related]);
    }

    public function projectMember(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        // echo $user->id;

        //id project
        $id = $request->input('id');

        // echo $id;
        // die;
        // Get the project associated with the user
        $project = Project::find($id);


        // Get users
        $users = User::join('user_projects', 'users.id', '=', 'user_projects.id_user')
            ->join('projects', 'user_projects.id_project', '=', 'projects.id')
            ->select('users.*', 'user_projects.id as id_user_project', 'user_projects.user_role')
            ->where('projects.id', '=', $project->id)
            ->get();

        $excludedUserIds = User_Project::where('id_project', $project->id)
            ->pluck('id_user')
            // ->get()
        ;

        $users_not_member = User::whereNotIn('users.id', $excludedUserIds)
            ->get();

        // echo $user;
        // die;

        // Pass submission to the dashboard view
        return view('projects/projects_member', ['user' => $user, 'project' => $project, 'users' => $users, 'users_not_member' => $users_not_member]);
    }
}
