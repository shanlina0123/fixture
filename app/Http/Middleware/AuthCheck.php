<?php

namespace App\Http\Middleware;
use Closure;
class AuthCheck
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
