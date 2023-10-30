<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{

    use HasFactory;

    protected $fillable
        = [
            'id',
            'api_url',
            'status',
            'type',
            'created_at',
            'deleted_at',
            'token_id',
            'network_id'
        ];

}
