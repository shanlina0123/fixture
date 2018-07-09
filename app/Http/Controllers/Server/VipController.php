<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\VipBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;

class VipController extends ServerBaseController
{
    protected $request;
    protected $vip;
    public function __construct( VipBusiness $vip, Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->vip_business = $vip;
    }

    /***
     * 介绍页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index()
    {
        //执行业务处理
        $data=$this->vip_business->index($this->userInfo->companyid,$this->userInfo["vipmechanismid"]);
        return view('server.vip.index',compact('data'));
    }

    /***
     * 升级申请标准版
     */
    public function  store()
    {
        //检验
        $vipmechanismid=$this->userInfo["vipmechanismid"]?$this->userInfo["vipmechanismid"]:1;
        if($vipmechanismid==3)
        {
            responseData(\StatusCode::PARAM_ERROR,"您是定制版,升级请联系客服","","您是定制版,升级请联系客服");
        }
        if($vipmechanismid==2)
        {
            responseData(\StatusCode::PARAM_ERROR,"您已是标准版","","您已是标准版");
        }
        //执行业务处理
        $this->vip_business->store($this->userInfo->companyid,2);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"您好，已收到您标准版升级申请，我们会尽快和您联系！");
    }

}