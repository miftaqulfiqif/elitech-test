<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContent extends Model
{
    protected $table = "user_contents";
    protected $fillable = [
        'user_profile_id',
        'caption',
        'file_path',
    ];
}
