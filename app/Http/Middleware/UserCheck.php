<?php

namespace App\Http\Middleware;
use App\Http\Model\User\User;
use Closure;
use Illuminate\Support\Facades\Cache;

class UserCheck
{
    public function handle($request, Closure $next)
    {
        $userInfo = session('userInfo');
        if( $userInfo == false )
        {
            return redirect()->route('login');
        }
        //监听用户信息是否发生变化
         if ( Cache::has('userToken'.$userInfo['id']) )
         {
             $userToken = Cache::get('userToken'.$userInfo['id']);
             if( $userToken['type'] == 1 )
             {
                 //跟新用户信息
                 if( $userToken['token'] != $userInfo->token )
                 {
                     $where['id'] = $userInfo['id'];
                     $res = User::where($where)->first();
                     session(['userInfo'=>$res]);
                 }
             }

             if( $userToken['type'] == 2 && $userToken['token'] != $userInfo->token )
             {
                 //用户修改了重要信息需要其他用户退出
                 session(['userInfo'=>false]);
                 return redirect()->route('login');
             }
         }

        return $next($request);
    }
}
