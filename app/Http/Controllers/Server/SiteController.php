<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\SiteBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SiteController extends ServerBaseController
{

    protected $site;

    public function __construct(SiteBusiness $site )
    {
        parent::__construct();
        $this->site = $site;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $parameter = ParameterFiltering($request->all());
        $where['name'] = array_has($parameter,'name')?$parameter['name']:'';
        $where['isopen'] = array_has($parameter,'isopen')?$parameter['isopen']:'';
        $where['storeid'] = array_has($parameter,'storeid')?$parameter['storeid']:'';
        $where['page'] = array_has($parameter,'page')?$parameter['page']:1;
        $data = $this->site->getSiteList( $where, $this->userInfo );
        //列表店铺信息
        $data->store = $this->site->getStore( $this->userInfo );
        return view('server.site.index',compact('data','where'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //验证权限

        //创建工地
        $data = new \stdClass();
        $data->store = $this->site->getStore( $this->userInfo );
        //户型
        $data->roomType = $this->site->getRoomType( $this->userInfo->companyid );
        //装修风格
        $data->roomStyle = $this->site->getRoomStyle( $this->userInfo->companyid );
        //装修方式
        $data->renovationMode = $this->site->getRenovationMode( $this->userInfo->companyid );
        //公司模板
        $data->companyTemplate = $this->site->getCompanyStageTemplate( $this->userInfo );
        return view('server.site.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证
        $request->validate(
            [
                'storeid'=>'bail|required|numeric',//门店
                'name'=>'bail|required|max:20',//项目名称templateTag
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
                'acreage'=>'present',//面积
                'roomstyleid'=>'bail|required|numeric',//风格
                'renovationmodeid'=>'bail|required|numeric',//方式
                'budget'=>'bail|present',//预算
                'photo'=>'bail|present',//图片

            ],[
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
        $data = trimValue($request->all());
        $data['companyid'] = session('userInfo')->companyid;
        $data['cityid'] = session('userInfo')->cityid;
        $data['createuserid'] = session('userInfo')['id'];
        $res = $this->site->siteSave( $data );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid'],'DynamicList'.$data['companyid']])->flush();
            return redirect()->route('site.index')->with('msg','添加成功');
        }else
        {
            return redirect()->route('site.create')->withInput($request->all())->with('msg','添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = new \stdClass();
        $companyId = $this->userInfo->companyid;
        //户型
        $data->roomType = $this->site->getRoomType($companyId);
        //装修风格
        $data->roomStyle = $this->site->getRoomStyle($companyId);
        //装修方式
        $data->renovationMode = $this->site->getRenovationMode($companyId);
        //公司模板
        $data->companyTemplate = $this->site->getCompanyStageTemplate( $this->userInfo );
        $data->info = $this->site->editSite( $id,$companyId );
        return view('server.site.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //表单验证
        $request->validate(  [
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
        ]);
        $data = trimValue($request->all());
        $data['companyid'] = $this->userInfo->companyid;
        $res = $this->site->siteUpdate( $data, $id );
        if( $res->status == 1 )
        {
            Cache::tags(['site'.$data['companyid'],'DynamicList'.$data['companyid']])->flush();
            return redirect()->route('site.index')->with('msg',$res->msg);
        }else
        {
            return redirect()->route('site.index')->withInput($request->all())->with('msg',$res->msg);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyId = $this->userInfo->companyid;
        $res = $this->site->siteDel( $companyId, $id );
        if( $res == true )
        {
            Cache::tags(['site'.$companyId])->flush();
            return 'success';
        }else
        {
            return 'fail';
        }
    }

    /**
     * 获取标签进度内容
     */
    public function templateTag( Request $request )
    {
        $tid = $request->input('tid');
        return $this->site->getTemplateTag( $tid, $this->userInfo );
    }


    /**
     * 更新工地进度
     */
    public function siteRenew( Request $request, $uuid )
    {
        $companyId = $this->userInfo->companyid;
        if( $request->method() === 'POST' )
        {
            $request->validate([
                'stagetagid' => 'required',
                'content' => 'required',
            ]);
            $data = trimValue($request->all());
            $data['storeid'] = $this->userInfo->storeid;
            $data['companyid'] = $companyId;
            $data['createuserid'] =  $this->userInfo->id;
            $res = $this->site->saveSiteRenew( $data, $uuid );
            if( $res->status == 1 )
            {
                Cache::tags(['site'.$companyId,'DynamicList'.$data['companyid']])->flush();
                return redirect()->route('site.index')->with('msg','更新成功');
            }else
            {
                return redirect()->back()->withInput($request->all())->with('msg','更新失败');
            }

        }else
        {
            $data = $this->site->getSiteRenew($companyId,$uuid);
            if( $data->status == 0 )
            {
                return redirect()->back()->with('msg',$data->msg);
            }
            return view('server.site.renew',compact('data'));
        }
    }

    /**
     * 工地是否公开
     */
    public function isOpen( Request $request )
    {
        $data = trimValue( $request->all() );
        $validator = Validator::make(
            $data,
            [
                'id'=>'bail|required|numeric',
                'isopen'=>'bail|required|numeric|max:1',//是不是公开
            ],[
                'id.required'=>'ID不能为空',
                'id.numeric'=>'ID数据类型不正确',
                'isopen.numeric'=>'数据类型有误',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $data['companyid'] = $this->userInfo->companyid;
        $res = $this->site->siteIsOpen( $data );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid']])->flush();
            responseData(\StatusCode::SUCCESS,'修改成功',$res);
        }else
        {
            responseData(\StatusCode::ERROR,'修改失败',$res);
        }
    }

    /***
     * 推广详情
     * @param Request $request
     */
    public function extension(Request $request,$id)
    {
        //获取列表数据
        $dataSource=$this->extensionData($id);
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($request->ajax()){
            responseAjax($dataSource);
        }

        return view('server.site.index',compact('list'))->with("errorMsg",$errorMsg);
    }


    /***
     * 推广详情数据
     */
    public function extensionData($uuid)
    {
        $validator = Validator::make(["uuid"=>$uuid],[
            'uuid' => 'required|max:32|min:32'
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误']);
        //进行验证
        if ($validator->fails()) {
            return  responseCData(\StatusCode::PARAM_ERROR,"工地参数错误","",$validator->errors());
        }

        return $this->site->extension($uuid,$this->userInfo->companyid);
    }
}
