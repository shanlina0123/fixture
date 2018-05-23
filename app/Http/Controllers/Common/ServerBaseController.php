<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ServerBaseController extends Controller
{
    /**
     *  缓存 //工地  Cache::tags($tag) $tag = 'site'.$user->companyid;
     *  公司查询店铺 Cache::get('storeCompany'.$user->companyid)
     *  店铺查询店铺 Cache::get('store'.$user->storeid)
     *   户型           Cache::get('roomType')
     *   装修风格       Cache::get('roomStyle')
     *   装修方式   Cache::get('renovationMode')
     *   系统模板  Cache::get('stagetemplate')
     *   公司模板   Cache::get('companystagetemplate'.$companyID)
     *   模板列表 Cache::tags($tag)  'siteTemplate'.$user->companyid;
     *   预约客户 Cache::tags($tag) 'client'.$user->companyid;
     */



     /**
      *  引入权限认证
      */
    public $userInfo;
    public function __construct()
    {
        //判断公司信息是否完善
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('userInfo');
            if( !$userInfo->companyid && $userInfo->isadmin = 1 )
            {
                return redirect()->route('company-setting')->with('msg','请完善资料');
            }
            $this->userInfo = $userInfo;
            return $next($request);
        });
    }

    /***
     * json返回
     * @param $data
     * @return string
     */
    public  function response($data)
    {
        $responseData= [
            "status"=>$data["status"]?$data["status"]:"",
            "msg"=>$data["msg"]?$data["msg"]:"",
            "data"=>$data["data"]?$data["data"]:"",
        ];
      echo    json_encode($responseData);
      die;
    }

}
