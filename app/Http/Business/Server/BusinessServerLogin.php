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
    public function checkUser( $data )
    {
         $username = $data['username'];
         $where['phone'] = $username;
         $where['password'] = optimizedSaltPwd($data['password'],config('configure.salt'));
         $where['isblankout'] = 1;
         $res = User::where($where)->select('id','uuid','companyid','storeid','cityid','phone','nickname','resume','faceimg','isadmin')->first();
         if( $res )
         {
             session(['userInfo'=>$res]);
             return  $res;
         }else
         {
             return false;
         }
    }
}