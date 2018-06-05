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


    /**
     *  请求
     */
    public function responseMsg()
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
                    echo '欢迎关注：无聊的时候你可以直接发送消息给我，24小时陪伴你。。。';
                    break;
                case 'text':
                    $keyword = trim($postObj->Content);
                    switch ( $keyword )
                    {
                        case 'php':
                            echo $this->getNews(12,$postObj);
                            break;
                        case 'linux':
                            echo $this->getNews(13,$postObj);
                            break;
                        case 'jquery':
                            echo $this->getNews(14,$postObj);
                            break;
                        case 'html':
                            echo $this->getNews(15,$postObj);
                            break;
                        case 'wxapplet':
                            echo $this->getNews(18,$postObj);
                            break;
                        default:
                            echo $this->returnText( $postObj,$keyword );
                            break;
                    }
                    break;
            }

        }else
        {
            return '请求失败。。';
        }
}