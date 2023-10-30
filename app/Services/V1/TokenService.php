<?php

namespace App\Services\V1;


use App\Http\Resources\V1\TokensCollection;
use App\Http\Resources\V1\TokensResourceCollection;
use App\Repositories\V1\TokenRepository;
use Illuminate\Support\Str;

class TokenService
{

    public function __construct(
        protected TokenRepository $tokenRepository,
    ) {
    }

    public function createToken($expires_at)
    {
        return $this->tokenRepository->create(
            [
                'expires_at' => $expires_at,
                'user_id'    => auth()->id(),
                'token'      => Str::random(113),
            ]
        );
    }

    public function getTokens($user_id): TokensCollection
    {
        return new TokensCollection(
            $this->tokenRepository->whereGet(['user_id' => $user_id])
        );
    }

}
