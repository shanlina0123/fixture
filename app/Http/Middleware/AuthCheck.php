<?php

namespace App\Http\Middleware;
use App\Http\Model\Filter\FilterFunction;
use App\Http\Model\Filter\FilterRoleFunction;
use App\Model\Data\Functions;
use App\Model\Roles\RoleFunction;
use Closure;
use Illuminate\Support\Facades\Redirect;

class AuthCheck
{
    public function handle($request, Closure $next)
    {
        //获取当前登录用户信息
        $admin_user= $request->session()->get('userInfo');//对象

        //非管理员验证权限
        if ($admin_user->isadmin == 0) {
            //验证权限
            $flag= $this->authRole($admin_user);
            if($flag==false)
            {
                return redirect()->route('error-lock')->with('msg', '无权限');
            }
       }
        return $next($request);
    }




    /***
     * 权限验证
     * @param $roleFunids  自己具备的功能
     */
    protected function authRole($admin_user)
    {

        //当前访问的控制器和方法
        $current=getCurrentAction();
        //当前访问控制器
        $routeController = $current["controller"];
        $routeMethod = $current["method"];

        //控制非管理员不能访问管理员的默认操作
        $adminAllow=["CompanyController@companySetting","UserController@userAuthorize", 'WxAuthorizeController@upCode','WxAuthorizeController@upSourceCode','WxAuthorizeController@auditid'];
        if(in_array($routeController."@".$routeMethod,$adminAllow))
        {
            return  false;
        }

        //自己已有的功能
        $funcids=$admin_user["funcids"];

        //控制器访问权
        $authControler = FilterFunction::whereIn("id", $funcids)->where("status",1)->where("ismenu",1)->where("controller",$routeController)->get();
        if (empty($authControler->toArray())) {
            return  false;
        }

        return true;

    }
}
