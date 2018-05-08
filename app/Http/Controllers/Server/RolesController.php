<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\RolesBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
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
        $list = $this->roles_business->index();
        return view('server.roles.index',compact('list'));

    }

    /***
     * 角色详情
     * @param $uuid
     */
    public function edit($uuid)
    {
        //验证规则
        $validator = Validator::make(["uuid"=>$uuid],[
            'uuid' => 'required|max:32|min:32'
        ],['uuid.required'=>'参数错误','uuid.max'=>'参数错误','uuid.min'=>'参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $data=$this->roles_business->edit($uuid);
        //接口返回结果
        return view('server.roles.edit',compact('data'));
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
     * 执行 - 修改活动
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
        $this->roles_business->setting($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功");

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
     * @param $uuid
     */
    public function authEdit($role_uuid)
    {
        //验证规则
        $validator = Validator::make(["role_uuid"=>$role_uuid],[
            'role_uuid' => 'required|max:32|min:32'
        ],['role_uuid.required'=>'参数为空错误','role_uuid.max'=>'参数max错误','role_uuid.min'=>'参数min错误',]);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //获取业务数据
        $data=$this->roles_business->authEdit($role_uuid);
        //接口返回结果
        return view('server.roles.authEdit',compact('data'));
    }



    /***
     * 勾选角色权限 - 执行
     */
    public  function  updateAuth($role_uuid)
    {
        //获取请求参数
        $data=$this->getData(["functionid","islook"],$this->request->all());
        $validateData=array_merge(["role_uuid"=>$role_uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            'role_uuid' => 'required|max:32|min:32',
            "functionid"=>'required',
            "islook"=>"required|numeric"
        ],['role_uuid.required'=>'uuid参数为空错误','role_uuid.max'=>'uuid参数max错误','role_uuid.min'=>'uuid参数min错误',
            'functionid.required'=>'functionid参数为空错误',
            'islook.required'=>'视野参数为空错误','islook.numeric'=>'视野参数只能是int',]);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //数组 int验证 updateorcreate
        if(!checkParam($data["functionid"],"is_array_int"))
        {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",["functionid"=>["functionid参数格式错误"]]);
        }

        if(strlen($data["islook"])>0)
        {
            if(!in_array($data["islook"],[0,1]))
            {
                responseData(\StatusCode::PARAM_ERROR,"验证失败","",["islook"=>["islook参数非预定义"]]);
            }
        }
        //获取业务数据
        $this->auth_service->updateAuth($role_uuid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"勾选成功");
    }
}
