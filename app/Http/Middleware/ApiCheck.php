<?php

namespace App\Http\Middleware;
use App\Http\Model\User\UserToken;
use Closure;
use Illuminate\Support\Facades\Cache;

class ApiCheck
{
    public function handle($request, Closure $next)
    {
        $Authorization = $request->header('Authorization');
        if( Cache::has( $Authorization ) )
        {
            $user = Cache::get($Authorization);
            $request->attributes->add(['apiUser'=>$user]);//添加api用户信息
        }else
        {

            $res = UserToken::where('token',$Authorization)->with('tokenToUser')->first();
            if( $res )
            {
                $request->attributes->add(['apiUser'=>$res]);//添加api用户信息
                if( $res->expiration <= time() )
                {
                    responseData(\StatusCode::TOKEN_OVERDUE,"token失效");
                }
                Cache::put($res->tokenToUser->token,$res,config('configure.sCache'));
            }else
            {
                responseData(\StatusCode::REQUEST_ERROR,"非法请求");
            }
        }
        return $next($request);
    }
}
