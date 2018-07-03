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
        $wx = SmallProgram::where(['authorizer_appid'=>$appid])->first();
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$wx->authorizer_appid.'&secret='.$wx->authorizer_appid_secret.'&js_code='.$code.'&grant_type=authorization_code';
        $data = getCurl($url,0);
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'openid') )
            {
                $res['companyid'] = $wx->companyid;
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
        if( Cache::get('access_token'.$companyid ) )
        {
            $access_token = Cache::get('access_token'.$companyid);
        }else
        {
            $res = SmallProgram::where(['companyid'=>$companyid])->first();
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$res->authorizer_appid.'&secret='.$res->authorizer_appid_secret;
            $data = getCurl($url,0);
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'access_token') )
                {
                    if( $data['access_token'] )
                    {
                        Cache::put('access_token'.$companyid,$data['access_token'],$data['expires_in']/60);
                    }
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


    //生成微信二维码
    public function createWxappCode($companyid,$type,$scene,$width=null)
    {
        $accessToken = $this->getAccessToken($companyid);
        if($accessToken)
        {
            $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$accessToken;
            header('content-type:image/gif');
            $postData = array();
            $postData['scene'] = $scene?$scene:"";//自定义信息，可以填写诸如识别用户身份的字段，注意用中文时的情况
            $postData['page'] = config('wxconfig.wxCode.'.$type);//扫描后对应的path
            $postData['width'] = $width?$width:800;//自定义的尺寸
            $postData['auto_color'] = false;//是否自定义颜色
//            $color = array(
//                "r"=>"221",
//                "g"=>"0",
//                "b"=>"0",
//            );
//            $postData['line_color'] = $color;//自定义的颜色值
            $postData = json_encode($postData);
            $da = get_http_array($url,$postData);
            echo json_encode($da);//echo直接在浏览器显示或者存储到服务器等其他操作
        }
        echo "";
    }

}