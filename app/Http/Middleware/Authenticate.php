<?php

namespace App\Http\Middleware;

use Crypt;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if(! $request->cookie('token')) \request()->headers->set('Authorization', 'Bearer '.$_COOKIE['token']);
        return \JWTAuth::parseToken()->authenticate();
    }


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('auth.login');
        }
    }
}
