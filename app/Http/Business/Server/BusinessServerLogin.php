<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\User\User;

class BusinessServerLogin extends ServerBase
{

    /**
     * @param $data
     * 验证登陆
     */
    public function checkUser( $where )
    {

         $obj = new \stdClass();
         $where['password'] = optimizedSaltPwd($where['password'],config('configure.salt'));
         $where['type'] = 0;
         $where['isinvitationed'] = 0;
         $where['isadminafter'] = 1;
         $res = User::where($where)->first();
         $res->islook=0;
         if( $res )
         {
             if( $res->status !=1 )
             {
                 $obj->status = 0;
                 $obj->msg = '账号已被禁用';
                 return $obj;
             }
             session(['userInfo'=>$res]);
             $obj->status = 1;
             $obj->msg = '登陆成功';
             return  $obj;
         }else
         {
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
    public function checkUserPhone( $where )
    {
        $obj = new \stdClass();
        $where['type'] = 0;
        $where['isinvitationed'] = 0;
        $where['isadminafter'] = 1;
        $res = User::where($where)->first();
        if( $res )
        {
            if( $res->status !=1 )
            {
                $obj->status = 0;
                $obj->msg = '账号已被禁用';
                return $obj;
            }
            session(['userInfo'=>$res]);
            $obj->status = 1;
            $obj->msg = '登陆成功';
            return  $obj;
        }else
        {
            $obj->status = 0;
            $obj->msg = '账号密码不正确';
            return $obj;
        }
    }
}