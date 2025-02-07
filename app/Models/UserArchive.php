<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserArchive extends Model
{
    protected $table = "user_archives";
    protected $fillable = [
        'user_profile_id',
        'thumbnail',
        'content_id',
    ];

    public function content()
    {
        return $this->belongsTo(UserContent::class, 'content_id', 'id');
    }
}
