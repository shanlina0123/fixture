<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\ChatBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 聊天管理
 * Class ChatController
 * @package App\Http\Controllers\Server
 * 代码:https://laravel-china.org/index.php/topics/3398/i-came-to-aurora-jmessage-php-api-client-update
 * 文档：https://docs.jiguang.cn/jmessage/client/im_sdk_win/
 */
class ChatController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $chat_business;
    protected $request;
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->chat_business =  new ChatBusiness($request);
        $this->request = $request;
    }


    /***
     * 获取列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //获取列表数据
        $dataSource = $this->getListData();//数据集合
        $list = $dataSource["data"];//数据
        $errorMsg = $dataSource["messages"];//错误消息
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.chat.index',compact('list'))->with("errorMsg",$errorMsg);
    }

    /***
     * 获取列表数据集
     */
    public  function  getListData()
    {
        //业务调用
        $list = $this->chat_business->getListData($this->userInfo->id,$this->userInfo->nickname,$this->userInfo->faceimg,$this->userInfo->token,$this->userInfo->jguser);
        return responseCData(\StatusCode::SUCCESS,"",$list);
    }


    /***
     * 获取用户聊天列表
     * @param $initKeys
     * @param $data
     * @return array
     */
    public function getUserMessageData()
    {
        //获取请求参数
        $data=$this->getData(["jguser"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "jguser"=>'required',
        ],['jguser.required'=>'极光用户不能为空']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,$validator->errors()->first(),"",$validator->errors());
        }

        //执行业务处理
        $list=$this->chat_business->getUserMessageData($this->userInfo->id,$data["jguser"]);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);

    }

}
