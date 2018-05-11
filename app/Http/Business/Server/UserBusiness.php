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

class UserBusiness extends ServerBase
{

    /**
     * @param $data
     * @param $where
     * @return mixed
     * 修改手机号码
     */
     public function setPhone( $data, $where )
     {
        return User::where($where)->update( $data );
     }


     public function setPass( $data, $where )
     {
         return User::where($where)->update( $data );
     }
}