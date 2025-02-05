<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContent extends Model
{
    protected $table = "user_contents";
    protected $fillable = [
        'id_data_user',
        'caption',
        'file_path',
    ];
}
