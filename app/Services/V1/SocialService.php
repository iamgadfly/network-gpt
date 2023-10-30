<?php

namespace App\Services\V1;

use App\Models\User;
use App\Repositories\V1\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Illuminate\Support\Str;

class SocialService
{

    public function __construct(
        protected AuthService $authService,
        protected UserRepository $repository,
    ) {
    }

    public function registerOrLoginUser($data)
    {
        $u = $this->repository->firstOrCreate([
            'email' => $data->email,
        ], [
            'name'               => $data->name,
            'password'           => bcrypt(Str::random(8)),
            'is_register_social' => true,
        ]);

        $u->update(['name' => $data->name]);

        return $this->authService->createNewToken(
            Auth::login($u)
        );
    }

}
