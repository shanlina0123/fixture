<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:10
 */
namespace App\Http\Business\Common;
use App\Http\Model\User\User;
use App\Http\Model\User\UserToken;
use Illuminate\Support\Facades\Cache;
class WxApiLogin
{
    /**
     * @param $openid
     * openid登陆
     */
    public function userLogin( $openid, $companyid,$nickname,$faceimg )
    {
        if( !$openid || !$companyid )
        {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        $res = User::where(['wechatopenid'=>$openid,'companyid'=>$companyid])->first();
        if( $res )
        {
            //直接登陆
            if( $res->status != 1 )
            {
                responseData(\StatusCode::ERROR,"用户被锁定");
            }

            $uToken = UserToken::where('userid',$res->id)->first();
            if( $uToken )
            {
                Cache::forget($uToken->token);
                $uToken->token = str_random(60);
                $uToken->expiration = time()+604800;//7天
                $uToken->save();
            }else
            {
                $uToken = new UserToken();
                $uToken->uuid = create_uuid();
                $uToken->token = str_random(60);
                $uToken->expiration = time()+604800;//7天
                $uToken->userid = $res->id;
                $uToken->save();
            }
            $res->Authorization = $uToken->token;
            $res->expiration = $uToken->expiration;
            return $res;
        }else
        {
            //注册成c端客户
            $user = new User();
            $user->uuid = create_uuid();
            $user->companyid = $companyid;
            $user->wechatopenid = $openid;
            $user->isadmin = 0;
            $user->isadminafter = 0;
            $user->type = 1;
            $user->status = 1;
            $user->nickname = $nickname;
            $user->faceimg = $faceimg;
            if( $user->save() )
            {
                $uToken = new UserToken();
                $uToken->uuid = create_uuid();
                $uToken->token = str_random(60);
                $uToken->expiration = time()+604800;//7天
                $uToken->userid = $user->id;
                $uToken->type = $user->type;
                if( $uToken->save() )
                {
                    $user->Authorization = $uToken->token;
                    $user->expiration = $uToken->expiration;
                    return $user;
                }
            }
            responseData(\StatusCode::ERROR,"登陆失败");
        }
    }

    /**
     * 获取openid
     */
    public function Openid( $appID, $code )
    {
        $wx = new WxAuthorize();
        return $wx->getOpenid( $appID, $code );
    }


    /**
     * @param $data
     * 修改用户昵称
     */
    public function setUserInfo( $data )
    {
        $res = User::where('id',$data['id'])->first();
        if ($res)
        {
            $res->nickname = $data['nickname'];
            $res->faceimg = $data['faceimg'];
            return $res->save();
        }

        return false;
    }
}