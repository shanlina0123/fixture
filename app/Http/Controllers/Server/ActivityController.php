<?php

namespace App\Http\Controllers\Server;

use App\Http\Business\Server\ActivityBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/***
 * 宣传活动管理
 * Class ActivityController
 * @package App\Http\Controllers\Server
 */
class ActivityController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $activity_business;
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->activity_business = new ActivityBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取列表
     */
    public function index()
    {
        //获取列表数据
        $dataSource = $this->getListData();
        $list = $dataSource["data"];
        $errorMsg = $dataSource["messages"];
        //处理ajax请求
        if ($this->request->ajax()) {
            responseAjax($dataSource);
        }
        return view('server.activity.index', compact('list'))->with("errorMsg", $errorMsg);
    }

    /***
     * 获取列表数据集
     */
    public function getListData()
    {
        //获取请求参数
        $data = $this->getData(["title", "isonline", "storeid"], $this->request->all());
        //验证规则
        $validator = Validator::make($data, [
            "title" => 'max:200|min:0',
            "storeid" => 'numeric',
            "isonline" => 'numeric',
        ], ['title.max' => '标题长度不能大于100个字符', 'nickname.min' => '标题度不能小于0个字符',
            'storeid.numeric' => '门店id只能是数字格式',
            'isonline.numeric' => '活动状态只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            return responseCData(\StatusCode::PARAM_ERROR, "验证失败", "", $validator->errors());
        }

        if (array_key_exists("isonline", $data) && strlen($data["isonline"]) > 0) {
            if (!in_array($data["isonline"], [0, 1, 2])) {
                return responseCData(\StatusCode::PARAM_ERROR, "是否上线值不符合预定义", "");
            }
        }
        $page = $this->request->input("page");

        $list = $this->activity_business->index($this->userInfo->isadmin, $this->userInfo->companyid, $this->userInfo->cityid, $this->userInfo->storeid, $this->userInfo->islook, $page, $data);
        return responseCData(\StatusCode::SUCCESS, "", $list);
    }


    /**
     * 进入添加页面
     */
    public function create()
    {
        //获取列表数据
        $dataSource = $this->getCreateData();
        $list = $dataSource["data"];
        $errorMsg = $dataSource["messages"];
        //处理ajax请求
        if ($this->request->ajax()) {
            responseAjax($dataSource);
        }
        return view('server.activity.create', compact('list'))->with("errorMsg", $errorMsg);
    }

    /***
     * 获取添加列表数据集
     */
    public function getCreateData()
    {
        $list = $this->activity_business->create($this->userInfo->isadmin, $this->userInfo->companyid, $this->userInfo->cityid, $this->userInfo->storeid, $this->userInfo->islook);
        return responseCData(\StatusCode::SUCCESS, "", $list);
    }

    /***
     * 详情
     * @param Request $request
     */
    public function edit($id)
    {
        //获取列表数据
        $dataSource = $this->getEditData($id);
        $list = $dataSource["data"]["data"];
        $errorMsg = $dataSource["messages"];
        //处理ajax请求
        if ($this->request->ajax()) {
            responseAjax($dataSource);
        }
        if ($list["luckData"]["isonline"] == 1) {
            return view('server.activity.see', compact('list'))->with("errorMsg", $errorMsg);
        } else {
            return view('server.activity.edit', compact('list'))->with("errorMsg", $errorMsg);
        }

    }

    /***
     * 获取详情列表数据集
     */
    public function getEditData($id)
    {
        $validator = Validator::make(["id" => $id], [
            "id" => 'required|numeric',
        ], ['id.required' => '宣传活动id不能为空', 'id.numeric' => '宣传活动只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            return responseCData(\StatusCode::PARAM_ERROR, "宣传活动参数错误", "", $validator->errors());
        }

        $list = $this->activity_business->edit($this->userInfo->isadmin, $this->userInfo->companyid, $this->userInfo->cityid, $this->userInfo->storeid, $this->userInfo->islook, $id);
        return responseCData(\StatusCode::SUCCESS, "", $list);
    }

    /***
     * 执行 - 修改、添加
     * @param Request $request
     */
    public function update($id)
    {
        //获取请求参数
        $data = $this->getData(["storeid", "title", "resume", "startdate", "enddate", "bgurl", "mainurl", "isonline"], $this->request->all());
        //拼接验证数据集
        $validateData = array_merge(["id" => $id], $data);
        //验证规则
        $validator = Validator::make($validateData, [
            "id" => 'present|numeric',
            "storeid" => 'required|numeric',
            "title" => 'required|max:200|min:1',
            "resume" => 'required|max:255|min:1',
            "startdate" => 'required|date',
            "enddate" => 'required|date',
            "bgurl" => "required|string",
            "mainurl" => "present|string",
            "isonline" => 'required|max:1|min:0',
        ], ['id.required' => 'id不能为空', 'id.numeric' => 'id只能是数字格式',
            'storeid.required' => '门店id不能为空', 'storeid.numeric' => '门店id只能是数字格式',
            'title.required' => '名称不能为空', 'title.max' => '名称长度不能大于100个字符', 'title.min' => '名称长度不能小于1个字符',
            'resume.required' => '简述不能为空', 'resume.max' => '简述长度不能大于255个字符', 'resume.min' => '简述长度不能小于1个字符',
            'startdate.required' => '开始时间不能为空', 'startdate.date' => '开始时间只能是时间格式',
            'enddate.required' => '结束时间不能为空', 'enddate.date' => '结束时间只能是时间格式',
            'bgurl.required' => '封面图不能为空', 'bgurl.string' => '封面图值只能是字符串',
            'mainurl.present' => '内容图参数缺少', 'mainurl.string' => '内容图值只能是字符串',
            'isonline.required' => '是否上线不能为空', 'isonline.max' => '是否上线不能大于1', 'isonline.min' => '是否上线能小于0',
        ]);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, $validator->errors()->first(), "", $validator->errors());
        }

        //上线值验证
        if (strlen($data["isonline"]) > 0) {
            if (!in_array($data["isonline"], [0, 1])) {
                responseData(\StatusCode::PARAM_ERROR, "上线和下线值不符合预定义", "", ["isonline" => "上线和下线值不符合预定义"]);
            }
        }
        //时间验证
        if ($data["startdate"] > $data["enddate"]) {
            responseData(\StatusCode::PARAM_ERROR, "开始时间不能大于等于结束时间", "", ["startdate|enddate" => "开始时间不能大于等于结束时间"]);
        }

        //获取业务数据
        $rs = $this->activity_business->update($id, $this->userInfo->id, $this->userInfo->companyid, $data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "保存成功", $rs);
    }


    /***
     * 上线/下线
     */
    public function setting($id)
    {
        //定义验证规则
        $validator = Validator::make(["id" => $id], [
            'id' => 'required|numeric',
        ], ['id.required' => 'id参数不能为空', 'id.numeric' => 'id只能是数字格式']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, "参数错误", $validator->errors());
        }
        //获取业务数据
        $rs = $this->activity_business->setting($id);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "设置成功", $rs);
    }


    /***
     * 删除
     */
    public function delete($id)
    {
        //定义验证规则
        $validator = Validator::make(["id" => $id], [
            'id' => 'required|numeric',
        ], ['id.required' => 'id参数不能为空', 'id.numeric' => 'id只能是数字格式']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR, "参数错误", $validator->errors());
        }
        //获取业务数据
        $this->activity_business->delete($id);
        //接口返回结果
        responseData(\StatusCode::SUCCESS, "删除成功");
    }


}
