<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\RolesBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/***
 * 角色管理
 * Class RolesController
 * @package App\Http\Controllers\Server
 */
class RolesController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $roles_business;
    protected $request;
    public function __construct(Request $request)
    {
        $this->roles_business =  new RolesBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取角色列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
        return view('server.roles.index',compact('list'))->with("errorMsg",$errorMsg);
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

        $list = $this->roles_business->index($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook,$page);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }




    /***
     * 创建角色
     * @param Request $request
     */
    public function create()
    {
        return view('server.roles.create');

    }
    /***
     * 执行 - 创建角色
     * @param Request $request
     */
    public function store()
    {
        //获取请求参数
        $data=$this->getData(["name"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'required|max:100|min:1',
        ],['name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //执行业务处理
        $this->roles_business->store($data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"新增成功");
    }


    /***
     * 执行 - 修改
     * @param Request $request
     */
    public function update($uuid)
    {
        //获取请求参数
        $data=$this->getData(["name"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["uuid"=>$uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'uuid' => 'required|max:32|min:32',
            "name"=>'required|max:100|min:1',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $this->roles_business->update($uuid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
    }

    /***
     * 设置是否公开
     * @param $uuid
     */
    public function setting($uuid)
    {
        //定义验证规则
        $validator = Validator::make(["uuid"=>$uuid],[
            'uuid' => 'required|max:32|min:32',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $rs=$this->roles_business->setting($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功",$rs);

    }

    /***
     * 删除角色
     */
    public function  delete($uuid)
    {
        //定义验证规则
        $validator = Validator::make(["uuid"=>$uuid],[
            'uuid' => 'required|max:32|min:32',
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $this->roles_business->delete($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"删除成功");
    }


    /***
     * 角色权限详情
     * @param $roleid
     */
    public  function  auth($roleid)
    {
        //获取列表数据
        $dataSource=$this->getAuthListData($roleid);
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.roles.auth',compact('list'))->with("errorMsg",$errorMsg);
    }
    /***
     * 角色权限详情数据包
     * @param $roleid
     */
    public function getAuthListData($roleid)
    {
        //验证规则
        $validator = Validator::make(["roleid"=>$roleid],[
            'roleid' => 'required|numeric'
        ],['roleid.required'=>'参数为空错误','roleid.numeric'=>'参数错误非int类型',]);
        //进行验证
        if ($validator->fails()) {
           return responseCData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        return $this->roles_business->auth($roleid);
    }



    /***
     * 勾选角色权限 - 执行
     */
    public  function  updateAuth($roleid)
    {
        //获取请求参数
        $data=$this->getData(["funcislook"],$this->request->all());
        $validateData=array_merge(["roleid"=>$roleid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'roleid' => 'required|numeric',
            "funcislook"=>'present',
        ],['roleid.required'=>'uuid参数为空错误','roleid.numeric'=>'参数错误非int类型',
            'funcislook.present'=>'菜单权限勾选参数缺少']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //获取业务数据
        $this->roles_business->updateAuth($roleid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"勾选成功");
    }
}
