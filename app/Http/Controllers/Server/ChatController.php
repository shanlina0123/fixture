<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\ChatBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;

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
        $list = $this->chat_business->index($this->userInfo->companyid);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }


}
