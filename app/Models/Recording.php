<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'notes',
        'transcript',
    ];
}

