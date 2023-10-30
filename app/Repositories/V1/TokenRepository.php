<?php

namespace App\Repositories\V1;


use App\Models\Token;
use App\Repositories\Repository;
use Carbon\Carbon;

class TokenRepository extends Repository
{

    public function __construct(Token $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $token
     *
     * @return int
     */
    public function checkToken($token)
    {
        return $this->model::where('token', $token)->where(
            'expires_at',
            '>',
            Carbon::today()->format('Y-m-d')
        )->first();
    }

    public function getUserByToken(string $token)
    {
        return $this->model::where('token', $token)->first()->user;
    }

    public function getTokenByHash(string $hash)
    {
        return $this->model::where('token', $hash)->first();
    }

}
