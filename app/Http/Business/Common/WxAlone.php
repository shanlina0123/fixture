<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 14:22
 */

namespace App\Http\Business\Common;


use App\Http\Model\Wx\SmallProgram;
use Illuminate\Support\Facades\Cache;

class WxAlone
{


    /**
     * @param $appid
     * @param $code
     * @return bool
     * 获取openid
     */
    public function getOpenid( $appid, $code )
    {
        $res = SmallProgram::where(['authorizer_appid'=>$appid])->first();
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$res->authorizer_appid.'&secret='.$res->authorizer_appid_secret.'&js_code='.$code.'&grant_type=authorization_code';
        $data = getCurl($url,0);
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'openid') )
            {
                $res['companyid'] = $res->companyid;
                $res['openid'] = $data['openid'];
                return $res;
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }
    }


    /**
     * @return string
     * 获取全局token
     */
    public function getAccessToken( $companyid )
    {
        if( Cache::has('access_token').$companyid )
        {
            $access_token = Cache::get('access_token'.$companyid);

        }else
        {

            $res = SmallProgram::where(['companyid'=>$companyid])->first();
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$res->authorizer_appid_secret.'&secret='.$res->authorizer_appid_secret;
            $data = getCurl($url,0);
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'access_token') )
                {
                    Cache::put('access_token'.$companyid,$data['access_token'],$data['expires_in']/60);
                    $access_token = $data['access_token'];
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