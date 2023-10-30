<?php

namespace App\Providers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route
     * configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });

        RateLimiter::for('minute', function (Request $request) {
            $user = User::find(
                Token::where('token', $request->header('User-Token'))
                    ->first()
                    ->value('user_id')
            );

            $count = match ($user->is_paid) {
                1 => 100,
                0 => 3,
            };

            return Limit::perMinute($count)->by($request->header('User-Token'));
        });

        RateLimiter::for('day', function (Request $request) {
            $user = User::find(
                Token::where('token', $request->header('User-Token'))
                    ->first()
                    ->value('user_id')
            );
            if ($user->is_paid === 0) {
                return Limit::perDay(50)->by($request->header('User-Token'));
            }
        });

        RateLimiter::for('day', function (Request $request) {
            $user = $request->header('User-Token');
            //            return Limit::perDay(50)->by($request->header('User-Token'));
        });


        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/')
                ->group(base_path('routes/auth.php'));

            Route::middleware('api')
                ->prefix('api/')
                ->group(base_path('routes/V1/network.php'));


            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

}
