<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;

use App\Http\Business\Common\ServerBase;
use App\Http\Model\Filter\FilterFunction;
use App\Http\Model\Filter\FilterRoleFunction;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;

class BusinessServerLogin extends ServerBase
{

    /**
     * @param $data
     * 验证登陆
     */
    public function checkUser($where)
    {

        $obj = new \stdClass();
        $where['password'] = optimizedSaltPwd($where['password'], config('configure.salt'));
        $where['type'] = 0;
        $where['isinvitationed'] = 0;
        $where['isadminafter'] = 1;
        $res = User::where($where)->first();
        if ($res) {
            if ($res->status != 1) {
                $obj->status = 0;
                $obj->msg = '账号已被禁用';
                return $obj;
            }
            //菜单
            $menue=new \stdClass();
            if ($res->isadmin == 0) {
                $menueData = $this->getMenue($res);
                $menue->funcids = $menueData["funcids"];
                $menue->menue = $menueData["menue"];
                $res->islook = $menueData["islook"];
            }

            session(['userInfo' => $res,"menueInfo"=>$menue]);

            $obj->status = 1;
            $obj->msg = '登陆成功';
            return $obj;
        } else {
            $obj->status = 0;
            $obj->msg = '账号密码不正确';
            return $obj;
        }
    }

    /**
     * @param $where
     * @return \stdClass
     * 短信登陆
     */
    public function checkUserPhone($where)
    {
        $obj = new \stdClass();
        $where['type'] = 0;
        $where['isinvitationed'] = 0;
        $where['isadminafter'] = 1;
        $res = User::where($where)->first();
        if ($res) {
            if ($res->status != 1) {
                $obj->status = 0;
                $obj->msg = '账号已被禁用';
                return $obj;
            }
            //菜单
            $menue=new \stdClass();
            if ($res->isadmin == 0) {
                $menueData = $this->getMenue($res);
                $menue->funcids = $menueData["funcids"];
                $menue->menue = $menueData["menue"];
                $res->islook = $menueData["islook"];
            }
            session(['userInfo' => $res,"menueInfo"=>$menue]);

            $obj->status = 1;
            $obj->msg = '登陆成功';
            return $obj;
        } else {
            $obj->status = 0;
            $obj->msg = '账号密码不正确';
            return $obj;
        }
    }



    /***
     * 获取菜单
     */
    protected function getMenue($admin_user, $tag = "Admin-Menue")
    {
        $roleid = $admin_user->roleid;
        $tagKey = base64_encode(mosaic("", $tag, $admin_user->id));
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($admin_user, $roleid) {
            //角色的权限
            $roleFunc = FilterRoleFunction::where("roleid", $roleid)->get();
            $funcids = array_pluck($roleFunc, "functionid");
            $data["funcids"] = $funcids;
            //菜单权限
            $menueList = $authControler = FilterFunction::select("id", "menuname", "url", "pid", "level")->whereIn("id", $funcids)->where("status", 1)->where("ismenu", 1)->get();
            $menueArray = list_to_tree($menueList->toArray(), "id", "pid", "_child", 0);
            $data["menue"] = $menueArray;

            //控制器视野权限
            if (count($roleFunc->toArray()) > 0) {
                $functionLook = count($roleFunc->toArray()) > 0 ? array_column($roleFunc->toArray(), "islook", "functionid") : 0;
                $data["islook"] = max($functionLook);
            }
            return $data;
        });
    }
}