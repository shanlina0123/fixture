<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:20
 */
namespace App\Http\Controllers\Server;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Controllers\Common\WxBaseController;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WxTicketController extends WxBaseController
{

    public $wxAuthorize;

    /**
     * WxTicketController constructor.
     * @param WxAuthorize $wxAuthorize
     *
     */
    public function __construct( WxAuthorize $wxAuthorize )
    {
        $this->wxAuthorize = $wxAuthorize;
    }


    /**
     * @param Request $request
     * 微信每隔10分钟强求一次
     */
    public function verifyTicket( Request $request )
    {
        //配置
        $encodingAesKey = config('wxconfig.encodingAesKey');
        $token = config('wxconfig.token');
        $appId = config('wxconfig.appId');

        $data = $request->all();
        $timeStamp    = $data['timestamp'];
        $nonce        = $data['nonce'];
        $msg_sign     = $data['msg_signature'];
        $encryptMsg   = file_get_contents('php://input');

        $pc = new \WXBizMsgCrypt( $token, $encodingAesKey, $appId );
        $xml_tree = new \DOMDocument();
        $xml_tree->loadXML($encryptMsg);
        $array_e = $xml_tree->getElementsByTagName('Encrypt');
        $encrypt = $array_e->item(0)->nodeValue;

        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $from_xml = sprintf($format, $encrypt);

        // 第三方收到公众号平台发送的消息
        $msg = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        if ($errCode == 0)
        {
            $xml = new \DOMDocument();
            $xml->loadXML($msg);
            $array_type = $xml->getElementsByTagName('InfoType');
            $InfoType = $array_type->item(0)->nodeValue;
            switch ( $InfoType )
            {
                case 'authorized':
                    break;
                case 'component_verify_ticket': //请求ticket
                    $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
                    $component_verify_ticket = $array_e->item(0)->nodeValue;
                    file_put_contents(storage_path('ticket/ticket.txt'),$component_verify_ticket);
                    break;
                case 'unauthorized':   //取消授权
                    $array_appid = $xml->getElementsByTagName('AuthorizerAppid');
                    $authorizer_appid = $array_appid->item(0)->nodeValue;
                    SmallProgram::where('authorizer_appid',$authorizer_appid)->update(['status'=>1]);
                    break;
                case 'updateauthorized'://跟新授权
                    $array_code = $xml->getElementsByTagName('AuthorizationCode');
                    $code = $array_code->item(0)->nodeValue;
                    $this->upWxAuthorize( $code );
                    break;
            }
            exit("success");
        } else
        {
            exit("fail");
        }
    }
    /**
     * 消息与事件接收URL
     */
    public function message( Request $request,$appid )
    {
        // 每个授权小程序传来的加密消息

        /**
         * xml参数
         */
        $postStr = file_get_contents("php://input");
        if (!empty($postStr))
        {
            $encodingAesKey = config('wxconfig.encodingAesKey');
            $token = config('wxconfig.token');
            $appId = config('wxconfig.appId');

            //接收的参数
            $data = $request->all();
            $timeStamp    = $data['timestamp'];
            $nonce        = $data['nonce'];
            $msg_sign     = $data['msg_signature'];
            $encrypt_type = $data['encrypt_type'];

            //解密
            $pc = new \WXBizMsgCrypt( $token, $encodingAesKey, $appId );
            $msg = '';
            $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $postStr, $msg);
            Log::error('======errCode======'.$errCode);
            if ($errCode == 0)
            {
                $data = $this->xmlToArr( $msg );
                $fromUsername = $data['FromUserName'];
                $toUsername = $data['ToUserName'];
                $msgType = trim($data['MsgType']);
                //用户信息
                Log::error('======fromUsername======'.$fromUsername);
                Log::error('======msgType======'.$msgType);
                //默认xml数据包
                $sendtime = time();
                $sendtextTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>";
                switch($msgType)
                {
                    case 'event'://事件=
                        $event = trim($data['Event']);
                        //全网发布
                        if($toUsername == "gh_8dad206e9538")
                        {
                            $sendMsgType = "text";
                            $sendContentStr = $event."from_callback";
                            $sendResultStr = sprintf($sendtextTpl, $fromUsername, $toUsername, $sendtime, $sendMsgType, $sendContentStr);
                            $encryptMsg = $pc->encryptMsg($sendResultStr, $timeStamp, $nonce, $encryptMsg);
                            return $encryptMsg;
                        }
                        break;
                    case 'text':
                        $keyword = trim($data['Content']);
                        //文本信息
                        Log::error('======keyword ======'.$keyword);
                        //全网发布 微信模推送给第三方平台方
                        if( $toUsername == "gh_8dad206e9538" && $keyword == "TESTCOMPONENT_MSG_TYPE_TEXT" )
                        {
                            $sendMsgType = "text";
                            $sendContentStr = "TESTCOMPONENT_MSG_TYPE_TEXT_callback";
                            $sendResultStr = sprintf($sendtextTpl, $fromUsername, $toUsername, $sendtime, $sendMsgType, $sendContentStr);
                            $encryptMsg = $pc->encryptMsg($sendResultStr, $timeStamp, $nonce, $encryptMsg);
                            return $encryptMsg;
                        }
                        //全网发布
                        if($toUsername == "gh_8dad206e9538" && strpos($keyword, "QUERY_AUTH_CODE") > -1)
                        {
                            $code = str_replace("QUERY_AUTH_CODE:", "", $keyword);
                            $sendcus['content'] = $code."_from_api";
                            $accToken  = $this->getAccessToken($code);
                            if( $accToken )
                            {
                                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$accToken;
                                $curlPost['touser'] = $fromUsername;
                                $curlPost['msgtype'] = "text";
                                $curlPost['text']['content'] = $code."_from_api";
                                return wxPostCurl($url, $curlPost);
                            }
                        }
                        break;
                    case 'weapp_audit_success':
                        $sourcecode = 1;
                        $msg = '审核通过';
                        $res = $this->wxAuthorize->wxExamine($appid,$sourcecode,$msg);
                        if( $res )
                        {
                            exit("success");
                        }
                        break;
                    case 'weapp_audit_fail':
                        $sourcecode = 0;
                        $msg = $data['Reason'];
                        $res = $this->wxAuthorize->wxExamine($appid,$sourcecode,$msg);
                        if( $res )
                        {
                            exit("success");
                        }
                        break;
                }
            }

        }
        Log::error('======postr没有数据包======');
        exit("fail");
    }

    /**
     * @param $appid
     * @param $code
     * 更新授权
     */
    public function upWxAuthorize( $code )
    {
        $this->wxAuthorize->WxAuthorizeBack( $code );
    }


    /**
     * @param $xml
     * @return mixed|\SimpleXMLElement
     * 将xml解析成数组
     */
    public function xmlToArr($xml) {
        $res = @simplexml_load_string ( $xml, NULL, LIBXML_NOCDATA );
        $res = json_decode ( json_encode ( $res ), true );
        return $res;
    }


    /**
     * 换取token
     */
    public function getAccessToken( $code )
    {
        $component_access_token = $this->wxAuthorize->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token='.$component_access_token;
        $post['component_appid'] = config('wxconfig.appId');
        $post['authorization_code'] = $code;
        $data = wxPostCurl( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'authorization_info') )
            {
                $access_token = $data['authorization_info']['authorizer_access_token'];
            }else
            {
                $access_token = '';
            }
        }else
        {
            $access_token = '';
        }
        return $access_token;
    }

}