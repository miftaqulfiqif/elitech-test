<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    protected $table = 'data_users';
    protected $fillable = [
        'nama',
        'profile_picture',
        'bio',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
