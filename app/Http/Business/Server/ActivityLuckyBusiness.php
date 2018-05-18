<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Activity\ActivityLucky;
use App\Http\Model\Activity\ActivityLuckyPrize;
use App\Http\Model\Company\Company;
use App\Http\Model\Data\PrizeLevel;
use App\Http\Model\Store\Store;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Support\Facades\Cache;
use App\Http\Model\Data\Participatory;
use Illuminate\Support\Facades\DB;

class ActivityLuckyBusiness extends ServerBase
{
    //请求
    protected  $request;
    //session
    protected  $sessionUser;
    //redis配置
    protected  $redisTag;
    protected  $redisKey;
    protected  $redisTimeout;

    public function  __construct($request)
    {
        $this->request = $request;
    }

    /***
     * 获取列表
     * @return mixed
     */
    public function index($isadmin,$companyid,$cityid,$storeid,$islook,$page,$data,$tag="AcitivityLucky-PageList",$tag1="Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $where=lookWhere($isadmin,$companyid,$cityid,$storeid,$islook);

        $tagKey = base64_encode(mosaic("", $tag,$companyid,$cityid,$storeid,$islook,$page));
        //redis缓存返回
        $list["luckyList"]= Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($isadmin,$storeid,$where,$data,$tag1) {
            //查詢
            $queryModel=ActivityLucky::orderBy('id', 'asc');
            //视野条件
            if($isadmin==0){
                $queryModel=$queryModel->where($where);
                if($storeid!==$data["storeid"])
                {
                    unset($data["storeid"]);
                }
            }
            if($data)
            {
                $searchTitle=searchFilter($data['title']);
                $searchIspublic=$data["ispublic"];
                $searchStoreid=$data["storeid"];
                if($searchTitle)
                {
                    $queryModel =$queryModel->where("title","like","%$searchTitle%");
                }
                if(strlen($searchIspublic)>0)
                {
                    $queryModel =$queryModel->where("ispublic",$searchIspublic);
                }
                if($searchStoreid)
                {
                    $queryModel =$queryModel->where("storeid",$searchIspublic);
                }
            }

            $list =$queryModel
                ->with(["luckyToStore" => function ($query){
                    //关联门店
                    $query->select("id", "name");
                }])
                ->orderBy('id', 'asc')
                ->paginate(config('configure.sPage'));
            return $list;
        });

        //获取门店数据
        $list["storeList"]= Cache::tags($tag1)->remember($tagKey, config('configure.sCache'), function ()  use ($isadmin,$where) {
            //查詢
            $queryModel=Store::select(DB::raw("id,name,id as storeid"));
            //视野条件
            if($isadmin==0){
                $queryModel=$queryModel->where($where);
            }
            $list =$queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });

        return  $list;
    }

    /***
     * 获取添加页面数据
     * @return mixed
     */
    public function create($isadmin,$companyid,$cityid,$storeid,$islook,$tag1="AcitivityLuck-PrizeLevel",$tag2="Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $where=lookWhere($isadmin,$companyid,$cityid,$storeid,$islook);

        //获取奖品等级数据
        $list["levelList"] =Cache::get($tag1, function () use ($tag1) {
            $storeList = PrizeLevel::select("id", "name")->get();
            Cache::put($tag1, $storeList, config('configure.sCache'));
            //返回数据库层查询结果
            return $storeList;
        });

        //获取门店数据
        $tagKey2 = base64_encode(mosaic("", $tag2, $companyid,$cityid,$storeid,$islook));
        $list["storeList"]= Cache::tags($tag2)->remember($tagKey2, config('configure.sCache'), function ()  use ($isadmin,$where) {
            //查詢
            $queryModel=Store::select(DB::raw("id,name,id as storeid"));
            //视野条件
            if($isadmin==0){
                $queryModel=$queryModel->where($where);
            }
            $list =$queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });

        return responseCData(\StatusCode::SUCCESS, "",$list);
    }

    /***
     * 获取详情
     * @return mixed
     */
    public function edit($isadmin,$companyid,$cityid,$storeid,$islook,$id,$tag="AcitivityLuck-Prize",$tag1="AcitivityLuck-PrizeLevel",$tag2="Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $where=lookWhere($isadmin,$companyid,$cityid,$storeid,$islook);
        //检测是否存在
        $list["luckData"]= ActivityLucky::where("id",$id)->first()->toArray();
        if (empty($list["luckData"])) {
            return  responseCData(\StatusCode::NOT_EXIST_ERROR, "抽奖活动不存在");
        }

        $tagKey = base64_encode(mosaic("", $tag, $id));
        //奖项数据
        $list["prizeList"]= Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($id) {
            //查詢
            $list= ActivityLuckyPrize::where("activityluckyid",$id)->orderBy('id', 'asc')->get();
            return $list?$list->toArray():[];
        });

        //获取奖品等级数据
        $list["levelList"] =Cache::get($tag1, function () use ($tag1) {
            $storeList = PrizeLevel::select("id", "name")->get();
            Cache::put($tag1, $storeList, config('configure.sCache'));
            //返回数据库层查询结果
            return $storeList;
        });

        //获取门店数据
        $tagKey2 = base64_encode(mosaic("", $tag2, $companyid,$cityid,$storeid,$islook));
        $list["storeList"]= Cache::tags($tag2)->remember($tagKey2, config('configure.sCache'), function ()  use ($isadmin,$where) {
            //查詢
            $queryModel=Store::select(DB::raw("id,name,id as storeid"));
            //视野条件
            if($isadmin==0){
                $queryModel=$queryModel->where($where);
            }
            $list =$queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });



        return responseCData(\StatusCode::SUCCESS, "",$list);
    }


    /***
     * 修改、添加 - 执行
     * @param $uuid
     */
    public function update($id,$userid,$companyid,$cityid,$data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检查管理员信息
            if($id)
            {
                $row = ActivityLucky::where("id", $id)->first();
                if (empty($row) == 0) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "抽奖活动值不存在");
                }
            }else{
                $rowExist = ActivityLucky::where("title", $data["title"])->exists();
                if ($rowExist>0) {
                    responseData(\StatusCode::EXIST_ERROR, "标题已不存在");
                }
            }

            //检查storeid是否存在
            if($data["storeid"])
            {
                $storeData = Store::where("id", $data["storeid"])->first();
                if (empty($storeData)) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "门店值不存在");
                }
            }


            //检查prizelevelid是否存在
            if($data["levelid"])
            {
                $levelData = PrizeLevel::where("id", $data["levelid"])->first();
                if (empty($levelData)) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "奖项等级不存在");
                }
            }

            //整理修改数据
            $lucky["uuid"] = create_uuid();
            $lucky["companyid"] = $companyid;//公司id
            $lucky["cityid"] = $cityid;//市id
            $lucky["userid"] = $userid;
            //基础设置
            $lucky["storeid"] = $data["storeid"];//门店id
            $lucky["title"] = $data["title"];//标题
            $lucky["resume"] = $data["resume"];//摘要 简述
            $lucky["startdate"] = $data["startdate"];//开始日期
            $lucky["enddate"]=$data["enddate"];//结束日期
            $lucky["ispeoplelimit"]=$data["ispeoplelimit"];//是否人数限制，默认 0，0不限制 1限制
            $lucky["peoplelimitnum"]=$data["ispeoplelimit"]*1==1?$data["peoplelimitnum"]:null;//限制参与的人数
            $lucky["bgurl"]=$data["bgurl"];//活动背景图
            $lucky["makeurl"]=$data["makeurl"];//立即抽奖
            $lucky["loseurl"]=$data["loseurl"];//未中奖图
           //派奖方式
            $lucky["ischancelimit"]=$data["ischancelimit"];//是否限制总抽奖机会
            $lucky["chancelimitnum"]=$data["ischancelimit"]*1==1?$data["chancelimitnum"]:null;//每人最多的抽奖机会
            $lucky["everywinnum"]=$data["everywinnum"];//每人中奖次数
            $lucky["winpoint"]=$data["winpoint"]/100;//总中奖率,例如页面 30%=0.3,这意味着每10次抽奖3次获奖
            $lucky["ishasconnectinfo"]=$data["ishasconnectinfo"];//是否有联系信息  0无（关闭） 1有（参与前填写） 2有（参与后填写）
            //高级设置
            $lucky["sharetitle"]=$data["sharetitle"];//微信分享标题
            $lucky["isonline"]=$data["isonline"];//是否上线 1上线 0下线
            $lucky["ispublic"]=$data["ispublic"]; //是否发布 1发布 0暂存
            if($id)
            {
                //修改
                $lucky["updated_at"] = date("Y-m-d H:i:s");
                $rs=ActivityLucky::where("id",$id)->update($lucky);
                $activityluckyid=$id;
            }else{
                //添加
                $lucky["created_at"] = date("Y-m-d H:i:s");
                $rslucky = ActivityLucky::create($lucky);
                $rs=$rslucky->id;
                $activityluckyid=$rslucky->id;
            }
            //奖项设置
            if(count($data["prizelist"])>0) {
                foreach ($data["prizelist"] as $k => $v) {
                    $prizeData["uuid"] = create_uuid();
                    $prizeData["companyid"] = $companyid;
                    $prizeData["storeid"] = $data["storeid"];
                    $prizeData["cityid"] = $cityid;
                    $prizeData["activityluckyid"] = $activityluckyid;
                    $prizeData["name"] = $v["name"];
                    $prizeData["levelid"] = $v["levelid"];
                    $prizeData["picture"] = $v["picture"] ? $v["picture"] : config('configure.lucky.prize.' . $v["id"]);
                    $prizeData["userid"] = $userid;
                    $prizeData["created_at"] = date("Y-m-d H:i:s");
                    $prizelist[]=$prizeData;
                }
                $rsp=ActivityLuckyPrize::insert($prizelist);
            }else{
                $rsp=1;
            }

            //结果处理
            if ($rs !== false&&$rsp!==false) {
                DB::commit();
                //删除缓存
                Cache::tags(["AcitivityLucky-PageList","AcitivityLuck-Prize"])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "修改异常");
        }
    }

    /***
     * 上线/下线
     * @param $uuid
     */
    public function setting($id)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $rowData = ActivityLucky::where("id", $id)->first();
            if (empty($rowData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }

            //整理修改数据
            $updateData["isonline"] = abs($rowData["isonline"] - 1);
            $updateData["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = ActivityLucky::where("id", $id)->update($updateData);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["AcitivityLucky-PageList","AcitivityLuck-Prize"])->flush();
                return ["isonline"=>$updateData["isonline"]];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }


    /***
     * 删除 - 执行
     */
    public  function delete($id)
    {
        try{
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row=ActivityLucky::where("id",$id)->first();
            if(empty($row))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR,"请求数据不存在,请刷新页面");
            }

            //不能删除已上线的活动。
            if($row->isonline==1&&$row->startdate<=date("Y-m-d H:i:s")&&$row->enddate>=date("Y-m-d H:i:s"))
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除已上线未过期的抽奖活动");
            }

            //删除数据
            $rs=ActivityLucky::where("id",$id)->delete();

            //结果处理
            if($rs!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["AcitivityLucky-PageList","AcitivityLuck-Prize"])->flush();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"删除失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-delete:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"删除异常");
        }
    }


    /***
     * 获取详情
     * @return mixed
     */
    public function extension($id,$userid,$companyid,$tag="AcitivityLuck-Prize")
    {
        $tagKey = base64_encode(mosaic("", $tag, $id));
        //奖项数据
        $list["prizeList"]= Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($id,$userid,$companyid) {
            //查詢
            $list= ActivityLuckyPrize::where("activityluckyid",$id)->orderBy('id', 'asc')->get();

           //获取accessToken
           $accessToken=$this->getWxAccessToken($companyid);
            //查询奖项+ 小程序二维码
            $newList=array();
            foreach($list as $k=>$v)
            {
                $newList[]=base64EncodeImage($v["picture"]);
                if($k==3)
                {
                    $newList[]=base64EncodeImage(getWxapCode($accessToken,$userid));
                }

            }
            return $newList;
        });

         //获取公司信息
        $list["companyData"]=Company::where("id",$companyid)->select("logo","fullname")->first();
        return responseCData(\StatusCode::SUCCESS, "",$list);
    }

    /***、
     * 临时获取微信小程序accessToken
     * @param $companyid
     */
    protected function getWxAccessToken($companyid)
    {

       return  SmallProgram::where("companyid",$companyid)->value("authorizer_access_token");
    }


}