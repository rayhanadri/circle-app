<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User_Project;
use App\Models\User;


class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['name', 'fandom', 'description', 'status', 'cover_bg', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects', 'id_project', 'id_user');
    }

    public function user_projects()
    {
        return $this->hasMany(User_Project::class, 'id_project');
    }

    public function getManager()
    {
        $user_project = $this->user_projects()->where('user_role', 'Manager')->first();
        $user_id = $user_project->id_user ?? null;
        if ($user_id) {
            return User::find($user_id);
        }
        return null;
    }


    public function userProjectRole(int $user_id)
    {

        $res = $this->user_projects()->where('id_user', $user_id)->first();
        if (!$res) {
            return '-';
        }
        return $res->user_role;
    }

    public function userJoinedProject(int $user_id)
    {
        if ($this->user_projects()->where('id_user', $user_id)->exists()) {
            return "Yes";
        }
        return "No";
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Submission::class, 'project_id')->where('type', 'artwork');
    }

    public function designs(): HasMany
    {
        return $this->hasMany(Submission::class, 'project_id')->where('type', 'design');
    }
}
