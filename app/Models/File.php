<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable=[
        // 'name',
        'path',
        'original_name',
        'user_id',
        'type',
        'url',
        'folder_id',
        'new_name'
    ];
}
    