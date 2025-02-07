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

    public function userProfile()
    {
        $this->hasOne(UserProfile::class, 'user_profile_id', 'id');
    }
}
