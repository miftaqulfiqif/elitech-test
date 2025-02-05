<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserArchive extends Model
{
    protected $table = "user_archives";
    protected $fillable = [
        'user_id',
        'content_id',
    ];
}
