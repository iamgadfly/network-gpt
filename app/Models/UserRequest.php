<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{

    use HasFactory;

    protected $fillable
        = [
            'user_id',
            'request_id',
            'token_id',
            'network_id',
        ];

}
