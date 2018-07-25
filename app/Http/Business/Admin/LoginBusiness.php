<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Admin;

use App\Http\Business\Common\AdminBase;
use App\Http\Model\Admin\User\User;
use Illuminate\Support\Facades\Cache;

class LoginBusiness extends AdminBase
{

    public function __construct()
    {
       parent::__construct();
    }

    /**
     * @param $data
     * 验证登陆
     */
    public function login($where)
    {
        $obj = new \stdClass();
        $where['password'] = optimizedSaltPwd($where['password'], config('configure.admin_salt'));
        $res = User::where($where)->first();
        if ($res) {
            if ($res->status != 1) {
                $obj->status = 0;
                $obj->msg = '账号已被禁用';
                return $obj;
            }
            session(['adminInfo' => $res]);
            $obj->status = 1;
            $obj->msg = '登陆成功';
            return $obj;
        } else {
            $obj->status = 0;
            $obj->msg = '账号密码不正确';
            return $obj;
        }
    }

}