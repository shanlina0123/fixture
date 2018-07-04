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

//        //用户信息
//        $a = $jmessage->userShow("4445");
//        print_r($a);
//        //所有用户
//        $b = $jmessage->userGetalllist(100, 0);
//        print_r($b);
//        //上传
//        $c = $jmessage->resourceUpload("file", "http://local.fixture.com/default/server/images/topLogo.png");
//        print_r($c);

        //注册
//        $d = $jmessage->userRegister(username(2));
//        if (array_key_exists("error", $d["body"][0])) {
//            echo $d["body"][0]["username"] . " 注册失败";
//        } else {
//            echo $d["body"][0]["username"] . " 注册成功";
//        }

        //检查用户在线状态$e["body"]["login"] /$e["body"]["onine"]
        $e = $jmessage->userStat(username(1));
        print_r($e);


        //原生上传
//        $appKey = config('jmessage.appKey');
//        $masterSecret = config('jmessage.masterSecret');
//        $jmessageClient = new JMessage($appKey, $masterSecret);//客户端
//        $jmessageResource = new  Resource($jmessageClient);//Resource 媒体资源
//        $x = $jmessageResource->upload("image", "http://local.fixture.com/default/server/images/topLogo.png");
//        print_r($x);
    }


}