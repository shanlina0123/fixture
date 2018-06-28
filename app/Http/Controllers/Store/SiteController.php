<?php

namespace App\Http\Controllers\Store;

use App\Http\Business\Store\SiteBusiness;
use App\Http\Business\Server\SiteBusiness as ServerSite;
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
        $data = trimValue( $this->request->all());
        $validator = Validator::make(
            $data, [
            'storeid' => 'bail|required|numeric',//门店
            'name' => 'bail|required|max:20',//项目名称
            'stageid' => 'bail|required|numeric',//阶段id
            'addr' => 'bail|required|max:255',//地址
            'lng' => 'bail|present',//经度
            'lat' => 'bail|present',//维度
            'doornumber' => 'present|max:100',//门牌
            'roomtypeid' => 'present',//户型
            'room' => 'present',//房型
            'office' => 'present',//房型
            'kitchen' => 'present',//房型
            'wei' => 'present',//房型
            'acreage' => 'present',//面积
            'roomstyleid' => 'present',//风格
            'renovationmodeid' => 'present',//方式
            'budget' => 'present',//预算
            'photo' => 'present',//图片

        ], [
            'storeid.numeric' => '门店信息数据类型不正确',
            'storeid.required' => '门店信息未获取到',
            'addr.required' => '请填写地址',
            'name.required' => '项目名称不能为空',
            'name.max' => '项目名称最大长度为20个字符',
            'doornumber.max' => '门牌名称最大长度为100个字符',
            'stageid.required' => '请选择阶段',
            'stageid.numeric' => '阶段数据类型不正确',
            'addr.required' => '地址不能为空',
            'roomtypeid.required' => '请选择户型',
            'roomstyleid.required' => '请选择装修风格',
            'renovationmodeid.required' => '请选择装修方式',
            'budget.numeric' => '预算数据类型不正确',
            ]
        );
        $data['companyid'] = $this->apiUser->companyid;
        $data['createuserid'] = $this->apiUser->id;

        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $model = new ServerSite();
        $res = $model->siteSave( $data );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid'],'siteHome'.$data['companyid'],'DynamicList'.$data['companyid']])->flush();
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
        $res = $this->site->searchSiteList( $where, $data );
        responseData(\StatusCode::SUCCESS,'工地检索列表',$res);
    }


    /**
     * 工地删除
     */
    public function siteDestroy()
    {
        $data = trimValue( $this->request->all() );
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,
            [
                'uuid'=>'bail|required',
            ],[
                'uuid.required'=>'ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $model = new ServerSite();
        $res = $model->siteDel(  $data['companyid'],  $data['uuid'] );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid'],'siteHome'.$data['companyid'],'DynamicList'.$data['companyid']])->flush();
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
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
                'isopen'=>'bail|required|numeric|max:1',//是不是公开
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
        $res = $this->site->siteIsOpen( $data );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid'], 'DynamicList'.$data['companyid'],'siteHome'.$data['companyid']])->flush();
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
            Cache::tags(['site'.$data['companyid'], 'DynamicList'.$data['companyid'],'siteHome'.$data['companyid']])->flush();
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
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'companyid'=>'bail|required|numeric',//公司
            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'companyid.required'=>'公司信息未获取到',
                'companyid.numeric'=>'公司信息数据类型不正确'
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
        $validator = Validator::make(
            $data,
            ['name' => 'bail|required|max:20',//项目名称
            'stageid' => 'bail|required|numeric',//阶段id
            'addr' => 'bail|required|max:255',//地址
            'lng' => 'bail|present',//经度
            'lat' => 'bail|present',//维度
            'doornumber' => 'present',//门牌
            'roomtypeid' => 'present',//户型
            'room' => 'present',//房型
            'office' => 'present',//房型
            'kitchen' => 'present',//房型
            'wei' => 'present',//房型
            'acreage' => 'present',//面积
            'roomstyleid' => 'present',//风格
            'renovationmodeid' => 'present',//方式
            'budget' => 'bail|present',//预算
            'photo' => 'bail|present',//图片

            ], [
            'addr.required' => '请填写地址',
            'name.required' => '项目名称不能为空',
            'name.max' => '项目名称最大长度为20个字符',
            'doornumber.max' => '门牌名称最大长度为100个字符',
            'stageid.required' => '请选择阶段',
            'stageid.numeric' => '阶段数据类型不正确',
            'addr.required' => '地址不能为空',
            'roomtypeid.required' => '请选择户型',
            'roomstyleid.required' => '请选择装修风格',
            'renovationmodeid.required' => '请选择装修方式',
            'budget.numeric' => '预算数据类型不正确',
           ]);
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $model = new ServerSite();
        $res = $model->siteUpdate( $data,$data['uuid'] );
        if ($res->status == 1)
        {
            Cache::tags(['site'.$data['companyid'], 'DynamicList'.$data['companyid'],'siteHome'.$data['companyid']])->flush();
            responseData(\StatusCode::SUCCESS, $res->msg);
        }else
        {
            responseData(\StatusCode::ERROR, $res->msg);
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
        $data['userType'] = $this->apiUser->id;
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

    /**
     * 更新工地动态
     */
    public function siteRenew()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,
            [
                'uuid'=>'bail|required',
                'sitestagename'=>'bail|required',
                'stagetagid'=>'bail|required',
                'content'=>'bail|required',
            ],[
                'uuid.required'=>'uuid不能为空',
                'sitestagename.required'=>'请设置阶段',
                'stagetagid.required'=>'请设置阶段',
                'content.required'=>'请填写内容',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $data['companyid'] = $this->apiUser->companyid;
        $data['createuserid'] = $this->apiUser->id;
        $siteMode = new ServerSite();
        $res = $siteMode->saveSiteRenew($data, $data['uuid']);
        if ($res->status == 1)
        {
            Cache::tags(['site'.$data['companyid'], 'DynamicList'.$data['companyid'],'siteHome'.$data['companyid']])->flush();
            responseData(\StatusCode::SUCCESS,'更新成功');
        }else
        {
            responseData(\StatusCode::ERROR,'更新失败');
        }
    }

    /**
     *  更新工地动态数据
     */
    public function siteRenewInfo()
    {
        $companyid = $this->apiUser->companyid;
        $uuid = trim($this->request->input('uuid'));
        $siteMode = new ServerSite();
        $res = $siteMode->getSiteRenew($companyid, $uuid);
        if( $res->status == 1 )
        {
            Cache::tags(['site'.$companyid, 'DynamicList'.$companyid,'siteHome'.$companyid])->flush();
            responseData(\StatusCode::SUCCESS,$res->msg,$res->tage);
        }
        responseData(\StatusCode::ERROR,$res->msg);
    }
}
