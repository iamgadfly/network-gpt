<?php

namespace App\Services;

use App\Exceptions\PhoneException;
use App\Exceptions\UserNotFoundException;
use App\Mail\SendPasswordMail;
use App\Repositories\V1\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{

    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function login($data)
    {
        return auth()->attempt($data);
    }

    /**
     * Get the token array structure.
     *
     * @param   string  $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user(),
        ]);
    }

    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * @throws PhoneException
     */
    public function register($data)
    {
        if (isset($data['phone_number'])) {
            if ($this->userRepository->checkPhone($data['phone_number'])
                === false
            ) {
                throw new PhoneException;
            }
        }

        return $this->userRepository->create(
            array_merge(
                $data,
                ['password' => bcrypt($data['password'])]
            )
        );
    }

    public function changePassword($user_id, $password): bool
    {
        try {
            DB::beginTransaction();
            $this->userRepository->update(
                $user_id
            );
            DB::commit();
        } catch (\Exception $e) {
        }

        return true;
    }

    /**
     * @param   string  $email
     *
     * @throws \App\Exceptions\UserNotFoundException
     */
    public function forgotPassword(string $email)
    {
        $user = $this->userRepository->whereFirst(['email' => $email]);
        if (empty($user)) {
            throw new UserNotFoundException;
        }
        $password = Str::random(8);
        $user->password = bcrypt($password);
        $user->save();

        //        send / queue
        return Mail::to($user->email)->send(
            new SendPasswordMail($user, $password)
        );
    }

}
