<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:20
 */
namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WxAuthorizeController extends ServerBaseController
{
    /**
     * 微信第三方推送的
     * 每隔10分钟定时推送component_verify_ticket
     */
    /*public function verifyTicket( Request $request)
    {
        $data = $request->all();
        $timeStamp    = $data['timestamp'];
        $nonce        = $data['nonce'];
        $encrypt_type = $data['encrypt_type'];
        $msg_sign     = $data['msg_signature'];
        $encryptMsg   = file_get_contents('php://input');


        $xml = new \DOMDocument();
        $xml->loadXML($encryptMsg);
        $array_e = $xml->getElementsByTagName('Encrypt');
        $encrypt = $array_e->item(0)->nodeValue;
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $from_xml = sprintf($format, $encrypt);
        $msg = '';
        $wxCrypt = new \WXBizMsgCrypt();
        $result = $wxCrypt->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        if( $result )
        {
            $xml->loadXML($msg);
            $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
            $component_verify_ticket = $array_e->item(0)->nodeValue;
            Cache::put('verify_ticket',$component_verify_ticket);
            echo "success";
        }
    }*/

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

        $this->logResult('/form.log', $from_xml);
        // 第三方收到公众号平台发送的消息
        $msg = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        if ($errCode == 0)
        {
            //print("解密后: " . $msg . "\n");
            $xml = new \DOMDocument();
            $xml->loadXML($msg);
            $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
            $component_verify_ticket = $array_e->item(0)->nodeValue;

            file_put_contents('/ticket.log', $component_verify_ticket);
            $this->logResult('/msgmsg.log','解密后的component_verify_ticket是：'.$component_verify_ticket);
            echo 'success';

        } else
        {
            $this->logResult('/error.log','解密后失败：'.$errCode);
            print($errCode . "\n");
        }
    }

    function logResult( $path, $data )
    {
        file_put_contents($path, '['.date('Y-m-d :h:i:s',time()).']'.$data."\r\n",FILE_APPEND);
    }



}