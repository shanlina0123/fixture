<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:20
 */
namespace App\Http\Controllers\Server;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Business\Server\WxTempletBusiness;
use App\Http\Controllers\Common\WxBaseController;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WxAuthorizeController extends WxBaseController
{
    public $wx;
    public $userInfo;
    public function __construct( WxAuthorize $wx )
    {
        $this->wx = $wx;
        //判断公司信息是否完善
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('userInfo');
            $this->userInfo = $userInfo;
            if( !$userInfo->companyid && $userInfo->isadmin == 1 )
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
        $user = $this->userInfo;
        $data = SmallProgram::where(['companyid'=>$user->companyid])->first();
        if( $data &&  $data->status != 1 )
        {
            return redirect()->route('user-authorize')->with('msg','您已授权成功');
        }
        $code = $this->wx->preAuthCode($user->id);
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
            //添加模板
            //$temple = new WxTempletBusiness;
            //$temple->addTemplet($this->userInfo->companyid);
            return redirect()->route('user-authorize')->with('msg','授权成功');

        }else
        {
            return redirect()->route('user-authorize')->with('msg','授权回调写入失败');
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


    /**
     * 手动设置小程序审核流程
     */
    public function submission()
    {
        $companyid = $this->userInfo->companyid;
        $code = SmallProgram::where('companyid',$companyid)->first();
        switch ( $code->codestatus )
        {
            case 1://设置基本信息
                $this->wx->wxInfo($code->authorizer_appid,$companyid);
                break;
            case 3://设置url
                $this->wx->setUrl($code->authorizer_appid,$companyid);
                break;
            case 4://上传代码
                $this->wx->upCode($code->authorizer_appid,$companyid);
                break;
            case 5://提交审核
                $this->wx->upCodeLine($code->authorizer_appid,$companyid);
                break;
            default:
                return redirect()->route('user-authorize');
        }
        return redirect()->route('user-authorize')->with('msg','更新完成');
    }

}