<?php

namespace App\Http\Middleware;
use App\Http\Model\Company\Company;
use App\Http\Model\Filter\FilterFunction;
use App\Http\Model\Filter\FilterRoleFunction;
use App\Http\Model\User\User;
use App\Model\Roles\RoleFunction;
use Closure;
use Illuminate\Support\Facades\Cache;

class UserCheck
{
    public function handle($request, Closure $next)
    {
        $userInfo = session('userInfo');
        if( $userInfo == false  )
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
                     $res->islook=$userInfo["islook"];
                     session('userInfo',$res);
                 }
             }

             if( $userToken['type'] == 2 && $userToken['token'] != $userInfo->token )
             {
                 //用户修改了重要信息需要其他用户退出
                 session('userInfo',false);
                 session(['userInfo' => false,"menueInfo"=>false]);
                 Cache::forget('userToken'.$userInfo['id']);
                 Cache::tags(["Admin-RoleAuth","Admin-Menue"])->flush();
                 return redirect()->route('login');
             }

         }

        //vip版本-不要放登录处理器
        $userInfo= session("userInfo");
        $userInfo["vipmechanismid"]=$this->getVipType($userInfo->companyid);
        session('userInfo',$userInfo);

        return $next($request);
    }



    /***
     * 获取VIP版本
     * @param $admin_user
     * @param string $tag
     * @return mixed
     */
    protected function getVipType($companyid,$tag="Admin-VipType")
    {
        $tagKey = base64_encode(mosaic("", $tag, $companyid));
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($companyid) {
            return Company::where("id",$companyid)->value("vipmechanismid");
        });

    }

}
