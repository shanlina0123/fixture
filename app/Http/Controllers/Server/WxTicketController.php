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

class WxTicketController extends ServerBaseController
{
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
            $xml = new \DOMDocument();
            $xml->loadXML($msg);
            $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
            $component_verify_ticket = $array_e->item(0)->nodeValue;
            Cache::put('ticket',$component_verify_ticket);
            file_put_contents('/ticket.log', $component_verify_ticket);
            $this->logResult('/msgmsg.log','解密后的component_verify_ticket是：'.$component_verify_ticket);
            echo 'success';

        } else
        {
            $this->logResult('/error.log','解密后失败：'.$errCode);
            print($errCode . "\n");
        }
    }

    public function logResult( $path, $data )
    {
        file_put_contents($path, '['.date('Y-m-d :h:i:s',time()).']'.$data."\r\n",FILE_APPEND);
    }
}