<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Http\Request;

class CheckRoleMiddleware
{

    /**
     * @param   \Illuminate\Http\Request  $request
     * @param   \Closure                  $next
     *
     * @return mixed
     * @throws \App\Exceptions\AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        $role          = strtolower(request()->user()->role);
        $allowed_roles = array_slice(func_get_args(), 2);

        if (in_array($role, $allowed_roles)) {
            return $next($request);
        }

        throw new AuthenticationException;
    }

}
