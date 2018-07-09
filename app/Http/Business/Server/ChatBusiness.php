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
    public function getListData($userid)
    {
        $defaultFaceimg=config("jmessage.defaultfaceimg");
        //极光账号
        //$username=username($userid);
        $username= User::where(['id'=>$userid])->value("jguser");
        //检查是否有管理员账号
        if(!$username)
        {
            $newUser=$this->jmessage->userRegister($username);
            //检测是否注册成功
            if (!array_key_exists("error", $newUser["body"][0])) {
                $token=create_uuid();
                //更新user
                User::where(['id'=>$userid])->update(["jguser"=>username($userid),"token"=>$token]);
                //重置session
                Cache::put('userToken'.$userid,['token'=>$token,'type'=>1],config('session.lifetime'));
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
                if(in_array($item["username"],array_keys($listFriend)))
                {
                    $friend["body"][$k]["faceimg"]=$listFriend[$item["username"]]["faceimg"]?$listFriend[$item["username"]]["faceimg"]:$defaultFaceimg;
                }else{
                   unset($friend["body"][$k]);
                }
            }
            $list["friend"]=$friend["body"];
        }
        //用户信息
        $userShow=$this->jmessage->userShow($username);

        $list["user"]=[
            "username"=>$userShow["body"]["username"],
            "faceimg"=>array_key_exists("extras",$userShow["body"])?(array_key_exists("faceimg",$userShow["body"]["extras"])?$userShow["body"]["extras"]["faceimg"]:$defaultFaceimg):$defaultFaceimg,
            "nickname"=>array_key_exists("nickname",$userShow["body"])?$userShow["body"]["nickname"]:$userShow["body"]["username"],
            "password"=>config('jmessage.defaultpwd')
        ];

        //获取初始化配置
        $list["init"]=$this->jmessage->getJmessageInIt();
       return $list;
    }



    /***
     * 获取用户消息列表，2天的。
     * @param $username
     * @param int $count
     */
    public function getUserMessageData($username,$count=1000)
    {
        //获取用户消息列表
        $list=$this->jmessage->userGetUserMessage($username,$count);
        if(array_key_exists("error",$list["body"]))
        {
            responseData(\StatusCode::ERROR,"获取失败");
        }
        return $list["body"];
    }

}