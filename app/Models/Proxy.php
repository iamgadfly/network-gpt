<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{

    use HasFactory;

    protected $fillable
        = [
            'id',
            'login',
            'password',
            'ip',
            'expires_at',
            'is_active',
        ];

    public function api_keys()
    {
        return $this->belongsToMany(
            ApiKey::class,
            'api_proxy_relations',
            'api_key_id',
        );
    }

}
