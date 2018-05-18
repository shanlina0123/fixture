<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\ActivityLuckyBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/***
 * 抽奖活动管理
 * Class ActivityLuckyController
 * @package App\Http\Controllers\Server
 */
class ActivityLuckyController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $activitylucky_business;
    protected $request;
    public function __construct(Request $request)
    {
        $this->activitylucky_business =  new ActivityLuckyBusiness($request);
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
        return view('server.activitylucky.index',compact('list'))->with("errorMsg",$errorMsg);
    }

    /***
     * 获取列表数据集
     */
    public  function  getListData()
    {
        //获取请求参数
        $data=$this->getData(["title","ispublic","storeid"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "title"=>'max:200|min:0',
            "storeid"=>'numeric',
            "ispublic"=>'numeric',
        ],['title.max'=>'标题长度不能大于100个字符','nickname.min'=>'标题度不能小于0个字符',
            'storeid.numeric'=>'门店id只能是数字格式',
            'ispublic.numeric'=>'活动状态只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            return responseCData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

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

        $list=$this->activitylucky_business->index($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook,$page,$data);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }

    /**
     * 进入添加页面
     */
    public function create()
    {
        //获取列表数据
        $dataSource=$this->getCreateData();
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.activitylucky.create',compact('list'))->with("errorMsg",json_encode($errorMsg));
    }
    /***
     * 获取添加列表数据集
     */
    public  function  getCreateData()
    {
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

        return $this->activitylucky_business->create($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook);

    }

    /***
     * 详情
     * @param Request $request
     */
    public function edit($id)
    {
        //获取列表数据
        $dataSource=$this->getEditData($id);
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.activitylucky.edit',compact('list'))->with("errorMsg",json_encode($errorMsg));
    }

    /***
     * 获取详情列表数据集
     */
    public  function  getEditData($id)
    {
        $validator = Validator::make(["id"=>$id],[
            "id"=>'required|numeric',
        ],['id.required'=>'抽奖活动id不能为空','id.numeric'=>'抽奖活动只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            return  responseCData(\StatusCode::PARAM_ERROR,"抽奖活动参数错误","",$validator->errors());
        }
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

        return $this->activitylucky_business->edit($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook,$id);

    }

    /***
     * 执行 - 修改、添加
     * @param Request $request
     */
    public function update($id)
    {
        //获取请求参数
        $data=$this->getData(["storeid","title","resume","startdate","enddate","ispeoplelimit","peoplelimitnum","bgurl","winurl","loseurl",
            "ischancelimit","chancelimitnum","everywinnum","winpoint","ishasconnectinfo",
            "prizelist",
            "sharetitle","isonline","ispublic"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["id"=>$id],$data);

        //验证规则
        $validator = Validator::make($validateData,[
            "id"=>'present|numeric',
            "storeid"=>'required|numeric',
            "title"=>'required|max:200|min:1',
            "resume"=>'required|max:255|min:1',
            "startdate"=>'required|date',
            "enddate"=>'required|date',
            "ispeoplelimit"=>'required|max:1|min:0',
            "peoplelimitnum"=>'required|numeric',
            "bgurl"=>"string",
            "loseurl"=>"string",
            "ischancelimit"=>'required|max:1|min:0',
            "chancelimitnum"=>'required|numeric',
            "everywinnum"=>'required|numeric',
            "winpoint"=>'required|numeric',
            "ishasconnectinfo"=>'required|max:2|min:1',
            "prizelist"=>"present",
            "sharetitle"=>"string",
            "isonline"=>'required|max:1|min:0',
            "ispublic"=>'required|max:1|min:0',
        ],['id.required'=>'id不能为空','id.numeric'=>'id只能是数字格式',
            'storeid.required'=>'门店id不能为空','storeid.numeric'=>'门店id只能是数字格式',
            'title.required'=>'名称不能为空','title.max'=>'名称长度不能大于100个字符','title.min'=>'名称长度不能小于1个字符',
            'resume.required'=>'简述不能为空','resume.max'=>'简述长度不能大于255个字符','resume.min'=>'简述长度不能小于1个字符',
            'startdate.required'=>'开始时间不能为空','startdate.date'=>'开始时间只能是时间格式',
            'enddate.required'=>'结束时间不能为空','enddate.date'=>'结束时间只能是时间格式',
            'ispeoplelimit.required'=>'是否人数限制不能为空','ispeoplelimit.max'=>'是否人数不能大于1','ispeoplelimit.min'=>'是否人数不能小于0',
            'peoplelimitnum.required'=>'人数不能为空','peoplelimitnum.numeric'=>'人数限制只能是数字格式',
            'bgurl.string'=>'活动背景图只能是字符串',
            'loseurl.string'=>'活动背景图只能是字符串',
            'ischancelimit.required'=>'是否限制总抽奖机会不能为空','ischancelimit.max'=>'是否限制总抽奖机会不能大于1','ischancelimit.min'=>'是否限制总抽奖机会不能小于0',
            'chancelimitnum.required'=>'每人最多的抽奖机会不能为空','chancelimitnum.numeric'=>'每人最多的抽奖机会只能是数字格式',
            'everywinnum.required'=>'每人中奖次数不能为空','everywinnum.numeric'=>'每人中奖次数只能是数字格式',
            'winpoint.required'=>'总中奖率不能为空','winpoint.numeric'=>'总中奖率只能是数字格式',
            'ishasconnectinfo.required'=>'联系信息填写位置标识不能为空','ishasconnectinfo.max'=>'联系信息填写位置标识不能大于2','ishasconnectinfo.min'=>'联系信息填写位置标识不能小于1',
            'prizelist.present'=>'微信分享标题只能是字符串',
            'sharetitle.string'=>'微信分享标题只能是字符串',
            'isonline.required'=>'是否上线不能为空','isonline.max'=>'是否上线不能大于1','isonline.min'=>'是否上线能小于0',
            'ispublic.required'=>'是否发布不能为空','ispublic.max'=>'是否发布不能大于1','ispublic.min'=>'是否发布不能小于0',
        ]);

        //默认值
        $data["bgurl"]=$data["bgurl"]?$data["bgurl"]:config('configure.lucky.bgurl');
        $data["makeurl"]=$data["makeurl"]?$data["makeurl"]:config('configure.lucky.makeurl');
        $data["loseurl"]=$data["loseurl"]?$data["loseurl"]:config('configure.lucky.loseurl');
        $data["sharetitle"]=$data["sharetitle"]?$data["sharetitle"]:$data["title"];

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //用户信息
        $user=getUserInfo();
        //非管理员参数验证
        if (strlen($user->companyid) == 0 || $user->companyid==0) {
            responseData(\StatusCode::PARAM_ERROR,"用户信息不完整",null);
        }

        //获取业务数据
        $rs=$this->activitylucky_business->update($id,$user->id,$user->companyid,$user->cityid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功",$rs);
    }



    /***
     * 上线/下线
     */
    public function  setting($id)
    {
        //定义验证规则
        $validator = Validator::make(["id"=>$id],[
            'id' => 'required|numeric',
        ],['id.required'=>'参数错误','id.numeric'=>'id只能是数字格式']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $rs=$this->activitylucky_business->setting($id);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"设置成功",$rs);
    }


    /***
     * 删除
     */
    public function  delete($id)
    {
        //定义验证规则
        $validator = Validator::make(["id"=>$id],[
            'id' => 'required|numeric',
        ],['id.required'=>'参数错误','id.numeric'=>'id只能是数字格式']);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        //获取业务数据
        $this->activitylucky_business->delete($id);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"删除成功");
    }


    /***
     * 推广详情
     * @param Request $request
     */
    public function extension($id)
    {
        //获取列表数据
        $dataSource=$this->extensionData($id);
        $list=$dataSource["data"];
        $errorMsg=$dataSource["messages"];
        //处理ajax请求
        if($this->request->ajax()){
            responseAjax($dataSource);
        }
        return view('server.activitylucky.extension',compact('list'))->with("errorMsg",json_encode($errorMsg));
    }


    /***
     * 推广详情数据
     */
    public function extensionData($id)
    {
        $validator = Validator::make(["id"=>$id],[
            "id"=>'required|numeric',
        ],['id.required'=>'抽奖活动id不能为空','id.numeric'=>'抽奖活动id只能是数字格式']);
        //进行验证
        if ($validator->fails()) {
            return  responseCData(\StatusCode::PARAM_ERROR,"抽奖活动参数错误","",$validator->errors());
        }
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

        return $this->activitylucky_business->extension($id,$user->userid,$user->companyid,$id);
    }


    /***
     * 预览
     */
    public  function  show(){

    }
}
