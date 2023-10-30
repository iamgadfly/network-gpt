<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\V1\SocialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function __construct(
        protected SocialService $socialService,
    ) {
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     * @lrd:start
     * Редирект на авторизацию через гугл
     * @lrd:end*
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     * @lrd:start
     * Редирект на авторизацию через vk
     * @lrd:end*
     */
    public function redirectToVk()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     * @lrd:start
     * Редирект на авторизацию через yandex
     * @lrd:end*
     */
    public function redirectToYandex()
    {
        return Socialite::driver('yandex')->redirect();
    }


    //Google callback
    public function handleYandexCallback()
    {
        return $this->socialService->registerOrLoginUser(
            Socialite::driver('yandex')->user()
        );
    }

    //Google callback
    public function handleGoogleCallback()
    {
        return $this->socialService->registerOrLoginUser(
            Socialite::driver('google')->user()
        );
    }


    //VK callback
    public function handleVkCallback()
    {
        return $this->socialService->registerOrLoginUser(
            Socialite::driver('vkontakte')->user()
        );
    }

}
