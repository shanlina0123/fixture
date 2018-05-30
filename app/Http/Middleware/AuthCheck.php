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
            $flag= $this->authRole($request,$admin_user,$admin_user["roleid"]);
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
    protected function authRole($request,$admin_user,$roleid)
    {
        //当前访问模块
        $routeController = getCurrentControllerName($request);
        //角色的权限
        $roleFunc= FilterRoleFunction::where("roleid",$roleid)->get();
        $funcids=array_pluck($roleFunc,"functionid");

        //控制器访问权
        $authControler = FilterFunction::whereIn("id", $funcids)->where("status",1)->where("ismenu",1)->where("controller",$routeController)->get();
        if (empty($authControler->toArray())) {
            return  false;
        }
        //控制器视野权限
        $functionLook=array_column($roleFunc->toArray(),"islook","functionid");
        $admin_user->islook=max($functionLook);

        //菜单权限

        //获取父类
        $menueList=$authControler = FilterFunction::select("id","menuname","url","pid","level")->whereIn("id", $funcids)->where("status",1)->where("ismenu",1)->get();
        $menueArray=list_to_tree($menueList->toArray(),"id","pid","_child",0);
        $admin_user->menue=$menueArray;

        //重置session
        session(['userInfo'=>$admin_user]);
        return true;

    }
}
