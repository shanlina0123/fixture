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
            'companyid'=>'bail|required|numeric',//公司
            'sourcecateid'=>'bail|required|numeric',//客户来源分类
            'sourceid'=>'bail|required|numeric',//客户来源
            'phone'=>'bail|required|regex:/^1[345789][0-9]{9}$/',//电话
            'name'=>'bail|present|max:10',//姓名
            'area'=>'sometimes|bail|present|max:11',//面积
            'content'=>'bail|required',//内容
            'wechatopenid'=>'bail|required',//openid
        ],[
            'companyid.required'=>'公司信息未获取到',
            'companyid.numeric'=>'公司信息数据类型不正确',
            'sourcecateid.numeric'=>'客户来源分类数据类型不正确',
            'sourcecateid.required'=>'客户来源分类数据类型必填',
            'sourceid.numeric'=>'客户来源数据类型不正确',
            'sourceid.required'=>'客户来源数据类型必填',
            'phone.regex'=>'手机号码有误',
            'name.present'=>'缺少用户名',
            'name.max'=>'用户名有误',
            'area.max'=>'面积格式有误',
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
            Cache::tags(['site'.$data['companyid'],'siteHome'.$data['storeid']])->flush();
            responseData(\StatusCode::SUCCESS,'预约成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'预约失败',$res);
        }
    }
}