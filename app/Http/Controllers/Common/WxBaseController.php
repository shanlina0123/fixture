<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 14:24
 */

namespace App\Http\Controllers\Common;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class WxBaseController extends Controller
{
    public $appid;
    public $secret;
    public $component_access_token;

    public function __construct( $isToken=true )
    {
        $this->appid = config('wxconfig.appId');
        $this->secret = config('wxconfig.secret');
        $this->url = config('wxconfig.url');
        //为真就去请求全局token
        if( $isToken )
        {
            $this->component_access_token = $this->getAccessToken();
        }
    }


    /**
     * @return string
     * 获取token
     */
    public function getAccessToken()
    {
        if( Cache::has('component_access_token') )
        {
            $access_token = Cache::get('component_access_token');

        }else
        {

            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
            $post['component_appid'] = $this->appid;
            $post['component_appsecret'] = $this->secret;
            $post['component_verify_ticket'] = Cache::get('ticket');
            $data = $this->CurlPost( $url, $post );
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'component_access_token') )
                {
                    Cache::put('component_access_token',$data['component_access_token'],$data['expires_in']/60);
                    $access_token = $data['component_access_token'];
                }else
                {
                    $access_token = '';
                }
            }else
            {
                $access_token = '';
            }
        }
        return $access_token;
    }


    /**
     * @param $url
     * @param $dataObj
     * @return mixed|string
     * 发送请求
     */
    public function CurlPost( $url, $dataObj )
    {
        return wxPostCurl( $url, $dataObj );
    }
}