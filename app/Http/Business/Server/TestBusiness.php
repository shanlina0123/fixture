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
use JMessage\IM\Resource;
use JMessage\JMessage;
use JMessage\IM\User;


class TestBusiness
{

    /***
     * 获取用户信息+好友列表
     */
    public function index()
    {
        //客户端
        $jmessage = new JmessageBusiness();



//        //所有用户
//        $b = $jmessage->userGetalllist(100, 0);
//        print_r($b);
//        //上传
//        $c = $jmessage->resourceUpload("file", "http://local.fixture.com/default/server/images/topLogo.png");
//        print_r($c);

        //注册
//        $registerData=["1"=>"店小二","12"=>"管理员","17"=>"管理员","25"=>"管理员","26"=>"吕瑞祥","33"=>"陈庚"];
//        foreach($registerData as $k=>$v)
//        {
//            $d = $jmessage->userRegister(username($k),null,$v);
//            if (array_key_exists("error", $d["body"][0])) {
//                echo $d["body"][0]["username"] . " 注册失败\r\n";
//            } else {
//                echo $d["body"][0]["username"] . " 注册成功\r\n";
//            }
//        }
//       die;

//
//        //用户信息
//      $a = $jmessage->userShow(username(8));
//        print_r($a);


        //检查用户在线状态$e["body"]["login"] /$e["body"]["onine"]
//        $e = $jmessage->userStat(username(1));
//        print_r($e);

       // 修改用户信息
//        $f = $jmessage->userUpdate(username(18),["nickname"=>"ddds","extras"=>["faceimg"=>"http://local.fixture.com/default/server/images/chatimg.jpg?v=20180613"]]);
//        print_r($f);
//
//        //添加好友
//        $g=$jmessage->friendAdd("jmessage_8",["jmessage_15","jmessage_16","jmessage_17","jmessage_18"]);
//        print_r($g);

//        //获取用户好友列表
//        $h=$jmessage->friendListAll("jmessage_8");
//        print_r($h);

        //删除好友
//        $i=$jmessage->friendRemove("jmessage_3",["test2","test3"]);
//        print_r($i);


        //原生上传
//        $appKey = config('jmessage.appKey');
//        $masterSecret = config('jmessage.masterSecret');
//        $jmessageClient = new JMessage($appKey, $masterSecret);//客户端
//        $jmessageResource = new  Resource($jmessageClient);//Resource 媒体资源
//        $x = $jmessageResource->upload("image", "http://local.fixture.com/default/server/images/topLogo.png");
//        print_r($x);


        //获取用户消息列表
//        $j=$jmessage->userGetUserMessage("jmessage_11",0,1000);
//        print_r($j);
    }


}