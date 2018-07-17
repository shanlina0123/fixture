<?php

namespace App\Http\Middleware;

use App\Http\Model\Filter\FilterFunction;
use App\Http\Model\Filter\FilterRoleFunction;
use App\Http\Model\Vip\ConfVipfunctionpoint;
use App\Model\Data\Functions;
use App\Model\Roles\RoleFunction;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class AuthCheck
{
    public function handle($request, Closure $next)
    {

        //获取当前登录用户信息
        $admin_user = $request->session()->get('userInfo');//对象
        $menuInfo = session('menueInfo');
        //非管理员验证权限
        if ($admin_user->isadmin == 0) {
            //验证权限
            $flag = $this->authRole($admin_user->id, $menuInfo->funcids);
            if ($flag == false) {
                return redirect()->route('error-lock')->with('msg', '无权限');
            }
        }

        //验证公司vip免费版权限
        if ($admin_user["vipmechanismid"] == 1&&config("wxtype.type")==2) {
            $vipflag = $this->authVip($admin_user->companyid);
            if ($vipflag == false) {
                return redirect()->route('vip-index')->with('msg', '无权限,请升级为标准版');
            }
        }


        return $next($request);
    }


    /***
     * 权限验证
     * @param $roleFunids  自己具备的功能
     */
    protected function authRole($userid, $funcids, $tag = "Admin-RoleAuth")
    {
        //当前访问的控制器和方法
        $current = getCurrentAction();
        //当前访问控制器
        $routeController = $current["controller"];
        $routeMethod = $current["method"];

        //控制非管理员不能访问管理员的默认操作
        $adminAllow = ["CompanyController@companySetting", "UserController@userAuthorize", 'WxAuthorizeController@upCode', 'WxAuthorizeController@upSourceCode', 'WxAuthorizeController@auditid'];
        if (in_array($routeController . "@" . $routeMethod, $adminAllow)) {
            return false;
        }

        $tagKey = base64_encode(mosaic("", $tag, $userid));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($userid, $funcids, $routeController) {
            //控制器访问权
            $authControler = FilterFunction::whereIn("id", $funcids)->where("status", 1)->where("ismenu", 1)->where("controller", $routeController)->get();
            if (empty($authControler->toArray())) {
                return false;
            }
            return true;
        });

    }

    /***
     * VIP访问权限验证--在产品后台管理系统中，给公司升级VIP版本后，需要清理redis缓存$tag = "CompanyVipAuth"
     * @param $admin_user
     * @return bool
     */
    protected function authVip($company, $tag = "Company-VipAuth")
    {
        //当前访问的控制器和方法
        $current = getCurrentAction();
        //当前访问控制器
        $routeController = $current["controller"];

        $tagKey = base64_encode(mosaic("", $tag, $routeController.$company));
        //redis缓存返回
        return Cache::tags($tagKey)->remember($tagKey, config('configure.sCache'), function () use ($company, $routeController) {
            //vip限制的控制器
            $vipData = ConfVipfunctionpoint::where("status", 1)->where("type", "has")->where("controller", $routeController)->first();
            if ($vipData) {
                //vip对限制控制器的访问限制
                if (!$vipData["value"]) {
                    return false;
                }
            }
            return true;
        });



    }
}
