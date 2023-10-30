<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ChatGptController;
use App\Http\Controllers\V1\TokenController;
use App\Http\Controllers\V1\RequestController;
use App\Http\Controllers\V1\ProxyController;
use App\Http\Controllers\V1\ApiKeyController;
use App\Http\Controllers\V1\PaymentController;

Route::controller(ChatGptController::class)
    ->middleware(['token', 'throttle:minute', 'throttle:day'])
    ->prefix('network/chat_gpt')
    ->group(function () {
        Route::post('/send', 'send');
    });

Route::controller(TokenController::class)
    ->middleware('auth')
    ->prefix('token')
    ->group(function () {
        Route::post('/create', 'createToken');
        Route::get('/all', 'getTokens');
    });


Route::controller(PaymentController::class)
    ->middleware(['api', 'auth'])
    ->prefix('payment')
    ->group(function () {
        Route::post('', 'createPayment');
    });


Route::controller(RequestController::class)
    ->middleware(['token'])
    ->prefix('request')
    ->group(function () {
        Route::get('/get/{id}', 'get');
    });

Route::controller(ProxyController::class)
    ->middleware(['auth', 'role:admin'])
    ->prefix('proxy')
    ->group(function () {
        Route::post('/api_key_relation', 'makeRelation');
        Route::post('/', 'store');
        Route::get('/{proxy}', 'show');
        Route::put('/{proxy}', 'update');
        Route::delete('/{proxy}', 'destroy');
    });


Route::controller(ApiKeyController::class)
    ->middleware(['auth', 'role:admin'])
    ->prefix('api_key')
    ->group(function () {
        Route::post('/', 'store');
        Route::get('/{api_key}', 'show');
        Route::put('/{api_key}', 'update');
        Route::delete('/{api_key}', 'destroy');
    });

Route::post(
    '/payment/payment_status',
    [PaymentController::class, 'status']
);







