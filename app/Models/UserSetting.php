<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = "user_settings";
    protected $fillable = [
        'user_profile_id',
        'feed_row_count',
    ];
}
