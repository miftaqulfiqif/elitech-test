<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPicture extends Model
{
    protected $table = "user_pictures";
    protected $fillable = [
        'user_profile_id',
        'file_path'
    ];
}
