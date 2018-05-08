<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 10:39
 */
namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
class BusinessServerRegiste extends ServerBase
{
    /**
     * @param $request
     * @return bool
     * 保存用户
     */
     public function userSave( $data )
     {
        /* $code = Cache::get('tel_'.$data['phone']);
         if( $data['code'] != $code )
         {
             return false;
         }*/
         $res = new User();
         $res->uuid = create_uuid();
         $res->phone = $data['phone'];
         $res->username = 'yyz_'.substr($data['phone'],7,4);
         $res->password = optimizedSaltPwd($data['password'],config('configure.salt'));
         $res->isadmin = 1;
         $res->isadminafter = 1;
         $res->type = 0;
         $res->status = 1;
         if( $res->save() )
         {
             return true;
         }else
         {
             return false;
         }
     }
}