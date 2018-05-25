<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\AdminBusiness;
use App\Http\Business\Server\NoticeBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/***
 * 提醒
 * Class AdminController
 * @package App\Http\Controllers\Server
 */
class NoticeController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $notice_business;
    protected $request;
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->notice_business =  new NoticeBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取列表
     */
    public function index()
    {
        //获取列表数据
        $dataSource=$this->getListData();
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.notice.index',compact('list'))->with("errorMsg",$errorMsg);
    }

    /***
     * 获取列表数据集
     */
    public  function  getListData()
    {
        $page=$this->request->input("page");
        $list=$this->notice_business->index($this->userInfo->isadmin,$this->userInfo->companyid,$this->userInfo->cityid,$this->userInfo->storeid,$this->userInfo->islook);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }


    //获取是否有未读的通知
    public  function  listen($time)
    {
        $data=$this->notice_business->listen($this->userInfo->isadmin,$this->userInfo->companyid,$this->userInfo->cityid,$this->userInfo->storeid,$this->userInfo->islook);
        return   responseData(\StatusCode::SUCCESS,"",$data);
    }



}
