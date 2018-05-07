<?php

namespace App\Http\Middleware;
use Closure;
class UserCheck
{
    public function handle($request, Closure $next)
    {
        $userInfo = session('userInfo');
        if( $userInfo == false )
        {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
