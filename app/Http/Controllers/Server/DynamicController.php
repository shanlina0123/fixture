<?php

namespace App\Http\Controllers\Server;


use App\Http\Business\Server\DynamicBusiness;
use App\Http\Business\Server\SiteBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class DynamicController extends ServerBaseController
{

    public $dynamic;
    public  $site;
    public function __construct(DynamicBusiness $dynamic,SiteBusiness $site)
    {
        parent::__construct();
        $this->dynamic = $dynamic;
        $this->site = $site;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * 动态列表
     */
    public function getDynamicList(Request $request,$id)
    {
        if( !$id )
        {
            return redirect()->back();
        }
        $user = $this->userInfo;
        //总管理员
        if( $user->isadmin != 1 )
        {
            //检测权限
            if( !empty($user->islook) )
            {
                //存在
                switch ( (int)$user->islook )
                {
                    case 1://全部
                        break;
                    case 2://城市
                        $where['cityid'] =  $user->cityid;
                        break;
                    case 3://门店
                        $where['storeid'] =  $user->storeid;
                        break;
                    default://默认
                        $where['storeid'] =  $user->storeid;
                        break;
                }
            }else
            {
                //不存在
                $where['storeid'] = $user->storeid;
            }
        }
        $where['sitetid'] = base64_decode($id);
        $where['companyid'] = $user->companyid;
        $where['type'] = 0;
        $data = $this->dynamic->getDynamicList( $where, $request );
        return view('server.dynamic.index', compact('data','id'));
    }

    /**
     * 动态信息
     */
    public function edit($uuid )
    {
        $url = url()->previous();
        $user = $this->userInfo;
        $where['companyid'] = $user->companyid;
        $where['uuid'] = $uuid;
        $data = $this->dynamic->dynamicInfo( $where );
        /*$res = $this->dynamic->getSiteRenew($user->companyid, $data->sitetid);
        if ($res->status == 0) {
            return redirect()->back()->with('msg', $res->msg);
        }*/
        return view('server.dynamic.edit', compact('data','url'));
    }


    /**
     * @param Request $request
     * @param $uuid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 动态修改
     */
    public function update( Request $request, $uuid )
    {
        $user = $this->userInfo;
        $data = $request->all();
        //表单验证
        $request->validate(
            [
                'content'=>'required|max:300',
                'img'=>'present',
                'delimg'=>'present',
            ], [
                'content.required' => '内容不能为空',
                'content.max' => '内容不能超过300个字',
                'img.present' => '图片缺少',
                'delimg.present' => '图片缺少',
            ]);
        $data['companyid'] = $user->companyid;
        $res = $this->dynamic->updateDynamic( $uuid, $data );
        if( $res == true )
        {
            Cache::tags(['DynamicList'.$user->companyid,'DynamicListPc'.$user->companyid])->flush();
            return redirect($data['url'])->with('msg','修改成功');
        }
        return redirect($data['url'])->with('msg','修改失败');
    }

    /**
     * 动态删除
     */
    public function destroy( Request $request,$uuid )
    {
        $user = $this->userInfo;
        $where['uuid'] = $uuid;
        $where['companyid'] = $user->companyid;
        //总管理员
        if( $user->isadmin != 1 )
        {
            //检测权限
            if( !empty($user->islook) )
            {
                //存在
                switch ( (int)$user->islook )
                {
                    case 1://全部
                        break;
                    case 2://城市
                        $where['cityid'] =  $user->cityid;
                        break;
                    case 3://门店
                        $where['storeid'] =  $user->storeid;
                        break;
                    default://默认
                        $where['storeid'] =  $user->storeid;
                        break;
                }
            }else
            {
                //不存在
                $where['storeid'] = $user->storeid;
            }
        }

        $res = $this->dynamic->destroyDynamic( $where );
        if( $res == true )
        {
            Cache::tags(['DynamicList'.$user->companyid,'DynamicListPc'.$user->companyid])->flush();
            return 'success';
        }
        return 'fail';
    }
}