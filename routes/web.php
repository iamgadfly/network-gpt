<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('web')->controller(SocialController::class)
    ->group(function () {
        // VK
        Route::get('/auth/vk', 'redirectToVk');
        Route::get('/auth/vk/callback', 'handleVkCallback');

        // Google
        Route::get('/auth/google', 'redirectToGoogle');
        Route::get('/auth/google/callback', 'handleGoogleCallback');


        // Yandex
        Route::get('/auth/yandex', 'redirectToYandex');
        Route::get('/auth/yandex/callback', 'handleYandexCallback');
    });
