<?php
namespace App\Http\Controllers\Store;
use App\Http\Business\Store\UserBusiness;
use App\Http\Controllers\Common\StoreBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends StoreBaseController
{

    protected $user;
    public function __construct(UserBusiness $user)
    {
        parent::__construct();
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
            $nickname = $request->input('nickname');
            $faceimg = $request->input('faceimg');
            $res = $this->user->userLogin( $openid, $nickname, $faceimg );
            responseData(\StatusCode::SUCCESS,"用户信息", $res );
        }else
        {
            responseData(\StatusCode::REQUEST_ERROR,"非法请求");
        }
    }
}