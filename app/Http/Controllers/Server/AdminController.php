<?php

namespace App\Http\Controllers\Server;

use App\Http\Business\Server\AdminBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/***
 * 用户管理
 * Class AdminController
 * @package App\Http\Controllers\Server
 */
class AdminController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $admin_business;
    protected $request;
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->admin_business = new AdminBusiness($request);
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
        if ($this->request->ajax()) {
            responseAjax($dataSource);
        }
        return view('server.admin.index', compact('list'))->with("errorMsg", $errorMsg);
    }

    /***
     * 获取列表数据集
     */
    public function getListData()
    {
        //获取请求参数
        $data = $this->getData(["nickname", "storeid"], $this->request->all());
        //验证规则
        $validator = Validator::make($data, [
            "nickname" => 'max:100|min:0',
            "storeid" => 'numeric',
        ], ['nickname.max' => '姓名长度不能大于100个字符', 'nickname.min' => '姓名长度不能小于0个字符',
            'storeid.numeric' => '门店id只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            return responseCData(\StatusCode::PARAM_ERROR, "验证失败", "", $validator->errors());
        }
        //分页页码
        $page = $this->request->input("page");
        //业务调用
        $list = $this->admin_business->index($this->userInfo->isadmin, $this->userInfo->companyid, $this->userInfo->cityid, $this->userInfo->storeid, $this->userInfo->islook, $page, $data);
        //返回
        return responseCData(\StatusCode::SUCCESS, "", $list);
    }


    /***
     * 新增 - 执行
     * 测试：
     * password=base64:  123456=MTIzNDU2
     * uuid=90dabbc63afd11e8a35594de807e34a0
     */
    public function store()
    {
        //获取请求参数
        $data = $this->getData(["nickname", "username","password", "storeid", "roleid", "status"], $this->request->all());
        //验证规则
        $validator = Validator::make($data, [
            "nickname" => 'required|max:100|min:1',
            "username" => 'required|max:20|min:3',
            "password" => 'required|max:12|min:6',
            "roleid" => 'required|numeric',
            'storeid' => 'present|numeric',
            "status" => 'required|numeric',
        ], ['nickname.required' => '姓名不能为空', 'nickname.max' => '姓名长度不能大于100个字符', 'nickname.min' => '姓名长度不能小于1个字符',
            'username.required' => '账号不能为空', 'username.max' => '账号长度不能大于20个字符', 'username.min' => '账号长度不能小于3个字符',
            'password.required' => '密码不能为空', 'password.max' => '密码长度不能大于12个字符', 'password.min' => '密码长度不能小于6个字符',
            'roleid.required' => '角色不能为空', 'roleid.numeric' => '角色只能是数字格式',
            'storeid.present' => '门店参数缺少', 'storeid.numeric' => '门店只能是数字格式',
            'status.required' => '锁定不能为空', 'status.numeric' => '锁定只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, "验证失败", "", $validator->errors());
        }

        //密码
        if (!preg_match_all("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$$/",$data["password"],$array))
        {
            responseData(\StatusCode::PARAM_ERROR, "密码格式错误,请输入6-12位字母+数字(区分大小写)", "", ["password" => ["密码格式错误"]]);
        }

        //检测锁定值是否符合预定义
        if (!in_array($data["status"], [0, 1])) {
            responseData(\StatusCode::PARAM_ERROR, "验证失败", "", ["status" => ["锁定值不符合预定义"]]);
        }

        //非管理员
        if($data["roleid"]>1)
        {
            if(!$data["storeid"]){
                responseData(\StatusCode::PARAM_ERROR, "非公司管理员，门店不能为空", "", ["password" => ["非公司管理员，门店不能为空"]]);
            }
        }

        //执行业务处理
        $this->admin_business->store($this->userInfo->companyid, $data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "新增成功");
    }


    /***
     * 修改用户 - 执行
     * base64: 123456=MTIzNDU2Nw==
     */
    public function update($uuid)
    {
        //获取请求参数
        $data = $this->getData(["nickname", "username","password", "storeid", "roleid", "status"], $this->request->all());
        //拼接验证数据集
        $validateData = array_merge(["uuid" => $uuid], $data);

        //定义验证规则
        $validator = Validator::make($validateData, [
            "nickname" => 'required|max:100|min:1',
            "username" => 'required|max:20|min:3',
            "password" => 'required|max:12|min:6',
            "roleid" => 'required|numeric',
            'storeid' => 'present|numeric',
            "status" => 'required|numeric',
        ], ['nickname.required' => '姓名不能为空', 'nickname.max' => '姓名长度不能大于100个字符', 'nickname.min' => '姓名长度不能小于1个字符',
            'username.required' => '账号不能为空', 'username.max' => '账号长度不能大于20个字符', 'username.min' => '账号长度不能小于3个字符',
            'password.required' => '密码不能为空', 'password.max' => '密码长度不能大于12个字符', 'password.min' => '密码长度不能小于6个字符',
            'roleid.required' => '角色不能为空', 'roleid.numeric' => '角色只能是数字格式',
            'storeid.required' => '门店不能为空', 'storeid.numeric' => '门店只能是数字格式',
            'status.required' => '锁定不能为空', 'status.numeric' => '锁定只能是数字格式']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, "验证失败", "", $validator->errors());
        }

        //密码
        if (!preg_match_all("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$$/",$data["password"],$array))
        {
            responseData(\StatusCode::PARAM_ERROR, "密码格式错误,请输入6-12位字母+数字(区分大小写)", "", ["password" => ["密码格式错误"]]);
        }

         //状态检测
        if (!in_array($data["status"], [0, 1])) {
            responseData(\StatusCode::PARAM_ERROR, "验证失败", "", ["status" => ["状态只能设置为有效和无效，不能进行其他设置"]]);
        }

        //获取业务数据
        $this->admin_business->update($uuid, $data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "修改成功");
    }

    /***
     * 禁用/启用
     */
    public function setting($uuid)
    {
        //定义验证规则
        $validator = Validator::make(["uuid" => $uuid], [
            'uuid' => 'required|max:32|min:32',
        ], ['uuid.required' => '参数错误', 'uuid.max' => '参数错误', 'uuid.min' => '参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, "参数错误");
        }
        //获取业务数据
        $rs = $this->admin_business->setting($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "设置成功", $rs);
    }


    /***
     * 删除用户
     */
    public function delete($uuid)
    {
        //定义验证规则
        $validator = Validator::make(["uuid" => $uuid], [
            'uuid' => 'required|max:32|min:32',
        ], ['uuid.required' => '参数错误', 'uuid.max' => '参数错误', 'uuid.min' => '参数错误']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, "参数错误");
        }
        //获取业务数据
        $this->admin_business->delete($this->userInfo->id,$uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "删除成功");
    }
}
