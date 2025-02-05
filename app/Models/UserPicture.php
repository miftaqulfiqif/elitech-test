<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPicture extends Model
{
    protected $table = "user_pictures";
    protected $fillable = [
        'file_path'
    ];
}
