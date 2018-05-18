<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 11:26
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class WxAuthorize extends ServerBase
{

    /**
     * @param $data
     * @param $info
     * @param $setUrl
     * @param $code
     * @return bool
     * 授权回调
     */
    public function WxAuthorizeBack( $data, $info, $setUrl, $code )
    {
        try{
            $wx = SmallProgram::where(['authorizer_appid'=>$data['authorizer_appid']])->first();
            if( !$wx )
            {
                $companyID = session('userInfo')->companyid;
                $wx = new SmallProgram();
                $wx->companyid = $companyID;
            }
            $wx->authorization_info = json_encode($data);
            $wx->authorizer_appid = $data['authorizer_appid'];
            $wx->authorizer_access_token = $data['authorizer_access_token'];
            $wx->expires_in = time()+(int)$data['expires_in'];
            $wx->authorizer_refresh_token = $data['authorizer_refresh_token'];
            $wx->func_info = json_encode($data['func_info']);
            $wx->status = 0;
            //用户信息
            if( $info )
            {
                $wx->authorizer_info = json_encode($info);
                $wx->nick_name =  $info['nick_name'];
                $wx->head_img = array_has($info,'head_img')?$info['head_img']:'';
                $wx->qrcode_url = array_has($info,'qrcode_url')?$info['qrcode_url']:'';
                $wx->verify_type_info =  $info['verify_type_info']['id'];
                $wx->user_name =  $info['user_name'];
                $wx->principal_name = $info['principal_name'];
            }
            //设置小程序地址
            if ( $setUrl !='' )
            {
                $wx->seturl = $setUrl?1:0;
            }
            //提交代码
            if( $code != '' )
            {
                $wx->iscode = $code?1:0;
            }
            if( $wx->save() )
            {
                return true;
            }
            return false;
        }catch ( Exception $e )
        {
            return false;
        }
    }


    /**
     * @param $appid
     * @param $refresh_token
     * @return bool
     * 刷新最新的token
     */
    public function refreshUserToken( $appid, $refresh_token )
    {
        $componentAccessToken = $this->componentAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token='.$componentAccessToken;
        $post['component_appid'] = config('wxconfig.appId');
        $post['authorizer_appid'] = $appid;
        $post['authorizer_refresh_token'] = $refresh_token;
        $data = wxPostCurl( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'authorizer_access_token') )
            {
                //更新数据库
                $res = SmallProgram::where('authorizer_appid',$appid)->first();
                $res->authorizer_access_token = $data['authorizer_access_token'];
                $res->authorizer_refresh_token = $data['authorizer_refresh_token'];
                $res->expires_in = time()+(int)$data['expires_in'];
                $res->save();
                $authorizer_access_token = $data['authorizer_access_token'];

            }else
            {
                $authorizer_access_token = false;
            }
        }else
        {
            $authorizer_access_token = false;
        }
        return $authorizer_access_token;
    }


    /**
     * 获取用户最新的accesstokne
     * $appID appid
     * $conmpanyID 公司id
     */
    public function getUserAccessToken( $appID=null, $conmpanyID=null )
    {
        //appid 查询
        if( $appID )
        {
            $where['authorizer_appid'] = $appID;
        }
        //公司id查询
        if( $conmpanyID )
        {
            $where['companyid'] = $conmpanyID;
        }
        if( empty($where) )
        {
            return false;
        }
        $res = SmallProgram::where($where)->select('authorizer_appid','expires_in','authorizer_refresh_token','authorizer_access_token')->first();
        if( $res )
        {
            if( $res->expires_in <= time() )
            {
                //刷新token
                return $this->refreshUserToken( $res->authorizer_appid,$res->authorizer_refresh_token );
            }
            return $res->authorizer_access_token;
        }
        return false;
    }

    /**
     * @return string
     * 获取token
     */
    public function componentAccessToken()
    {
        if( Cache::has('component_access_token') )
        {
            $access_token = Cache::get('component_access_token');

        }else
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
            $post['component_appid'] = config('wxconfig.appId');
            $post['component_appsecret'] = config('wxconfig.secret');
            $post['component_verify_ticket'] = Cache::get('ticket');
            $data = wxPostCurl( $url, $post );
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
}