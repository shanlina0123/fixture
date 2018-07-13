<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/5
 * Time: 17:03
 */

namespace App\Http\Controllers\Server;


use App\Http\Business\Server\WeChatPublicNumberBusiness;
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
            //微信消息
            $this->mpResponseMsg();
            //小程序消息
            //$this->responseMsg();
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
            switch ( $MsgType )
            {
                case 'event':
                    switch ($postObj->Event)
                    {
                        case "subscribe":
                            //处理结果
                            $wxchat = new WeChatPublicNumberBusiness();
                            $postObj->EventKey = str_replace('qrscene_','',$postObj->EventKey);
                            $res = $wxchat->mpAuthorizeBack($postObj->EventKey,$postObj->FromUserName);
                            if( $res )
                            {
                                $contentStr = '绑定成功';
                            }else
                            {
                                $contentStr = '绑定失败';
                            }
                            return $this->transmitText($postObj,$contentStr);
                            break;
                        case "SCAN":
                            //处理结果
                            $wxchat = new WeChatPublicNumberBusiness();
                            $res = $wxchat->mpAuthorizeBack($postObj->EventKey,$postObj->FromUserName);
                            if( $res )
                            {
                                $contentStr = '绑定成功';
                            }else
                            {
                                $contentStr = '绑定失败';
                            }
                            return $this->transmitText($postObj,$contentStr);
                            break;
                        default:
                            break;

                    }
                break;
            }

        }else
        {
            return '请求失败。。';
        }
    }

    /**
     * @param $postObj
     * @return mixed
     * 处理text类型
     */
    private function transmitText( $postObj,$keyword )
    {
        $time = time();
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $keyword);
        return $resultStr;
    }
}