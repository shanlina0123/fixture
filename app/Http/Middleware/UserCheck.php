<?php

namespace App\Http\Middleware;
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

         //获取菜单+重置session
        if($userInfo["isadmin"]==0)
        {
            $this->getMenue();
        }
        return $next($request);
    }


    /***
     * 获取权限菜单
     */
    protected function  getMenue()
    {
        //获取菜单重置session
        $admin_user= session('userInfo');
        $roleid=$admin_user["roleid"];
        //角色的权限
        $roleFunc= FilterRoleFunction::where("roleid",$roleid)->get();
        $funcids=array_pluck($roleFunc,"functionid");
        $admin_user["funcids"]=$funcids;
        //菜单权限
        $menueList=$authControler = FilterFunction::select("id","menuname","url","pid","level")->whereIn("id", $funcids)->where("status",1)->where("ismenu",1)->get();
        $menueArray=list_to_tree($menueList->toArray(),"id","pid","_child",0);
        $admin_user["menue"]=$menueArray;

        //控制器视野权限
        $functionLook=array_column($roleFunc->toArray(),"islook","functionid");
        $admin_user["islook"]=max($functionLook);

        //重置session
        session(['userInfo'=>$admin_user]);
    }
}
