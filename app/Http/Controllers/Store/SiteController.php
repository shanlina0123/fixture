<?php

namespace App\Http\Controllers\Store;
use App\Http\Business\Store\SiteBusiness;
use App\Http\Controllers\Common\StoreBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class SiteController extends StoreBaseController
{
    protected $site;
    public function __construct( SiteBusiness $site )
    {
        parent::__construct();
        $this->site = $site;
    }

    /**
     * 发布工地
     */
    public function store()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $data['uid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
                'companyid'=>'bail|required|numeric',//公司
                'storeid'=>'bail|required|numeric',//门店
                'addr'=>'bail|required|max:255',//地址
                'lng'=>'bail|present',//经度
                'lat'=>'bail|present',//维度
                'name'=>'bail|required|max:20',//项目名称
                'doornumber'=>'bail|present|max:100',//门牌
                'stageid'=>'bail|required|numeric',//阶段id
                'stagetemplateid'=>'bail|required|numeric',//默认阶段模板id 或 自定义阶段模板id
                'isopen'=>'bail|required|numeric',//是否公开
            ],[
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
                'storeid.numeric'=>'门店信息数据类型不正确',
                'storeid.required'=>'门店信息未获取到',
                'addr.required'=>'请填写地址',
                'name.required'=>'项目名称不能为空',
                'name.max'=>'项目名称最大长度为20个字符',
                'doornumber.max'=>'门牌名称最大长度为100个字符',
                'stageid.required'=>'请选择阶段',
                'stageid.numeric'=>'阶段数据类型不正确',
                'stagetemplateid.required'=>'请选择模板',
                'stagetemplateid.numeric'=>'模板数据类型不正确',
                'isopen.required'=>'请选择是否公开',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $res = $this->site->siteSave( $data );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid'],'siteHome'.$data['storeid'],'DynamicList'.$data['companyid']])->flush();
            responseData(\StatusCode::SUCCESS,'发布成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'发布失败',$res);
        }
    }

    /**
     *  工地列表
     */
    public function siteList()
    {
        $data = trimValue( $this->request->all() );
        $user = $this->apiUser;
        //判断用户信息如果是B端只显示当前店铺的动态
        if( $user->type == 0 )
        {
            if( $user->isinvitationed != 1 )
            {
                //B端用户
                switch ( (int)$user->islook )
                {
                    case 1:
                        //全部
                        break;
                    case 2:
                        //城市
                        $where['cityid'] = $user->cityid;
                        break;
                    case 3:
                        //门店
                        $where['storeid'] = $user->storeid;
                        break;
                }
            }
        }else
        {
            responseData(\StatusCode::ERROR,'工地列表',[]);
        }
        $where['companyid'] = $this->apiUser->companyid;
        $where['isfinish'] = $data['isfinish'];
        $res = $this->site->siteList( $where, $data );
        responseData(\StatusCode::SUCCESS,'工地列表',$res);
    }

    /**
     * 工地检索
     */
    public function searchSiteList()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $validator = Validator::make(
            $data,
            [
                'companyid'=>'bail|required',//公司
                'storeid'=>'bail|required',//门店
                'isfinish'=>'bail|required'
            ],[
                'companyid.required'=>'公司信息未获取到',
                'storeid.required'=>'门店信息未获取到',
                'isfinish'=>'项目未获取到'
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->site->siteList( $data );
        responseData(\StatusCode::SUCCESS,'工地检索列表',$res);
    }


    /**
     * 工地删除
     */
    public function siteDestroy()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
                'storeid'=>'bail|required|numeric',//门店
            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
                'storeid.numeric'=>'门店信息数据类型不正确',
                'storeid.required'=>'门店信息未获取到',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->site->siteDestroy( $data );
        if( $res == true )
        {
            responseData(\StatusCode::SUCCESS,'删除成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'删除失败',$res);
        }
    }

    /**
     * 工地是否公开
     */
    public function isOpen()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
                'storeid'=>'bail|required|numeric',//门店
                'isopen'=>'bail|required|numeric|max:1',//是不是公开
            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
                'storeid.numeric'=>'门店信息数据类型不正确',
                'storeid.required'=>'门店信息未获取到',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->site->siteIsOpen( $data );
        if( $res == true )
        {
            responseData(\StatusCode::SUCCESS,'修改成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'修改失败',$res);
        }
    }

    /**
     * 是否完工
     */
    public function isFinish()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
                'storeid'=>'bail|required|numeric',//门店
            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
                'storeid.numeric'=>'门店信息数据类型不正确',
                'storeid.required'=>'门店信息未获取到',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->site->siteIsFinish( $data );
        if( $res == true )
        {
            responseData(\StatusCode::SUCCESS,'修改成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'修改失败',$res);
        }
    }


    /**
     * 修改工地
     */
    public function siteEdit()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
                'storeid'=>'bail|required|numeric',//门店
            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
                'storeid.numeric'=>'门店信息数据类型不正确',
                'storeid.required'=>'门店信息未获取到',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->site->siteEdit( $data );
        responseData(\StatusCode::SUCCESS,'工地数据',$res);
    }

    /**
     * 修改保存
     */
    public function siteUpdate()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['storeid'] = $this->apiUser->storeid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
                'storeid'=>'bail|required|numeric',//门店
                'name'=>'bail|required|max:20',//项目名称
                'stageid'=>'bail|required|numeric',//阶段id
                'addr'=>'bail|required|max:255',//地址
                'lng'=>'bail|present',//经度
                'lat'=>'bail|present',//维度
                'doornumber'=>'bail|present|max:100',//门牌
                'roomtypeid'=>'required|numeric',//户型
                'room'=>'bail|required|numeric',//房型
                'office'=>'bail|required|numeric',//房型
                'kitchen'=>'bail|required|numeric',//房型
                'wei'=>'bail|required|numeric',//房型
                'acreage'=>'required',//面积
                'roomstyleid'=>'bail|required|numeric',//风格
                'renovationmodeid'=>'bail|required|numeric',//方式
                'budget'=>'bail|present',//预算
                'photo'=>'bail|present',//图片

            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确',
                'storeid.numeric'=>'门店信息数据类型不正确',
                'storeid.required'=>'门店信息未获取到',
                'addr.required'=>'请填写地址',
                'name.required'=>'项目名称不能为空',
                'name.max'=>'项目名称最大长度为20个字符',
                'doornumber.max'=>'门牌名称最大长度为100个字符',
                'stageid.required'=>'请选择阶段',
                'stageid.numeric'=>'阶段数据类型不正确',
                'addr.required'=>'地址不能为空',
                'roomtypeid.required'=>'请选择户型',
                'roomstyleid.required'=>'请选择装修风格',
                'renovationmodeid.required'=>'请选择装修方式',
                'budget.numeric'=>'预算数据类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->site->siteUpdate( $data );
        if( $res == true )
        {
            responseData(\StatusCode::SUCCESS,'修改成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'修改失败',$res);
        }
    }

    /**
     * 工地详情
     */
    public function siteInfo()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
            ],[
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
        $res = $this->site->siteInfo( $data );
        responseData(\StatusCode::SUCCESS,'工地详情',$res);
    }

    /**
     * 详情动态
     */
    public function siteDynamic()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
            ],[
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
        $res = $this->site->siteDynamic( $data );
        responseData(\StatusCode::SUCCESS,'工地详情动态',$res);
    }
}
