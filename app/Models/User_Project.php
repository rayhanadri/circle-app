<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User_Project extends Model
{
    protected $table = 'user_projects';
    protected $fillable = ['id_user', 'id_project', 'created_at', 'updated_at', 'user_role'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function getManager()
    {
        return $this->where('user_role', 'Manager')->first();
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function getUserRole(int $user_id): string
    {
        if ($this->id_user !== $user_id) {
            return 'No Role';
        }
        return $this->user_role;
    }
}
