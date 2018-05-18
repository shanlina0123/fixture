<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\ActivityBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 项目管理 - 活动管理
 * Class ActivityController
 * @package App\Http\Controllers\Server
 */
class ActivityController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $activity;
    protected $request;
    public function __construct(Request $request)
    {
        $this->activity =  new ActivityBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取活动列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $responseData = $this->activity->index();
        return view('server.activity.index',compact('responseData'));

    }

    /***
     * 创建活动
     * @param Request $request
     */
    public function create()
    {
        //数据源 - 参与方式
        $responseData = $this->activity->getParticipatory();
        return view('server.activity.create',compact('responseData'));

    }
    /***
     * 执行 - 创建活动
     * @param Request $request
     */
    public function store()
    {

    }

    /***
     * 修改活动
     * @param Request $request
     */
    public function edit()
    {
    }

    /***
     * 执行 - 修改活动
     * @param Request $request
     */
    public function update()
    {

    }

    /***
     * 查看活动详情、预览
     * @param Request $request
     */
    public function show($uuid)
    {
        //业务处理
        $responseData = $this->activity->show($uuid);
        return view('server.activity.show',compact('responseData'));

    }

    /***
     * 设置是否公开
     * @param Request $request
     * 0 执行成功
     * 1 执行失败
     * 100 参数错误
     * 101 业务错误
     * 102 数据权限错误
     * 200+ 未其他错误
     */
    public function setting()
    {
        //获取请求
        $requestData = $this->request->all();
        //验证
        $validator = Validator::make($requestData, [
            'uuid' => 'required',//|present|unique:activity|digits:32
            "isopen"=>'required|numeric|max:1|min:0'
        ]);

        //验证失败
        if ($validator->fails()) {
           $this->response(array("status"=>100,"msg"=>"参数验证失败","data"=>"")) ;
        }

        //业务处理
        $result = $this->activity->setting($requestData);
        if($result == false)
        {
            $this->response(array("status"=>1,"msg"=>"设置失败","data"=>"")) ;
        }else{
            $this->response(array("status"=>0,"msg"=>"设置成功","data"=>"")) ;
        }

    }

}
