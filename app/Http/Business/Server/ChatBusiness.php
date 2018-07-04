<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\JmessageBusiness;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;

class ChatBusiness extends ServerBase
{

    public $jmessage;
    public function __construct()
    {
        $this->jmessage =  new JmessageBusiness();
    }


    /***
     * 获取用户信息+好友列表
     */
    public function getListData($userid,$faceimg,$jguser)
    {
        Cache::put('userToken'.$userid,['token'=>create_uuid(),'type'=>1],config('session.lifetime'));
        $defaultFaceimg=e(pix_asset('server/images/default.png'));
        //极光账号
        $username=username($userid);
        //检查是否有管理员账号
        if(!$jguser)
        {
            echo 1;
            $newUser=$this->jmessage->userRegister($username);
            //检测是否注册成功
            if (!array_key_exists("error", $newUser["body"][0])) {
                //更新user
                User::where(['id'=>$userid])->update(["jguser"=>username($userid)]);
                //重置session
                Cache::put('userToken'.$userid,['token'=>create_uuid(),'type'=>1],config('session.lifetime'));
            }
            $list["friend"]=[];
        }else{
            //好友列表
            $friend=$this->jmessage->friendListAll($username);
            $friendUsers=array_column($friend["body"],"username",null);
            $listFriend=User::whereIn("jguser",$friendUsers)->select("jguser","faceimg")->get()->toArray();
            $listFriend=$listFriend?array_column($listFriend,null,"jguser"):"";
            foreach($friend["body"] as $k=>$item)
            {
                $friend["body"][$k]["faceimg"]=$listFriend?$listFriend[$item["username"]]["faceimg"]:$defaultFaceimg;
            }
            $list["friend"]=$friend["body"];
        }
        //用户信息
        $userShow=$this->jmessage->userShow($username);
        $list["user"]=["username"=>$userShow["body"]["username"],"faceimg"=>$faceimg?$faceimg:$defaultFaceimg,"nickname"=>$userShow["body"]["nickname"]];
       return $list;
    }




}