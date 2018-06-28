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
    public $apiUser;
    public function __construct(WxApiLogin $user)
    {
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $apiUser = $request->get('apiUser');
            $this->apiUser = $apiUser?$apiUser->tokenToUser:'';
            return $next( $request );
        });
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
            $nickname = $request->input('nickname');
            $faceimg = $request->input('faceimg');
            //为真就是绑定的用户或者邀请的用户
            $scene = $request->input('scene');
            if( $scene )
            {
                //绑定的用户或者邀请的用户
                $res = $this->user->userChangeType( $openid, $companyid,$nickname,$faceimg, $scene );
            }else
            {
                //登陆
                $res = $this->user->userLogin( $openid, $companyid,$nickname,$faceimg );
            }
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


    /**
     * 设置用户信息
     */
    public function setUserInfo( Request $request )
    {
        $data = $request->all();
        $data['id'] = $this->apiUser->id;
        $res = $this->user->setUserInfo($data);
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,"授权成功" );
        }else
        {
            responseData(\StatusCode::ERROR,"授权失败" );
        }
    }
}