<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\V1\LoginResource;
use App\Http\Resources\V1\ProfileResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        protected AuthService $authService
    ) {
        $this->middleware(
            'auth:api',
            ['except' => ['login', 'register', 'forgotPassword']]
        );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Логин
     * @lrd:end*
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ( ! $token = $this->authService->login($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->authService->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Регистрация
     * @lrd:end*
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return $this->success(
            $user,
            Response::HTTP_CREATED,
            'User successfully registered'
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Выход
     * @lrd:end*
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->success(
            true,
            Response::HTTP_OK,
            'User successfully signed out'
        );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->success(new LoginResource(auth()->refresh()));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Профиль пользователя
     * @lrd:end*
     */
    public function userProfile(): JsonResponse
    {
        return $this->success(new ProfileResource(auth()->user()));
    }

    /**
     * @param   \App\Http\Requests\ChangePasswordRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Изменение пароля
     * @lrd:end*
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        return $this->success(
            $this->authService->changePassword(
                auth()->id(),
                $request->validated()['password']
            ),
            Response::HTTP_OK,
        );
    }

    /**
     *  Send new password to User.
     *
     * @return JsonResponse
     * @lrd:start
     * Восстановление пароля (новый пароль отправляется на вашу почту)
     * @lrd:end*
     */
    protected function forgotPassword(ForgotPasswordRequest $request
    ): JsonResponse {
        return $this->success(
            $this->authService->forgotPassword($request->validated()['email']),
            Response::HTTP_OK,
            'New password sent to your email!'
        );
    }


}
