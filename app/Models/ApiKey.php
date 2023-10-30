<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property mixed $url
 * @property mixed $value
 */
class ApiKey extends Model
{

    use HasFactory;


    protected $fillable
        = [
            'id',
            'name',
            'url',
            'value',
            'network_id',
            'status',
            'current_requests',
            'max_requests',
        ];

}
