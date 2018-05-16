<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:20
 */
namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class WxAuthorizeController extends ServerBaseController
{
    public $appid;
    public $secret;
    public $component_access_token;
    public function __construct()
    {
        $this->appid = config('wxconfig.appId');
        $this->secret = config('wxconfig.secret');
        $this->url = config('wxconfig.url');
        $this->component_access_token = $this->getAccessToken();
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
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据呢
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataObj));
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }

    /**
     * @return \Illuminate\Auth\Access\Response|void
     * 授权跳转地址到二维码
     */
    public function WxAuthorize()
    {
        $code = $this->pre_auth_code();
        if( $code )
        {
            $url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component\_appid='.$this->appid.'&pre\_auth\_code='.$code.'&redirect\_uri='.$this->url.'&auth\_type=2';
            return redirect($url);

        }else
        {
            return redirect()->back()->with('msg','调取微信平台失败');
        }
    }


    /**
     * @return string
     * 换取code
     */
    public function pre_auth_code()
    {
        if( Cache::has('pre_auth_code') )
        {
            $pre_auth_code = Cache::put('pre_auth_code');

        }else
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token='.$this->component_access_token;
            $post['component_appid'] = $this->appid;
            $data = $this->CurlPost( $url, $post );
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'pre_auth_code') )
                {
                    Cache::put('pre_auth_code',$data['pre_auth_code'],$data['expires_in']/60);
                    $pre_auth_code = $data['pre_auth_code'];

                }else
                {
                    $pre_auth_code = '';
                }
            }else
            {
                $pre_auth_code = '';
            }
        }
        return $pre_auth_code;
    }


    /**
     * @param Request $request
     * 授权回调
     */
    public function WxAuthorizeBack( Request $request )
    {
        $code = $request->input('code');
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token='.$this->component_access_token;
        $post['component_appid'] = $this->appid;
        $post['authorization_code'] = $code;
        $data = $this->CurlPost( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'authorization_info') )
            {
                $data = $data['authorization_info'];
                try{
                    $companyID = session('userInfo')->companyid;
                    $wx = SmallProgram::where(['companyid'=>$companyID,'authorizer_appid'=>$data['authorizer_appid']])->first();
                    if( !$wx )
                    {
                        $wx = new SmallProgram();
                    }
                    $wx->companyid = $companyID;
                    $wx->authorization_info = json_encode($data);
                    $wx->authorizer_appid = $data['authorizer_appid'];
                    $wx->authorizer_access_token = $data['authorizer_access_token'];
                    $wx->expires_in = $data['expires_in'];
                    $wx->authorizer_refresh_token = $data['authorizer_refresh_token'];
                    $wx->func_info = json_encode($data['func_info']);
                    //用户信息
                    $info = $this->wxInfo( $data['authorizer_appid'] );
                    if( $info )
                    {
                        $wx->authorizer_info = json_encode($info);
                        $wx->nick_name =  $info['nick_name'];
                        $wx->head_img =  $info['head_img'];
                        $wx->verify_type_info =  $info['verify_type_info']['id'];
                        $wx->user_name =  $info['user_name'];
                        $wx->principal_name = $info['principal_name'];
                    }
                    //设置小程序地址
                    $setUrl = $this->setUrl();
                    $wx->seturl = $setUrl?1:0;
                    if( $wx->save() )
                    {
                        return redirect()->route('user/authorize');
                    }

                    return redirect()->back()->with('msg','授权回调写入失败');

                }catch ( Exception $e )
                {
                    return redirect()->back()->with('msg','授权回调写入失败');
                }

            }else
            {
                return redirect()->back()->with('msg','授权回调失败');
            }
        }else
        {
            return redirect()->back()->with('msg','授权回调失败');
        }
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
     * 设置小程序地址
     */
    public function setUrl( $acctoken )
    {
        $url = 'https://api.weixin.qq.com/wxa/modify_domain?access_token='.$acctoken;
        $post['action'] = 'set';
        $post['requestdomain'] = config('wxconfig.requestdomain');
        $post['wsrequestdomain'] = config('wxconfig.wsrequestdomain');
        $post['uploaddomain'] = config('wxconfig.uploaddomain');
        $post['downloaddomain'] = config('wxconfig.downloaddomain');
        $data = $this->CurlPost( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( $data['errcode'] == 0 )
            {
                return true;
            }
            return false;
        }
        return false;
    }

}