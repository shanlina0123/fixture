<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 9:40
 * 微信公众平台操作类
 */

namespace App\Http\Controllers\Server;


use App\Http\Business\Server\WeChatPublicNumberBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\Data\MpTemplate;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;

class WeChatPublicNumberController extends ServerBaseController
{

    public $weChat;
    public $request;
    public function __construct( Request $request, WeChatPublicNumberBusiness $weChat)
    {
        parent::__construct();
        $this->request = $request;
        $this->weChat = $weChat;
    }

    /**
     * 服务通知首页
     */
    public function sendIndex()
    {
        $user = $this->userInfo;
        $small = SmallProgram::where('companyid',$user->companyid)->first();
        $mpData = MpTemplate::where('status',1)->with(['templateToCompanyTemplate'=>function($query) use($user){
                     return $query->where('companyid',$user->companyid);
                  }])->get();
        return view('server.send.index', compact('small','mpData','user'));
    }

    /**
     * 公共号授权
     */
    public function mpAuthorize()
    {
        $user = $this->userInfo;
        if( $user->type != 0 || $user->isadmin !=1 )
        {
            responseData(\StatusCode::ERROR,'您不是管理员无权操作');
        }
        $union_wechat_mp_appid = $this->request->input('union_wechat_mp_appid');
        $union_wechat_mp_appsecret = $this->request->input('union_wechat_mp_appsecret');
        if( !$union_wechat_mp_appid || !$union_wechat_mp_appsecret )
        {
            responseData(\StatusCode::ERROR,'授权信息必填');
        }
        $this->weChat->mpAuthorize($user,$union_wechat_mp_appid,$union_wechat_mp_appsecret);
    }

    /**
     * 申请模板
     */
    public function sendTemplate()
    {
        $user = $this->userInfo;
        $data = trimValue($this->request->all());
        $res = $this->weChat->sendTemplate($user,$data);
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,'模板信息',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'申请失败');
        }
    }
}