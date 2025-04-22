<?php

namespace App\Http\Controllers;

use App\Models\Related_Submission;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        // Get the submissions associated with the user
        $submissions = new Submission();
        $submissions = $submissions->whereIn('project_id', $user_projects)->where('type', 'Artwork')->with('project')->get();

        // Pass submission to the dashboard view
        return view('submissions/artworks', ['user' => $user, 'submissions' => $submissions]);
    }

    public function updateArtwork(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        //
        $id = $request->input('id');
        $title = $request->post('title');
        $description = $request->post('description');

        $project = $request->post('project');
        $status = $request->post('status');

        $file = $request->file('file');

        if ($file) {
            $file_extension = $file->getClientOriginalExtension();
            $file->move('resources/images/artworks/', $id . '_' . 'artwork.' . $file_extension);

            $file_path = 'resources/images/artworks/' . $id . '_' . 'artwork.' . $file_extension;
        } else {
            $file_path = null; // Handle the case where no file is uploaded
        }

        // Update the submission in the database
        $submission = Submission::where('id', $id)->first();

        if ($submission) {
            $submission->title = $title;
            $submission->description = $description;
            $submission->project_id = $project;
            if ($status) {
                $submission->status = $status;
            }
            if ($file) {
                $submission->file = $file_path;
            }
            $submission->save();
        }

        // Retrieve updated submissions
        //$submissions = Submission::where('id', $id)->where('type', 'Artwork')->with('project')->get();

        // Pass submission to the dashboard view
        return redirect()->back()->with('success', 'Artwork updated successfully.');
    }

    function storeArtwork(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        $user_id = $user->id;

        // echo $user_id;

        //
        $title = $request->post('title');
        $description = $request->post('description');

        $project = $request->post('project');

        $file = $request->file('file');


        // Store the submission in the database
        $Submission = Submission::create([
            'user_id' => $user_id,
            'project_id' => $project,
            'title' => $title,
            'description' => $description,
            'file' => "",
            'type' => 'Artwork',
            'status' => 'Pending',
        ]);

        $id = $Submission->id;
        if ($file) {
            $file_extension = $file->getClientOriginalExtension();
            $file->move('resources/images/artworks/', $id . '_' . 'artwork.' . $file_extension);

            $file_path = 'resources/images/artworks/' . $id . '_' . 'artwork.' . $file_extension;
        } else {
            $file_path = null; // Handle the case where no file is uploaded
        }

        $Submission->file = $file_path;
        $Submission->save();

        // Redirect to the submissions page
        return redirect()->back()->with('success', 'Artwork submitted successfully.');
    }

    public function submissionView(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        $id = $request->input('id');

        // Get the submission associated with the user
        $submission = new Submission();
        $submission = $submission->where('id', $id)->with('project')->first();

        // Pass submission to the dashboard view
        return view('submissions/submissions_view', ['user' => $user, 'submission' => $submission]);
    }

    public function approveSubmission(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        $id = $request->input('id');

        // Get the submission associated with the user
        $submission = new Submission();
        $submission = $submission->where('id', $id)->with('project')->first();
        $submission->status = 'Approved';
        $submission->save();

        // Pass submission to the dashboard view
        return redirect()->back()->with('success', 'Submission approved successfully.');
    }

    public function rejectSubmission(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        $id = $request->input('id');

        // Get the submission associated with the user
        $submission = new Submission();
        $submission = $submission->where('id', $id)->with('project')->first();
        $submission->status = 'Rejected';
        $submission->save();

        // Pass submission to the dashboard view
        return redirect()->back()->with('success', 'Submission rejected successfully.');
    }

    public function listDesign(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        // Get the submissions associated with the user
        $submissions = new Submission();
        $submissions = $submissions->whereIn('project_id', $user_projects)->where('type', 'Design')->with('project')->get();

        $related = new Submission();
        $related = $related->whereIn('project_id', $user_projects)->where('type', 'Artwork')->with('project')->get();

        // Pass submission to the dashboard view
        return view('submissions/designs', ['user' => $user, 'submissions' => $submissions, 'related' => $related]);
    }

    public function updateDesign(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        //
        $id = $request->input('id');
        $title = $request->post('title');
        $description = $request->post('description');

        $project = $request->post('project');
        $status = $request->post('status');

        $file = $request->file('file');

        if ($file) {
            $file_extension = $file->getClientOriginalExtension();
            $file->move('resources/images/designs/', $id . '_' . 'design.' . $file_extension);

            $file_path = 'resources/images/designs/' . $id . '_' . 'design.' . $file_extension;
        } else {
            $file_path = null; // Handle the case where no file is uploaded
        }

        // Update the submission in the database
        $submission = Submission::where('id', $id)->first();

        if ($submission) {
            $submission->title = $title;
            $submission->description = $description;
            $submission->project_id = $project;
            if ($status) {
                $submission->status = $status;
            }
            if ($file) {
                $submission->file = $file_path;
            }
            $submission->save();
        }

        // Retrieve updated submissions
        // $submissions = Submission::where('id', $id)->where('type', 'Design')->with('project')->get();

        // Pass submission to the dashboard view
        return redirect()->back()->with('success', 'Design updated successfully.');
    }

    function storeDesign(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();
        // $user_projects = $user->user_projects()->pluck('id_project')->toArray();

        $user_id = $user->id;

        // echo $user_id;

        //
        $title = $request->post('title');
        $description = $request->post('description');

        $project = $request->post('project');

        $file = $request->file('file');


        // Store the submission in the database
        $Submission = Submission::create([
            'user_id' => $user_id,
            'project_id' => $project,
            'title' => $title,
            'description' => $description,
            'file' => "",
            'type' => 'Design',
            'status' => 'Pending',
        ]);

        $id = $Submission->id;
        if ($file) {
            $file_extension = $file->getClientOriginalExtension();
            $file->move('resources/images/artworks/', $id . '_' . 'design.' . $file_extension);

            $file_path = 'resources/images/artworks/' . $id . '_' . 'design.' . $file_extension;
        } else {
            $file_path = null; // Handle the case where no file is uploaded
        }

        $Submission->file = $file_path;
        $Submission->save();

        // Related
        $related = $request->post('related');
        if ($related) {
            // $related = explode(',', $related);
            foreach ($related as $rel) {
                $related_submission = new Related_Submission();
                $related_submission->submissions_id = $id;
                $related_submission->related_submissions_id = $rel;
                $related_submission->save();
            }
        }

        // Redirect to the submissions page
        return redirect()->back()->with('success', 'Design submitted successfully.');
    }

}
