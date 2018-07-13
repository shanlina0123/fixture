<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/5
 * Time: 17:03
 */

namespace App\Http\Controllers\Server;


use App\Http\Controllers\Controller;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $this->mpResponseMsg();
            $this->responseMsg();
        }
    }

    public function checkSignature($request)
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token = SmallProgram::where('token',$request->input('token'))->value('token');
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


    public function mpResponseMsg()
    {
        $postStr = file_get_contents("php://input");
        if (!empty($postStr))
        {
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $MsgType = trim($postObj->MsgType);
            Log::error('www'.json_decode($postObj));
            switch ( $MsgType )
            {
                case "subscribe":
                    if (isset($object->EventKey))
                    {
                        $contentStr = "关注二维码场景 ".$postObj->EventKey;
                        echo $contentStr;
                    }
                    break;
                case "SCAN":
                    $contentStr = "扫描 ".$postObj->EventKey;
                    echo $contentStr;
                    //要实现统计分析，则需要扫描事件写入数据库，这里可以记录 EventKey及用户OpenID，扫描时间
                    break;
                case 'event':
                    echo '欢迎关注：无聊的时候你可以直接发送消息给我，24小时陪伴你。。。'.$postObj->FromUserName;
                    break;
                case 'text':
                    $keyword = trim($postObj->Content);
                    echo '文字'.$keyword;
                    break;
            }

        }else
        {
            return '请求失败。。';
        }
    }
}