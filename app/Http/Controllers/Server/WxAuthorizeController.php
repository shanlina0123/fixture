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

class WxAuthorizeController extends WxBaseController
{
    public $wxAuthorize;
    public function __construct( WxAuthorize $wxAuthorize )
    {
        parent::__construct();
        $this->wxAuthorize = $wxAuthorize;
    }

    /**
     * @return \Illuminate\Auth\Access\Response|void
     * 授权跳转地址到二维码
     */
    public function WxAuthorize()
    {
        $user = session('userInfo');
        $data = SmallProgram::where('companyid',$user->companyid)->first();
        if( $data &&  $data->status != 1 )
        {
            return redirect()->route('user-authorize')->with('msg','您已授权成功');
        }
        $code = $this->pre_auth_code();
        if( $code )
        {
            $url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid='.$this->appid.'&pre_auth_code='.$code.'&redirect_uri='.$this->url;
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
            $pre_auth_code = Cache::get('pre_auth_code');

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
        $code = $request->input('auth_code');
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
                //用户信息
                $info = $this->wxInfo( $data['authorizer_appid'] );
                //设置小程序地址
                $setUrl = $this->setUrl( $data['authorizer_access_token']  );
                //提交代码
                $code = $this->upCode( $data['authorizer_appid'] );
                //写入数据库
                $res = $this->wxAuthorize->WxAuthorizeBack( $data, $info, $setUrl, $code );
                if( $res )
                {
                    return redirect()->route('user-authorize')->with('msg','授权成功');

                }else
                {
                    return redirect()->route('user-authorize')->with('msg','授权回调写入失败');
                }
            }else
            {
                return redirect()->route('user-authorize')->with('msg','授权回调失败');
            }
        }else
        {
            return redirect()->route('user-authorize')->with('msg','授权回调失败');
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


    /**
     * 上传代码
     * $appid 授权用户的appid
     */
    public function upCode( $appid )
    {
        $url = 'https://api.weixin.qq.com/wxa/commit?access_token='.$this->component_access_token;
        $ext_json['extAppid'] = $this->appid;
        $ext_json['ext'] = ['appid'=> $appid ];
        $post['template_id'] = 0; //模板id
        $post['ext_json'] = json_encode($ext_json,JSON_FORCE_OBJECT);
        $post['user_version'] = 'v1.0';
        $post['user_desc'] = '云易装';
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