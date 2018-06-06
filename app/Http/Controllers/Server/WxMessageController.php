<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/5
 * Time: 17:03
 */

namespace App\Http\Controllers\Server;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WxMessageController extends Controller
{


    public function messageAuthorize(Request $request){
        if( $request->method() == "GET" || $request->method() == "get" )
        {
            $echoStr = $request->input('echostr');
            if( $this->checkSignature( $request ) )
            {
                echo $echoStr;
                exit;
            }
        }else
        {
            $this->responseMsg();
        }
    }

    public function checkSignature($request)
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token = config('wxconfig.token');
        $tmpArr = array($token, $timestamp, $nonce );
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature )
        {
            return true;
        }else
        {
            return false;
        }
    }


    public function responseMsg()
    {
        $postStr = file_get_contents("php://input");
        if (!empty($postStr) && is_string($postStr)){
            $postArr = json_decode($postStr,true);
            if(!empty($postArr['MsgType']) && $postArr['MsgType'] == 'text'){   //文本消息
                $fromUsername = $postArr['FromUserName'];   //发送者openid
                $toUserName = $postArr['ToUserName'];       //小程序id
                $textTpl = array(
                    "ToUserName"=>$fromUsername,
                    "FromUserName"=>$toUserName,
                    "CreateTime"=>time(),
                    "MsgType"=>"transfer_customer_service",
                );
                exit(json_encode($textTpl));
            }elseif(!empty($postArr['MsgType']) && $postArr['MsgType'] == 'image'){ //图文消息
                $fromUsername = $postArr['FromUserName'];   //发送者openid
                $toUserName = $postArr['ToUserName'];       //小程序id
                $textTpl = array(
                    "ToUserName"=>$fromUsername,
                    "FromUserName"=>$toUserName,
                    "CreateTime"=>time(),
                    "MsgType"=>"transfer_customer_service",
                );
                exit(json_encode($textTpl));
            }else{

                echo "";
                exit;
            }
        }else{
            echo "";
            exit;
        }
    }
}