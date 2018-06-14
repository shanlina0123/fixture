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
            $this->logResult('/error.log','解密后失败：'.$errCode);
            echo "false";
        }
    }

    public function logResult( $path, $data )
    {
        file_put_contents($path, '['.date('Y-m-d :h:i:s',time()).']'.$data."\r\n",FILE_APPEND);
    }


    /**
     * 消息与事件接收URL
     */
    public function message( $appid )
    {
        // 每个授权小程序传来的加密消息
        $postStr = file_get_contents("php://input");
        if (!empty($postStr))
        {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $toUserName = trim($postObj->ToUserName);
            $encrypt = trim($postObj->Encrypt);
            $format = "<xml><ToUserName><![CDATA[{$toUserName}]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
            $from_xml = sprintf($format, $encrypt);
            $inputs = array(
                'encrypt_type' => '',
                'timestamp' => '',
                'nonce' => '',
                'msg_signature' => '',
                'signature' => ''
            );
            foreach ($inputs as $key => $value) {
                $tmp = $_REQUEST[$key];
                if (!empty($tmp)){
                    $inputs[$key] = $tmp;
                }
            }

            // 第三方收到公众号平台发送的消息
            $msg = '';
            $timeStamp = $inputs['timestamp'];
            $msg_sign = $inputs['msg_signature'];
            $nonce = $inputs['nonce'];
            $token = config('wxconfig.token');
            $encodingAesKey = config('wxconfig.encodingAesKey');
            //$appid = config('wxconfig.appId');

            $pc = new \WXBizMsgCrypt($token, $encodingAesKey, $appid);
            $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
            Log::error($errCode);
            if ($errCode == 0) {
                $msgObj = simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA);
                $content = trim($msgObj->Content);
                Log::error(trim($msgObj->ToUserName));
                //第三方平台全网发布检测普通文本消息测试
                if (strtolower($msgObj->MsgType) == 'text' && $content == 'TESTCOMPONENT_MSG_TYPE_TEXT')
                {

                    $toUsername = trim($msgObj->ToUserName);
                    if ($toUsername == 'gh_3c884a361561') {
                        $content = 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
                        Log::error('110');
                        echo $this->responseText($msgObj, $content);

                    }
                }
                //第三方平台全网发布检测返回api文本消息测试
                if (strpos($content, 'QUERY_AUTH_CODE') !== false)
                {
                    $toUsername = trim($msgObj->ToUserName);
                    if ($toUsername == 'gh_3c884a361561') {
                        $query_auth_code = str_replace('QUERY_AUTH_CODE:', '', $content);
                        $authorizer_access_token = (new WxAuthorize())->getAccessToken();
                        $content = "{$query_auth_code}_from_api";
                        Log::error('222');
                        echo $this->sendServiceText($msgObj, $content, $authorizer_access_token);

                    }
                }
                //代码审核
                if (strtolower($msgObj->MsgType) == 'weapp_audit_success' )
                {
                    $sourcecode = 1;
                    $msg = '审核通过';
                    $res = $this->wxAuthorize->wxExamine($appid,$sourcecode,$msg);
                    if( $res )  echo 'success';
                }

                if (strtolower($msgObj->MsgType) == 'weapp_audit_fail' )
                {
                    $sourcecode = 0;
                    $msg = $msgObj->Reason;
                    $res = $this->wxAuthorize->wxExamine($appid,$sourcecode,$msg);
                    if( $res )  echo 'success';
                }
            }
        }
        echo "success";
    }

    /**
     * 自动回复文本
     */
    public function responseText($object = '', $content = '')
    {
        if (!isset($content) || empty($content)){
            return "";
        }
        $xmlTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    /**
     * 发送文本消息
     */
    public function sendServiceText($object = '', $content = '', $access_token = '')
    {
        /* 获得openId值 */
        $openid = (string)$object->FromUserName;
        $post_data = array(
            'touser'    => $openid,
            'msgtype'   => 'text',
            'text'      => array(
                'content'   => $content
            )
        );
        $this->sendMessages($post_data, $access_token);
    }

    /**
     * 发送消息-客服消息
     */
    public function sendMessages($post_data = array(), $access_token = '')
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        $this->httpRequest($url, 'POST', json_encode($post_data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * CURL请求
     * @param $url 请求url地址
     * @param $method 请求方法 get post
     * @param null $postfields post数据数组
     * @param array $headers 请求header信息
     * @param bool|false $debug  调试开启 默认false
     * @return mixed
     */
    public function httpRequest($url, $method="GET", $postfields = null, $headers = array(), $debug = false) {
        $method = strtoupper($method);
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
        curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case "POST":
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
                }
                break;
            default:
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
                break;
        }
        $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
        curl_setopt($ci, CURLOPT_URL, $url);
        if($ssl){
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
        }
        //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
            echo "=====info===== \r\n";
            print_r($requestinfo);
            echo "=====response=====\r\n";
            print_r($response);
        }
        curl_close($ci);
        return $response;
        //return array($http_code, $response,$requestinfo);
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