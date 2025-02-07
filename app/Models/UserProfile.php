<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $fillable = [
        'bio',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function profilePicture()
    {
        return $this->hasOne(UserPicture::class, 'user_profile_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(UserContent::class, 'user_profile_id', 'id');
    }

    public function setting()
    {
        return $this->hasOne(UserSetting::class, 'user_profile_id', 'id');
    }

    public function contentsArchive()
    {
        return $this->hasMany(UserArchive::class, 'user_profile_id', 'id');
    }
}
