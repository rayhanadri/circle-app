<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';
    protected $fillable = ['user_id', 'project_id', 'title', 'description', 'type', 'file', 'created_at', 'updated_at'];


    public function submissionByUser(int $user_id)
    {
        return $this->hasMany(Submission::class, 'submission_id')->where('user_id', $user_id);
    }

    public function submissionByProject(int $project_id)
    {
        return $this->hasMany(Submission::class, 'submission_id')->where('project_id', $project_id);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function related_submissions()
    {
        return $this->belongsToMany(Submission::class, 'related_submissions', 'submissions_id', 'related_submissions_id');
    }
}
