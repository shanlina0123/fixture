<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\DataBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/***
 * 属性管理
 * Class DataController
 * @package App\Http\Controllers\Server
 */
class DataController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $data_business;
    protected $request;
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->data_business =  new DataBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取列表
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
        return view('server.data.index',compact('list'))->with("errorMsg",json_encode($errorMsg));
    }

    /***
     * 获取列表数据集
     */
    public  function  getListData()
    {

        $list=$this->data_business->index($this->userInfo->companyid);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }

    /***
     * 详情
     */
    public  function  edit($cateid)
    {
        //获取列表数据
        $dataSource=$this->getEditData($cateid);
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.data.edit',compact('list'))->with("errorMsg",json_encode($errorMsg));
    }

    /***
     * 获取详情列表数据集
     */
    public  function  getEditData($cateid)
    {
        $validator = Validator::make(["cateid"=>$cateid],[
            "cateid"=>'required|numeric',
        ],['cateid.required'=>'分类id不能为空','cateid.numeric'=>'分类id只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
           return  responseCData(\StatusCode::PARAM_ERROR,"分类参数错误","",$validator->errors());
        }
        return $this->data_business->edit($this->userInfo->companyid,$cateid);

    }


    /***
     * 修改+新增- 执行
     */
    public  function  update($id)
    {
        //获取请求参数
        $data=$this->getData(["cateid","name"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["id"=>$id],$data);

        //验证规则
        $validator = Validator::make($validateData,[
            "id"=>'present|numeric',
            "cateid"=>'required|numeric',
            "name"=>'required|max:100|min:1',
        ],['id.required'=>'id不能为空','id.numeric'=>'id只能是数字格式',
            'cateid.required'=>'分类id不能为空','cateid.numeric'=>'分类id只能是数字格式',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符',
        ]);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //获取业务数据
        $rs=$this->data_business->update($id,$this->userInfo->companyid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功",$rs);
    }


    /***
     * 删除用户
     */
    public function  delete($id)
    {
        //获取请求参数
        $data=$this->getData(["cateid"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["id"=>$id],$data);

        //验证规则
        $validator = Validator::make($validateData,[
            "id"=>'required|numeric',
            "cateid"=>'required|numeric',
        ],['id.required'=>'id不能为空','id.numeric'=>'id只能是数字格式',
            'cateid.required'=>'分类id不能为空','cateid.numeric'=>'分类id只能是数字格式',
        ]);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $this->data_business->delete($id,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"删除成功");
    }
}
