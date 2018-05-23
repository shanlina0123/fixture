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
use Illuminate\Support\Facades\Log;

class ActivityLuckyBusiness extends ServerBase
{
    //请求
    protected $request;
    //session
    protected $sessionUser;
    //redis配置
    protected $redisTag;
    protected $redisKey;
    protected $redisTimeout;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /***
     * 获取列表
     * @return mixed
     */
    public function index($isadmin, $companyid, $cityid, $storeid, $islook, $page, $data, $tag = "AcitivityLucky-PageList", $tag1 = "Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $where = lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);

        $tagKey = base64_encode(mosaic("", $tag, $companyid, $cityid, $storeid, $islook, $page));
        //redis缓存返回
        $list["luckyList"] = Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($isadmin, $storeid, $where, $data, $tag1) {
            //查詢
            $queryModel = ActivityLucky::orderBy('id', 'asc');
            //视野条件
            if ($isadmin == 0) {
                $queryModel = $queryModel->where($where);
                if ($storeid !== $data["storeid"]) {
                    unset($data["storeid"]);
                }
            }
            if ($data) {
                $searchTitle = searchFilter($data['title']);
                $searchIspublic = $data["ispublic"];
                $searchStoreid = $data["storeid"];
                if ($searchTitle) {
                    $queryModel = $queryModel->where("title", "like", "%$searchTitle%");
                }
                if (strlen($searchIspublic) > 0) {
                    $queryModel = $queryModel->where("ispublic", $searchIspublic);
                }
                if ($searchStoreid) {
                    $queryModel = $queryModel->where("storeid", $searchIspublic);
                }
            }

            $list = $queryModel
                ->with(["luckyToStore" => function ($query) {
                    //关联门店
                    $query->select("id", "name");
                }])
                ->orderBy('id', 'asc')
                ->paginate(config('configure.sPage'));
            return $list;
        });

        //获取门店数据
        $list["storeList"] = Cache::tags($tag1)->remember($tagKey, config('configure.sCache'), function () use ($isadmin, $where) {
            //查詢
            $queryModel = Store::select(DB::raw("id,name,id as storeid"));
            //视野条件
            if ($isadmin == 0) {
                $queryModel = $queryModel->where($where);
            }
            $list = $queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });

        return $list;
    }

    /***
     * 获取添加页面数据
     * @return mixed
     */
    public function create($isadmin, $companyid, $cityid, $storeid, $islook, $tag1 = "AcitivityLuck-PrizeLevel", $tag2 = "Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $where = lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);

        //获取奖品等级数据
        $list["levelList"] = Cache::get($tag1, function () use ($tag1) {
            $storeList = PrizeLevel::select("id", "name")->get();
            Cache::put($tag1, $storeList, config('configure.sCache'));
            //返回数据库层查询结果
            return $storeList;
        });

        //获取门店数据
        $tagKey2 = base64_encode(mosaic("", $tag2, $companyid, $cityid, $storeid, $islook));
        $list["storeList"] = Cache::tags($tag2)->remember($tagKey2, config('configure.sCache'), function () use ($isadmin, $where) {
            //查詢
            $queryModel = Store::select(DB::raw("id,name,id as storeid"));
            //视野条件
            if ($isadmin == 0) {
                $queryModel = $queryModel->where($where);
            }
            $list = $queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });

        return responseCData(\StatusCode::SUCCESS, "", $list);
    }

    /***
     * 获取详情
     * @return mixed
     */
    public function edit($isadmin, $companyid, $cityid, $storeid, $islook, $id, $tag = "AcitivityLuck-Prize", $tag1 = "AcitivityLuck-PrizeLevel", $tag2 = "Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $where = lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        //检测是否存在
        $list["luckData"] = ActivityLucky::where("id", $id)->first()->toArray();
        if (empty($list["luckData"])) {
            return responseCData(\StatusCode::NOT_EXIST_ERROR, "抽奖活动不存在");
        }
        $list["luckData"]["winpoint"] = $list["luckData"]["winpoint"] * 100;
        $list["luckData"]["companyname"] = Company::where("id", $companyid)->value("name");

        $tagKey = base64_encode(mosaic("", $tag, $id));
        //奖项数据
        $list["prizeList"] = Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($id) {
            //查詢
            $list = ActivityLuckyPrize::where("activityluckyid", $id)->orderBy('id', 'asc')->get();
            return $list ? $list->toArray() : [];
        });

        //获取奖品等级数据
        $list["levelList"] = Cache::get($tag1, function () use ($tag1) {
            $storeList = PrizeLevel::select("id", "name")->get();
            Cache::put($tag1, $storeList, config('configure.sCache'));
            //返回数据库层查询结果
            return $storeList;
        });

        //获取门店数据
        $tagKey2 = base64_encode(mosaic("", $tag2, $companyid, $cityid, $storeid, $islook));
        $list["storeList"] = Cache::tags($tag2)->remember($tagKey2, config('configure.sCache'), function () use ($isadmin, $where) {
            //查詢
            $queryModel = Store::select(DB::raw("id,name,id as storeid"));
            //视野条件
            if ($isadmin == 0) {
                $queryModel = $queryModel->where($where);
            }
            $list = $queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });


        return responseCData(\StatusCode::SUCCESS, "", $list);
    }


    /***
     * 修改、添加 - 执行
     * @param $uuid
     */
    public function update($id, $userid, $companyid, $cityid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理

            //检查活动、标题
            if ($id) {

                //检查活动
                $rowData = ActivityLucky::where("id", $id)->first();
                if (!$rowData) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "该活动不存在");
                }

                //检查标题
                $rowExist = ActivityLucky::where("id", "!=", $id)->where("title", $data["title"])->exists();
                if ($rowExist > 0) {
                    responseData(\StatusCode::EXIST_ERROR, "标题已存在");
                }
            } else {
                //检查标题
                $rowExist = ActivityLucky::where("title", $data["title"])->exists();
                if ($rowExist > 0) {
                    responseData(\StatusCode::EXIST_ERROR, "标题已存在");
                }
            }

            //检查storeid是否存在
            if ($data["storeid"]) {
                $storeData = Store::where("id", $data["storeid"])->first();
                if (empty($storeData)) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "门店值不存在");
                }
            }

            //业务处理
            $createUuid = create_uuid();
            if ($data["bgurl"]) {
                $bgurl = $this->tmpToUploads($createUuid, $data["bgurl"], "lucky");
                if (!$bgurl) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "活动背景图上传错误，请重新上传");
                }
            }
            if ($data["makeurl"]) {
                $makeurl = $this->tmpToUploads($createUuid, $data["makeurl"], "lucky");
                if (!$makeurl) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "立即抽奖图上传错误，请重新上传");
                }
            }
            if ($data["loseurl"]) {
                $loseurl = $this->tmpToUploads($createUuid, $data["loseurl"], "lucky");
                if (!$loseurl) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "未中奖图上传错误，请重新上传");
                }
            }
            //整理修改数据
            $lucky["uuid"] = $createUuid;
            $lucky["companyid"] = $companyid;//公司id
            $lucky["cityid"] = $cityid;//市id
            $lucky["userid"] = $userid;
            //基础设置
            $lucky["storeid"] = $data["storeid"];//门店id
            $lucky["title"] = $data["title"];//标题
            $data["resume"] ? $lucky["resume"] = $data["resume"] : "";//摘要 简述
            $data["startdate"] ? $lucky["startdate"] = $data["startdate"] : "";//开始日期
            $data["enddate"] ? $lucky["enddate"] = $data["enddate"] : "";//结束日期
            $lucky["ispeoplelimit"] = $data["ispeoplelimit"];//是否人数限制，默认 0，0不限制 1限制
            $lucky["peoplelimitnum"] = $data["ispeoplelimit"] * 1 == 1 ? abs($data["peoplelimitnum"]) : 0;//限制参与的人数
            //派奖方式
            $lucky["ischancelimit"] = $data["ischancelimit"];//是否限制总抽奖机会
            $lucky["chancelimitnum"] = $data["ischancelimit"] * 1 == 1 ? abs($data["chancelimitnum"]) : 0;//每人最多的抽奖机会
            $data["everywinnum"] ? $lucky["everywinnum"] = abs($data["everywinnum"]) : "";//每人中奖次数
            $data["winpoint"] ? $lucky["winpoint"] = abs($data["winpoint"]) * 1 / 100 : "";//总中奖率,例如页面 30%=0.3,这意味着每10次抽奖3次获奖
            $lucky["ishasconnectinfo"] = $data["ishasconnectinfo"];//是否有联系信息  0无（关闭） 1有（参与前填写） 2有（参与后填写）
            //高级设置
            $lucky["sharetitle"] = $data["sharetitle"] ? $data["sharetitle"] : $data["title"];//微信分享标题
            $lucky["isonline"] = $data["isonline"];//是否上线 1上线 0下线
            if ($id) {
                //修改
                $data["bgurl"] ? $lucky["bgurl"] = $bgurl : "";//活动背景图
                $data["makeurl"] ? $lucky["makeurl"] = $makeurl : "";//立即抽奖
                $data["loseurl"] ? $lucky["loseurl"] = $loseurl : "";;//未中奖图
                $lucky["updated_at"] = date("Y-m-d H:i:s");
                $rs = ActivityLucky::where("id", $id)->update($lucky);
                $activityluckyid = $id;
            } else {
                //添加
                $lucky["bgurl"] = $data["bgurl"] ? $bgurl : config('configure.lucky.bgurl');//活动背景图
                $lucky["makeurl"] = $data["makeurl"] ? $makeurl : config('configure.lucky.makeurl');//立即抽奖
                $lucky["loseurl"] = $data["loseurl"] ? $loseurl : config('configure.lucky.loseurl');//未中奖图
                $lucky["created_at"] = date("Y-m-d H:i:s");
                $rslucky = ActivityLucky::create($lucky);
                $rs = $rslucky->id;
                $activityluckyid = $rslucky->id;
            }
            //奖项设置
            //检查存在
            if (count($data["prizelist"]) > 0) {
                $levelids = array_column($data["prizelist"], "levelid", null);
                if (count($levelids) != count(array_unique($levelids))) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "奖项等级重复，请重新选择");
                }
                //检查prizelevelid是否存在
                if ($levelids) {
                    $levelListData = PrizeLevel::whereIn("id", $levelids)->get()->toArray();
                    if (count($levelListData) !== count($levelids)) {
                        responseData(\StatusCode::NOT_EXIST_ERROR, "奖项等级存在未定义的数值,请刷新页面或移除错误未定义的数值");
                    }
                    $levelListData = array_column($levelListData, null, "id");
                }

                foreach ($data["prizelist"] as $k => $v) {
                    $levelids[] = $v["levelid"] * 1;
                    if ($v["picture"]) {
                        $picture = $this->tmpToUploads($createUuid, $v["picture"], "lucky");
                        if (!$picture) {
                            responseData(\StatusCode::NOT_EXIST_ERROR, $v["name"] . "的奖项图上传错误，请重新上传");
                        }
                        $pictures[$v["levelid"]] = $picture;
                    }
                }

                //添加
                $defaultPrizeImg=config('configure.lucky.prize');
                foreach ($data["prizelist"] as $k => $v) {
                    $prizeData = array();
                    if ($v["id"]) {
                        $prizeData["uuid"] = create_uuid();
                        $prizeData["companyid"] = $companyid;
                        $prizeData["storeid"] = $data["storeid"];
                        $prizeData["cityid"] = $cityid;
                        $prizeData["activityluckyid"] = $activityluckyid;
                        $prizeData["name"] = $v["name"];
                        $prizeData["num"] = $v["num"];
                        $prizeData["levelid"] = $v["levelid"];
                        $prizeData["levelname"] = $levelListData[$v["levelid"]]["name"];
                        $v["picture"] ? $prizeData["picture"] = $pictures[$v["levelid"]] : "";
                        $prizeData["userid"] = $userid;
                        $prizeData["updated_at"] = date("Y-m-d H:i:s");
                        $rsp[] = ActivityLuckyPrize::where("id", $v["id"])->update($prizeData);
                        $prizeIds[$v["levelid"]] = $v["id"];

                    } else {
                        //添加
                        $prizeData["uuid"] = create_uuid();
                        $prizeData["companyid"] = $companyid;
                        $prizeData["storeid"] = $data["storeid"];
                        $prizeData["cityid"] = $cityid;
                        $prizeData["activityluckyid"] = $activityluckyid;
                        $prizeData["name"] = $v["name"];
                        $prizeData["num"] = $v["num"];
                        $prizeData["levelid"] = $v["levelid"];
                        $prizeData["levelname"] = $levelListData[$v["levelid"]]["name"];
                        $prizeData["picture"] = $v["picture"]? $pictures[$v["levelid"]] : $defaultPrizeImg[$v["levelid"]];
                        $prizeData["userid"] = $userid;
                        $prizeData["created_at"] = date("Y-m-d H:i:s");
                        $rspResult = ActivityLuckyPrize::create($prizeData);
                        $rsp[] = $rspResult->id;
                        $prizeIds[$v["levelid"]] = $rspResult->id;
                    }
                }

            } else {
                $rsp[] = 1;
                $prizeIds=[];
            }
            //结果处理
            if ($rs !== false && !in_array(false, $rsp, true)) {
                DB::commit();
                //删除缓存
                Cache::tags(["AcitivityLucky-PageList", "AcitivityLuck-Prize"])->flush();
                return ["id" => $activityluckyid, "prizeIds" => $prizeIds, "isonline" => $lucky["isonline"], "listurl" => route("lucky-index")];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "保存失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "保存异常");
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
                Cache::tags(["AcitivityLucky-PageList", "AcitivityLuck-Prize"])->flush();
                return ["isonline" => $updateData["isonline"]];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-setting:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }


    /***
     * 删除 - 执行
     */
    public function delete($id)
    {
        try {
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row = ActivityLucky::where("id", $id)->first();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }

            //不能删除已上线的活动。
            if ($row->isonline == 1 && $row->startdate <= date("Y-m-d H:i:s") && $row->enddate >= date("Y-m-d H:i:s")) {
                responseData(\StatusCode::OUT_ERROR, "不能删除已上线未过期的抽奖活动");
            }

            //删除数据
            $rs = ActivityLucky::where("id", $id)->delete();

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["AcitivityLucky-PageList", "AcitivityLuck-Prize"])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "删除失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-delete:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "删除异常");
        }
    }


    /***
     * 删除奖项 - 执行
     */
    public function deleteprize($id)
    {
        try {
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row = ActivityLuckyPrize::where("id", $id)->first();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }

            //删除数据
            $rs = ActivityLuckyPrize::where("id", $id)->delete();

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["AcitivityLucky-PageList", "AcitivityLuck-Prize"])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "删除失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityLuckyBusiness-delete:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "删除异常");
        }
    }

    /***
     * 获取扩展详情
     * @return mixed
     */
    public function extension($id, $userid, $companyid, $tag = "AcitivityLuck-Prize")
    {
        Cache::flush();
        $tagKey = base64_encode(mosaic("", $tag, $id));
        $uploads=config("configure.uploads");
        $list["uploads"]=$uploads;
        $list["lukData"] = ActivityLucky::where("id", $id)->select("id","sharetitle","title","bgurl","storeid")->first();
        $list["lukData"]["bgurl"] = $list["lukData"]["bgurl"]?$uploads."/". $list["lukData"]["bgurl"]:"";
        $list["lukData"]["storename"]=Store::where("id",$list["lukData"]["storeid"])->value("name");
        $list["lukData"]["sharetitle"]=$list["lukData"]["sharetitle"]?$list["lukData"]["sharetitle"]:$list["lukData"]["title"];
        //奖项数据
        $list["prizeList"] = Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($id, $userid, $companyid,$uploads) {
            //查詢
            return ActivityLuckyPrize::where("activityluckyid", $id)->select(DB::raw("levelid,CONCAT('$uploads','/',picture) as picture"))->orderBy('id', 'asc')->get();
        });

        //获取公司信息
        $list["logo"] = Company::where("id", $companyid)->value("logo");
        $list["logo"]=$list["logo"]?$uploads."/".$list["logo"]:"";
            //获取小程序二维码
        $list["wxappcode"]="";
        return responseCData(\StatusCode::SUCCESS, "", $list);
    }


    /***、
     * 临时获取微信小程序accessToken
     * @param $companyid
     */
    protected function getWxAccessToken($companyid)
    {

        return SmallProgram::where("companyid", $companyid)->value("authorizer_access_token");
    }


}