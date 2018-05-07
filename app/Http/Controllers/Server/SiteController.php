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
    protected $userInfo;
    public function __construct(SiteBusiness $site, Request $request )
    {
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('userInfo');
            /*if( !$userInfo->companyid )
            {
                return redirect()->route('company-setting')->with(['msg'=>'请先完善公司信息','returnUrl'=>$request->url()]);
            }*/
            $this->userInfo = $userInfo;
            return $next($request);
        });
        $this->site = $site;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $data = $this->site->getSiteList( $request, $this->userInfo );
        return view('server.site.index',compact('data'));
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
        $data->roomType = $this->site->getRoomType();
        //装修风格
        $data->roomStyle = $this->site->getRoomStyle();
        //装修方式
        $data->renovationMode = $this->site->getRenovationMode();
        //系统模板
        $data->stageTemplate = $this->site->getStageTemplate();
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
        $request->validate([
            'stagetagid'=>'required|numeric',
            'stagetemplateid'=>'required|numeric',
            'isdefaulttemplate'=>'required|numeric|max:1',
            'roomtypeid'=>'required|numeric',
            'roomstyleid'=>'required|numeric',
            'renovationmodeid'=>'required|numeric',
            'budget'=>'required|numeric',
            'name'=>'required|string',
            'addr'=>'required|string',
            'doornumber'=>'required|string',
            'acreage'=>'required',
            'room'=>'required|numeric',
            'office'=>'required|numeric',
            'kitchen'=>'required|numeric',
            'wei'=>'required|numeric',
        ]);
        $data = trimValue($request->all());
        $data['companyid'] = session('userInfo')->companyid;
        $data['createuserid'] = session('userInfo')['id'];
        $res = $this->site->siteSave( $data );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid']])->flush();
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
        $data->roomType = $this->site->getRoomType();
        //装修风格
        $data->roomStyle = $this->site->getRoomStyle();
        //装修方式
        $data->renovationMode = $this->site->getRenovationMode();
        //系统模板
        $data->stageTemplate = $this->site->getStageTemplate();
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
        $request->validate([
            'stagetagid'=>'required|numeric',
            'roomtypeid'=>'required|numeric',
            'roomstyleid'=>'required|numeric',
            'renovationmodeid'=>'required|numeric',
            'budget'=>'required|numeric',
            'name'=>'required|string',
            'addr'=>'required|string',
            'doornumber'=>'required|string',
            'acreage'=>'required',
            'room'=>'required|numeric',
            'office'=>'required|numeric',
            'kitchen'=>'required|numeric',
            'wei'=>'required|numeric',
        ]);
        $data = trimValue($request->all());
        $data['companyid'] = $this->userInfo->companyid;
        $res = $this->site->siteUpdate( $data, $id );
        if( $res == true )
        {
            Cache::tags(['site'.$data['companyid']])->flush();
            return redirect()->route('site.index')->with('msg','修改成功');
        }else
        {
            return redirect()->route('site.index')->withInput($request->all())->with('msg','修改失败');
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
        $type = $request->input('type');
        return $this->site->getTemplateTag( $tid, $type, $this->userInfo );
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
            if( $res == true )
            {
                Cache::tags(['site'.$companyId])->flush();
                return redirect()->route('site.index')->with('msg','更新成功');
            }else
            {
                return redirect()->back()->withInput($request->all())->with('msg','更新失败');
            }

        }else
        {
            $data = $this->site->getSiteRenew($companyId,$uuid);
            if( $data == false )
            {
                return redirect()->back()->with('msg','更新失败');
            }
            return view('server.site.renew',compact('data'));
        }
    }
}
