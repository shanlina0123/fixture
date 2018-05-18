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
    public $wx;
    public function __construct( WxAuthorize $wx )
    {
        $this->wx = $wx;
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
        $code = $this->wx->preAuthCode();
        if( $code )
        {
            $url = $this->wx->QRCodeUrl( $code );
            return redirect($url);

        }else
        {
            return redirect()->back()->with('msg','调取微信平台失败');
        }
    }


    /**
     * @param Request $request
     * 授权回调
     */
    public function WxAuthorizeBack( Request $request )
    {
        $code = $request->input('auth_code');
        $res = $this->wx->WxAuthorizeBack( $code );
        if( $res )
        {
            return redirect()->route('user-authorize')->with('msg','授权成功');

        }else
        {
            return redirect()->route('user-authorize')->with('msg','授权回调写入失败');
        }
    }


    public function getCategory( $token )
    {
        $a = $this->wx->getWxUserCategory($token);
        dd( $a );
    }

}