<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 9:26
 */

namespace App\Http\Controllers\Client;


use App\Http\Business\Client\ClientAppointment;
use App\Http\Controllers\Common\ClientBaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ClientAppointmentController extends ClientBaseController
{

    public $clientAppointment;
    public function __construct( ClientAppointment $clientAppointment )
    {
        parent::__construct();
        $this->clientAppointment = $clientAppointment;
    }

    /**
     * 客户预约
     */
    public function Appointment()
    {
        $data = trimValue($this->request->all());
        $data['companyid'] = $this->apiUser->companyid;
        $data['wechatopenid'] = $this->apiUser->wechatopenid;
        $validator = Validator::make(
            $data,[
            'companyid'=>'required|numeric',//公司
            'sourcecateid'=>'required|numeric',//客户来源分类
            'sourceid'=>'required|numeric',//客户来源
            'phone'=>'required|regex:/^1[345789][0-9]{9}$/',//电话
            'name'=>'present|max:10',//姓名
            'uarea'=>'sometimes|numeric|between:1,99999999999',//面积
            'content'=>'required',//内容
            'wechatopenid'=>'required',//openid
        ],[
            'companyid.required'=>'公司信息未获取到',
            'companyid.numeric'=>'公司信息数据类型不正确',
            'sourcecateid.numeric'=>'客户来源分类数据类型不正确',
            'sourcecateid.required'=>'客户来源分类数据类型必填',
            'sourceid.numeric'=>'客户来源数据类型不正确',
            'sourceid.required'=>'客户来源数据类型必填',
            'phone.regex'=>'手机号码有误',
            'phone.required'=>'手机号码有误',
            'name.present'=>'缺少用户名',
            'name.max'=>'用户名有误',
            'uarea.between'=>'请输入实际面积',
            'uarea.numeric'=>'面积为正整数',
            'content.required'=>'内容不能为空',
            'wechatopenid.required'=>'用户openid不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->clientAppointment->Appointment( $data );
        if( $res == true )
        {
            Cache::tags(['client'.$data['companyid'],'clientWx'.$data['companyid']])->flush();
            //写日志
            //发给C端
            event('log.notice',array('type'=>4,$this->apiUser,'event'=>$data));
            //发给B端
            event('log.notice',array('type'=>4,$this->apiUser,'event'=>$data,'notice_type'=>true));
            responseData(\StatusCode::SUCCESS,'预约成功我们会尽快联系您',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'预约失败',$res);
        }
    }
}