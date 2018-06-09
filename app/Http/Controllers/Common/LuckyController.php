<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/6
 * Time: 18:52
 */

namespace App\Http\Controllers\Common;


use App\Http\Business\Common\Lucky;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class LuckyController extends Controller
{

    public $apiUser;
    public $request;
    public $lucky;
    public function __construct( Lucky $lucky)
    {
        $this->middleware(function ($request, $next) {
            $this->request = $request;
            $apiUser = $request->get('apiUser');
            $this->apiUser = $apiUser?$apiUser->tokenToUser:'';
            return $next( $request );
        });
        $this->lucky = $lucky;
    }

    /**
     * 奖品详情
     */
    public function luckyInfo()
    {
        $data = $this->request->all();
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
            'id'=>'sometimes|required'
             ],[
                'id.required'=>'活动ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->lucky->getLuckyInfo($data);
        responseData(\StatusCode::SUCCESS,'活动信息',$res);
    }


    /**
     * 我的奖品
     */
    public function myLucky()
    {
        $data = $this->request->all();
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
            'id'=>'sometimes|required'
        ],[
                'id.required'=>'活动ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->lucky->myLucky($data);
        responseData(\StatusCode::SUCCESS,'中将记录',$res);
    }

    /**
     *  抽奖
     */
    public function lucyDraw()
    {
        $data = $this->request->all();
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
            'id'=>'sometimes|required'
        ],[
                'id.required'=>'活动ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->lucky->lucyDraw($data);
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$res);
        }
        responseData(\StatusCode::ERROR,'参与失败');
    }


    /**
     * 抽奖客户
     */
    public function lucyClient()
    {
        $data = trimValue($this->request->all());
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        $data['wechatopenid'] = $this->apiUser->wechatopenid;
        $validator = Validator::make(
            $data,[
            'companyid'=>'required|numeric',//公司
            'sourcecateid'=>'required|numeric',//客户来源分类
            'sourceid'=>'required|numeric',//客户来源
            'phone'=>'required|regex:/^1[345789][0-9]{9}$/',//电话
            'name'=>'present|max:10',//姓名
            'content'=>'required',//内容
            'wechatopenid'=>'required',//openid
            'activityluckyid'=>'required'
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
                'content.required'=>'内容不能为空',
                'wechatopenid.required'=>'用户openid不能为空',
                'activityluckyid.required'=>'活动ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->lucky->lucyClient($data);
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,'提交成功');
        }
        responseData(\StatusCode::ERROR,'提交失败');
    }

}