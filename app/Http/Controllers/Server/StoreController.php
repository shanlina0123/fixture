<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\AdminBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/***
 * 门店管理
 * Class StoreController
 * @package App\Http\Controllers\Server
 */
class StoreController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $store_business;
    protected $request;
    public function __construct(Request $request)
    {
        $this->store_business =  new StoreBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取门店列表
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
        return view('server.store.index',compact('list'))->with("errorMsg",$errorMsg);
    }

    /***
     * 获取列表数据集
     */
    public  function  getListData()
    {
        //获取请求参数
        $data=$this->getData(["name"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "name"=>'max:100|min:0',
        ],['name.max'=>'姓名长度不能大于100个字符','name.min'=>'姓名长度不能小于1个字符']);
        //进行验证
        if ($validator->fails()) {
            return responseCData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        $page=$this->request->input("page");

        //用户信息
        $user=getUserInfo();
        //非管理员参数验证
        if($user->isadmin==0) {
            if (strlen($user->companyid) == 0 ||
                strlen($user->cityid) == 0 ||
                strlen($user->storeid) == 0
            ) {
                return  responseCData(\StatusCode::PARAM_ERROR,"用户信息不完整",null);
            }
        }

        $list=$this->store_business->index($user->isadmin,$user->companyid,$user->cityid,$user->storeid,$user->islook,$page,$data);
        return   responseCData(\StatusCode::SUCCESS,"",$list);
    }





    /***
     * 新增 - 执行
     * 测试：
     */
    public  function  store()
    {
        //获取请求参数
        $data=$this->getData(["cityid","name"],$this->request->all());
        //验证规则
        $validator = Validator::make($data,[
            "cityid"=>'required|numeric',
            "name"=>'required|max:100|min:1',
            "addr"=>'present|max:100|min:1'
        ],['cityid.required'=>'城市id不能为空','cityid.numeric'=>'城市id只能是数字格式',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符',
            'addr.present'=>'地址不能缺少','addr.max'=>'地址长度不能大于100个字符','addr.min'=>'地址长度不能小于1个字符',
            ]);
        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }
        //用户信息
        $user=getUserInfo();

        //执行业务处理
        $this->store_business->store($user->companyid,$user->cityid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"新增成功");
    }


    /***
     * 修改- 执行
     */
    public  function  update($uuid)
    {
        //获取请求参数
        $data=$this->getData(["cityid","name"],$this->request->all());
        //拼接验证数据集
        $validateData=array_merge(["uuid"=>$uuid],$data);

        //定义验证规则
        $validator = Validator::make($validateData,[
            "uuid"=>'required|max:32|min:1',
            "cityid"=>'required|numeric',
            "name"=>'required|max:100|min:1',

        ],['uuid.required'=>'uuid不能为空','uuid.max'=>'uuid长度不能大于32个字符','uuid.min'=>'姓名长度不能小于1个字符',
            'cityid.required'=>'市id不能为空','cityid.numeric'=>'市id只能是数字格式',
            'name.required'=>'名称不能为空','name.max'=>'名称长度不能大于100个字符','name.min'=>'名称长度不能小于1个字符',]);

        //进行验证
        if ($validator->fails()) {
            responseData(\StatusCode::PARAM_ERROR,"验证失败","",$validator->errors());
        }

        //获取业务数据
        $this->store_business->update($uuid,$data);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"修改成功");
    }


    /***
     * 删除用户
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
        $this->store_business->delete($uuid);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"删除成功");
    }
}
