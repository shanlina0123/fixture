<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:20
 */
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\WxAuthorize;
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
        parent::__construct( false );
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
                    $array_appid = $xml->getElementsByTagName('AuthorizerAppid');
                    $appid = $array_appid->item(0)->nodeValue;
                    $array_code = $xml->getElementsByTagName('AuthorizationCode');
                    $code = $array_code->item(0)->nodeValue;
                    $this->upWxAuthorize( $appid, $code );
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


    public function message()
    {
        Log::error('111111111111');
        echo 'success';
    }

    /**
     * 小程序信息
     */
    public function wxInfo( $authorizer_appid )
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token='.$this->component_access_token;
        $post['component_appid'] = $this->appid;
        $post['authorizer_appid'] = $authorizer_appid;
        $data = $this->CurlPost( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( !array_has( $data,'authorizer_info') )
            {
                $data = false;
            }
            return $data['authorizer_info'];
        }
        return false;
    }

    /**
     * @param $appid
     * @param $code
     * 更新授权
     */
    public function upWxAuthorize( $appid, $code )
    {
        $component_access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token='.$component_access_token;
        $post['component_appid'] = $this->appid;
        $post['authorization_code'] = $code;
        $data = $this->CurlPost( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'authorization_info') )
            {
                $data = $data['authorization_info'];
                $info = $this->wxInfo( $appid );
                $this->wxAuthorize->WxAuthorizeBack( $data, $info, '', '' );
            }
        }
    }



}