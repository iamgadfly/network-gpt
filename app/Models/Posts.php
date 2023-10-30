<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{

    use HasFactory;

    protected $fillable
        = [
            'user_id',
            'category_id',
            'title',
            'text',
            'slug',
            'image',
            'is_visible',
        ];

}
