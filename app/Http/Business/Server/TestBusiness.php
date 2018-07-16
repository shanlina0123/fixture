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
use Illuminate\Support\Facades\Cache;
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
        //$jmessage = new JmessageBusiness();


        Cache::flush();

//        //所有用户
//        $b = $jmessage->userGetalllist(100, 0);
//        print_r($b);
//        //上传
//        $c = $jmessage->resourceUpload("file", "http://local.fixture.com/default/server/images/topLogo.png");
//        print_r($c);

        //注册
//        $registerData=["39"=>"管理员"];
//        foreach($registerData as $k=>$v)
//        {
//            $d = $jmessage->userRegister(username($k),null,$v);
//            if (array_key_exists("error", $d["body"][0])) {
//                echo $d["body"][0]["username"] . " 注册失败\r\n";
//            } else {
//                echo $d["body"][0]["username"] . " 注册成功\r\n";
//            }
//        }
//
//        //用户信息
//      $a = $jmessage->userShow(username(8));
//        print_r($a);


        //检查用户在线状态$e["body"]["login"] /$e["body"]["onine"]
//        $e = $jmessage->userStat(username(1));
//        print_r($e);

//        //修改用户信息
//        $fd=[12,17,25,33,39,41];
//        foreach($fd as $k=>$v)
//        {
//            $f[] = $jmessage->userUpdate(username($v),["extras"=>["faceimg"=>"http://fixture.yygsoft.com/default/server/images/chatimg.jpg?v=V1.0.1.1_201807091759"]]);
//        }
//        print_r($f);
//
//        //添加好友
//        $g=$jmessage->friendAdd("jmessage_27",["abc2","abc3"]);
//        print_r($g);

//        //获取用户好友列表
//        $h=$jmessage->friendListAll("jmessage_27");
//        print_r($h);


        //删除好友
//        $i=$jmessage->friendRemove("abc1");
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