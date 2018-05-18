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



}