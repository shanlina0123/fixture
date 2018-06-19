<?php

namespace App\Http\Middleware;
use App\Http\Model\Filter\FilterRoleFunction;
use Closure;
use Illuminate\Support\Facades\Cache;

class ApiAuthCheck
{
    public function handle($request, Closure $next)
    {
        $user = $request->get('apiUser');

        if( $user->userType == 0 || $user->tokenToUser->isinvitationed == 1 ) //B端用户或者参与的人
        {
            //当前访问的控制器和方法
            $current=getCurrentAction();
            $routeController = $current["controller"];//当前访问的控制器
            $routeMethod = $current["method"];//当前访问的方法
            //权限控制的控制器
            $confController=array_keys(config("apiallow"));
            //权限控制的方法
            $confUserAllow=config("apiallow.".$routeController.".user");
            $confInvitationAllow=config("apiallow.".$routeController.".invitation");
            //权限控制的视野栏目
            $confFuncid=config("apiallow.".$routeController.".funcid");//菜单id,对应表filter_function中pid=0的菜单中主键id
            //检测是否需要进行权限控制
            if(in_array($routeController,$confController))
            {

                //检测PC用户是否有权限isadminafter=1 | 检查邀请的成员是否有权限isadminafter=0
                if($user->tokenToUser->isadminafter==1)
                {
                    //非管理员
                    if($user->tokenToUser->isadmin==0)
                    {
                        //访问权限
                        if(!in_array($routeMethod,$confUserAllow))
                        {
                            responseData(\StatusCode::AUTH_ERROR,"您无权限操作");
                        }
                        //视野权限
                        $islook = FilterRoleFunction::where("roleid",$user->tokenToUser->roleid)->where("functionid",$confFuncid)->value("islook");//权限视野
                        if(!$islook)
                        {
                            responseData(\StatusCode::AUTH_ERROR,"您无权限操作");
                        }
                        $user->tokenToUser->islook = $islook;
                        $request->attributes->add(['apiUser'=>$user]);//添加api用户信息
                    }else
                    {
                        //视野权限
                        $user->tokenToUser->islook = 1;
                        $request->attributes->add(['apiUser'=>$user]);//添加api用户信息
                    }
                }else
                {
                    //邀请者，B端成员访问权限
                    if(!in_array($routeMethod,$confInvitationAllow))
                    {
                        responseData(\StatusCode::AUTH_ERROR,"您无权限操作");
                    }
                }
            }
        }
        return $next($request);
    }
}
