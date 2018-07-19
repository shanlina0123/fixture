<?php

namespace App\Http\Controllers\Store;
use App\Http\Business\Store\TemplateBusiness;
use App\Http\Controllers\Common\StoreBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class TemplateController extends StoreBaseController
{
    protected $template;
    public function __construct( TemplateBusiness $template )
    {
        parent::__construct();
        $this->template = $template;
    }

    /**
     * 添加工地显示的默认模板
     */
    public function defaultTemplate()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,
            [
                'companyid'=>'bail|required|numeric',//公司
            ],
            [
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->template->getDefaultTemplate( $data );
        responseData(\StatusCode::SUCCESS,'默认模板',$res);
    }

    /**
     * 模板列表
     */
    public function templateList()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,
            [
                'companyid'=>'bail|required|numeric',//公司
            ],
            [
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->template->getTemplateList( $data );
        responseData(\StatusCode::SUCCESS,'模板列表',$res);
    }

    /**
     * 设置默认模板
     */
    public function templateSet()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'required|numeric',
                'companyid'=>'bail|required|numeric',//公司
            ],
            [
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->template->setTemplate( $data );
        if( $res == true )
        {
            $companyID = $data['companyid'];
            Cache::tags(['defaultTemplateHome'.$companyID,'templateListHome'.$companyID,'siteTemplate'.$companyID])->flush();
            responseData(\StatusCode::SUCCESS,'设置成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'设置失败',$res);
        }
    }

    /**
     * 删除模板
     */
    public function templateDestroy()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'required|numeric',
                'companyid'=>'bail|required|numeric',//公司
            ],
            [
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->template->destroyTemplate( $data );
        if( $res )
        {
            $companyID = $data['companyid'];
            Cache::tags(['defaultTemplateHome'.$companyID,'templateListHome'.$companyID,'siteTemplate'.$companyID])->flush();
            responseData(\StatusCode::SUCCESS,'删除成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'删除失败');
        }
    }

}
