<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 10:39
 */
namespace App\Http\Business\Server;
use App\Http\Business\Common\JmessageBusiness;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BusinessServerRegiste extends ServerBase
{
    /**
     * @param $request
     * @return bool
     * 保存用户
     */
     public function userSave( $data )
     {
         $res = new User();
         $res->uuid = create_uuid();
         $res->phone = $data['phone'];
         $res->username = 'yyz_'.substr($data['phone'],7,4);
         $res->password = optimizedSaltPwd($data['password'],config('configure.salt'));
         $res->isadmin = 1;
         $res->isadminafter = 1;
         $res->type = 0;
         $res->status = 1;
         $res->roleid = 1;
         $res->nickname = "管理员";
         $res->isdefault = 1;

         if( $res->save() )
         {
             //TODO::注册极光账号
             $jmessage =  new JmessageBusiness();
             $jguser=$jmessage->userRegister(username($res->id),null,$res->nickname);
             if(!array_key_exists("error",$jguser["body"][0])){
                 User::where(['id'=>$res->id])->update(["jguser"=>username($res->id)]);
             }else{
                 return false;
                 Log::error("------极光PC管理员注册失败------".json_encode($jguser));
             }
             return true;
         }else
         {
             return false;
         }
     }
}