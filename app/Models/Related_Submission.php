<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Related_Submission extends Model
{
    protected $table = 'related_submissions';
    protected $fillable = ['submissions_id', 'related_submissions_id'];

    public $timestamps = false;

}
