<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:04
 */

namespace App\Http\Controllers\Common;
use App\Http\Business\Common\WxApiLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class WxApiLoginController extends Controller
{

    protected $user;
    public function __construct(WxApiLogin $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登陆
     */
    public function login( Request $request )
    {
        if( $request->method() === 'POST' )
        {
            $openid = $request->input('openid');
            $companyid = $request->input('companyid');
            $res = $this->user->userLogin( $openid, $companyid );
            responseData(\StatusCode::SUCCESS,"用户信息", $res );
        }else
        {
            responseData(\StatusCode::REQUEST_ERROR,"非法请求");
        }
    }

    /**
     * @param Request $request
     * 获取用户openid
     */
    public function getOpenid( Request $request  )
    {
        $appID = $request->input('appid');
        $code = $request->input('code');
        $res = $this->user->Openid( $appID, $code );
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,"请求OPENID成功", $res );
        }else
        {
            responseData(\StatusCode::ERROR,"请求OPENID失败", $res );
        }
    }
}