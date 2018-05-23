<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:20
 */
namespace App\Http\Controllers\Server;
use App\Http\Business\Common\WxAuthorize;
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
        //判断公司信息是否完善
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('userInfo');
            if( !$userInfo->companyid && $userInfo->isadmin = 1 )
            {
                return redirect()->route('company-setting');
            }
            return $next($request);
        });
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
        $code = $this->wx->preAuthCode( $user['id'] );
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
            //清除授权码
            Cache::forget('pre_auth_code'.session('userInfo')['id']);
            return redirect()->route('user-authorize')->with('msg','授权成功');

        }else
        {
            return redirect()->route('user-authorize')->with('msg','授权回调写入失败');
        }
    }


    /**
     * @param $appid
     * @return \Illuminate\Http\RedirectResponse
     * 手动提交代码
     */
    public function upCode( $appid )
    {
        $user = session('userInfo');
        $isUploadCode = SmallProgram::where(['authorizer_appid'=>$appid,'companyid'=>$user->companyid])->first();
        if( $isUploadCode )
        {
            if( $isUploadCode->uploadcode == 1 )
            {
                return redirect()->route('user-authorize')->with('msg','代码已提交不能重复提交');
            }
            $res = $this->wx->upCode( $appid );
            if( $res )
            {
                return redirect()->route('user-authorize')->with('msg','代码提交成功');
            }
            return redirect()->route('user-authorize')->with('msg','代码提交失败');

        }else
        {
            return redirect()->back()->with('msg','地址不存在');
        }
    }


    /**
     * @param $appid
     * @return \Illuminate\Http\RedirectResponse
     * 手动发布代码
     */
    public function upSourceCode( $appid )
    {
        $user = session('userInfo');
        $isUploadCode = SmallProgram::where(['authorizer_appid'=>$appid,'companyid'=>$user->companyid])->first();
        if( $isUploadCode )
        {
            if( $isUploadCode->sourcecode != 0 )
            {
                return redirect()->route('user-authorize')->with('msg',$isUploadCode->errmsg);
            }
            $res = $this->wx->upCodeLine( '', $appid );
            return redirect()->route('user-authorize')->with('msg',$res->msg);

        }else
        {
            return redirect()->back()->with('msg','地址不存在');
        }
    }

    /**
     * @param $auditid
     * 查询审核代码的状态
     */
    public function auditid( Request $request )
    {
        $user = session('userInfo');
        $auditid = $request->input('auditid');
        $type = $request->input('type');
        $res = SmallProgram::where(['auditid'=>$auditid,'companyid'=>$user->companyid])->first();
        if( $res )
        {
            $res = $this->wx->getAuditid( $res->authorizer_appid, $auditid, $type );
            responseData(\StatusCode::SUCCESS,'审核代码状态',$res );

        }else
        {
            responseData(\StatusCode::ERROR,'审核代码不存在');
        }
    }

}