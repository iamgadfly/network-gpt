<?php

namespace App\Providers;

use App\Http\Controllers\V1\ChatGptController;
use App\Interfaces\V1\NetworkInterface;
use App\Services\V1\ChatGptService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(ChatGptController::class)
            ->needs(NetworkInterface::class)
            ->give(ChatGptService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }

}
