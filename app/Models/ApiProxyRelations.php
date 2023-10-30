<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiProxyRelations extends Model
{

    public $timestamps = false;

    use HasFactory;

    protected $fillable
        = [
            'proxy_id',
            'api_key_id',
        ];

}
