<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $fillable = [
        'nama',
        'bio',
        'user_id',
        'setting_id',
        'content_id',
        'profile_picture_id'
    ];
}
