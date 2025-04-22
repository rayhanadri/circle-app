<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Project;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the projects associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_projects()
    {
        return $this->hasMany(User_Project::class, 'id_user');
    }


    public function projects()
    {
        // return $this->hasMany(User_Project::class, 'id_user');
        return $this->belongsToMany(Project::class, 'user_projects', 'id_user', 'id_project')
                ->latest();
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'user_id');
    }

    public function userRoleInProject(int $id_project, int $id_user)
    {
        $user_project = User_Project::where('id_project', $id_project)->where('id_user', $id_user)->first();
        // $user_role = $user_project->user_role;

        return $user_project;
    }
}
