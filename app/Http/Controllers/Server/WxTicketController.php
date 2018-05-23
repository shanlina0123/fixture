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
                case 'component_verify_ticket': //请求ticket
                    $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
                    $component_verify_ticket = $array_e->item(0)->nodeValue;
                    Cache::put('ticket',$component_verify_ticket,11);
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
                default:
                    echo "false"; die();
                    break;
            }
            echo 'success';
        } else
        {
            $this->logResult('/error.log','解密后失败：'.$errCode);
            echo "false";
        }
    }

    public function logResult( $path, $data )
    {
        file_put_contents($path, '['.date('Y-m-d :h:i:s',time()).']'.$data."\r\n",FILE_APPEND);
    }


    /**
     * 发布代码审核消息通知
     */
    public function message( $appid )
    {
        $postStr = file_get_contents("php://input");
        libxml_disable_entity_loader(true);
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        if( trim($postStr->MsgType) == 'event' )
        {
            $even = trim($postObj->Event);
            if( $even == 'weapp_audit_success' )
            {
                $sourcecode = 1;
                $msg = '审核通过';
            }else
            {
                $sourcecode = 0;
                $msg = trim($postObj->Reason);
            }
            $res = $this->wxAuthorize->wxExamine($appid,$sourcecode,$msg);
            if( $res )  echo 'success';
            else  echo 'fail';
        }
        echo 'fail';
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



}