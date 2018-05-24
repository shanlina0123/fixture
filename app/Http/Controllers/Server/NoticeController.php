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

        //用户信息
        $user=getUserInfo();
        //非管理员参数验证
        if($user->isadmin==0) {
            if (strlen($user->companyid) == 0 || $user->companyid==0 ||
                strlen($user->cityid) == 0 || $user->cityid==0 ||
                strlen($user->storeid) == 0 || $user->storeid==0
            ) {
                return  responseCData(\StatusCode::PARAM_ERROR,"用户信息不完整",null);
            }
        }

        $list=$this->notice_business->index($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }


    //获取是否有未读的通知
    public  function  listen($time)
    {
        //用户信息
        $user=getUserInfo();
        //非管理员参数验证
        if($user->isadmin==0) {
            if (strlen($user->companyid) == 0 || $user->companyid==0 ||
                strlen($user->cityid) == 0 || $user->cityid==0 ||
                strlen($user->storeid) == 0 || $user->storeid==0
            ) {
                return   responseData(\StatusCode::PARAM_ERROR,"用户信息不完整");
            }
        }

        $data=$this->notice_business->listen($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook);
        return   responseData(\StatusCode::SUCCESS,"",$data);
    }



}
