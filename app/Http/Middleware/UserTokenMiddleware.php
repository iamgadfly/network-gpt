<?php

namespace App\Http\Middleware;

use App\Repositories\V1\TokenRepository;
use Closure;
use Illuminate\Http\Request;

class UserTokenMiddleware
{

    public function __construct(
        protected TokenRepository $tokenRepository,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param   \Illuminate\Http\Request                                                                           $request
     * @param   \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('User-Token');

        if (is_null($token)) {
            return response()->json(['Error' => 'token is missed'], 500);
        } elseif ($this->tokenRepository->checkToken($token) === 0) {
            return response()->json(
                [
                    'Error' => 'token mismatched',
                ],
                500
            );
        }

        return $next($request);
    }

}
