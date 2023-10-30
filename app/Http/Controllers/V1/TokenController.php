<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTokenRequest;
use App\Services\V1\TokenService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{

    public function __construct(
        protected TokenService $tokenService,
    ) {
    }

    /**
     * @param   \App\Http\Requests\CreateTokenRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Создание токена
     * @lrd:end*
     */
    public function createToken(CreateTokenRequest $request): JsonResponse
    {
        return $this->success(
            $this->tokenService->createToken(
                $request->validated()['expires_at'] ?? null
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Получение токенов авторизованного пользователя
     * @lrd:end*
     */
    public function getTokens(): JsonResponse
    {
        return $this->success(
            $this->tokenService->getTokens(auth()->id()),
            Response::HTTP_OK
        );
    }

}

