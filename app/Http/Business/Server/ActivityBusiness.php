<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;

use App\Http\Business\Common\ServerBase;
use App\Http\Model\Activity\Activity;
use App\Http\Model\Store\Store;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActivityBusiness extends ServerBase
{
    /***
     * 获取列表
     * @return mixed
     */
    public function index($isadmin, $companyid, $cityid, $storeid, $islook, $page, $data, $tag = "Acitivity-PageList", $tag1 = "Admin-StoreList")
    {
        $tag=$tag.$companyid;
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        //搜索字段
        $searchTitle = $data ? searchFilter($data['title']) : "";
        $searchIsOnline = $data ? $data["isonline"]: "";
        $searchStoreid = $data ? $data["storeid"] : "";
        $list["searchData"] =[
            "title"=>$searchTitle,
            "isonline"=>$searchIsOnline,
            "storeid"=>$searchStoreid,
        ];
        //缓存key
        $tagKey = base64_encode(mosaic("", $tag, $companyid, $cityid, $storeid, $islook,$searchTitle,$searchIsOnline,$searchStoreid, $page));
        //redis缓存返回
        $list["activityList"] = Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($lookWhere, $searchTitle, $searchIsOnline, $searchStoreid, $data, $tag1) {

            $queryModel = Activity::orderBy('id', 'desc');
            //视野条件
            $queryModel->where($lookWhere);
            //搜索
            if ($searchTitle) {
                $queryModel = $queryModel->where("title", "like", "%$searchTitle%");
            }
            if (in_array($searchIsOnline,[1,2])) {
                $isonline=$searchIsOnline==1?1:0;
                $queryModel = $queryModel->where("isonline", $isonline);
            }
            if ($searchStoreid) {
                $queryModel = $queryModel->where("storeid", $searchStoreid);
            }

            //查询
            $list = $queryModel
                ->with(["ActivityToStore" => function ($query) {
                    //关联门店
                    $query->select("id", "name");
                }])
                ->with(["ActivityToUser" => function ($query1) {
                    //关联用户
                    $query1->select( "id","nickname");
                }])
                ->with(["ActivityToParticipatory" => function ($query2) {
                    //关联活动参与方式
                    $query2->select( "id","name");
                }])
                ->orderBy('id', 'asc')
                ->paginate(config('configure.sPage'));

            return $list;
        });

        //获取门店数据
        $list["storeList"] = Cache::tags($tag1)->remember($tagKey, config('configure.sCache'), function () use ($isadmin, $lookWhere) {
            //查詢
            $queryModel = Store::select(DB::raw("id,name,id"));
            //视野条件
            if(array_key_exists("storeid",$lookWhere)&&$lookWhere["storeid"])
            {
                $lookWhere["id"]=$lookWhere["storeid"];
                unset($lookWhere["storeid"]);
            }
            $queryModel = $queryModel->where($lookWhere);
            $list = $queryModel
                ->orderBy('id', 'asc')
                ->get();
            return $list;
        });

        return $list;
    }


    /***
     * 获取详情
     * @return mixed
     */
    public function edit($isadmin, $companyid, $cityid, $storeid, $islook, $id, $tag2 = "Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        //检测是否存在
        $list["activityData"] = Activity::where("id", $id)->first()->toArray();
        if (!$list["activityData"]) {
            return responseCData(\StatusCode::NOT_EXIST_ERROR, "抽奖活动不存在");
        }
        //获取门店数据
        $tagKey2 = base64_encode(mosaic("", $tag2, $companyid, $cityid, $storeid, $islook));
        $list["storeList"] = Cache::tags($tag2)->remember($tagKey2, config('configure.sCache'), function () use ($isadmin, $lookWhere) {
            //查詢
            $queryModel = Store::select(DB::raw("id,name,id"));
            //视野条件
            if(array_key_exists("storeid",$lookWhere)&&$lookWhere["storeid"])
            {
                $lookWhere["id"]=$lookWhere["storeid"];
                unset($lookWhere["storeid"]);
            }
            $queryModel = $queryModel->where($lookWhere);
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
    public function update($id, $userid, $companyid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            $uploadClass = new \Upload();

            //检查活动、标题
            if ($id) {

                //检查活动
                $rowData = Activity::where("id", $id)->first();
                if (!$rowData) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "该活动不存在");
                }

                //检查标题
                $rowExist = Activity::where("id", "!=", $id)->where("companyid",$companyid)->where("title", $data["title"])->exists();
                if ($rowExist > 0) {
                    responseData(\StatusCode::EXIST_ERROR, "标题已存在");
                }
            } else {
                //检查标题
                $rowExist = Activity::where("companyid",$companyid)->where("title", $data["title"])->exists();
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
                $bgurl = $this->tmpToUploads($createUuid, $data["bgurl"], "activity");
                if (!$bgurl) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "封面图上传错误，请重新上传");
                }
            }
            //整理修改数据
            $activity["uuid"] = $createUuid;
            $activity["companyid"] = $companyid;//公司id
            $activity["cityid"] = $storeData["cityid"];//市id
            $activity["userid"] = $userid;
            //基础设置
            $activity["storeid"] = $data["storeid"];//门店id
            $activity["title"] = $data["title"];//标题
            $data["resume"] ? $activity["resume"] = $data["resume"] : "";//摘要 简述
            $data["content"] ? $activity["content"] = $data["content"] : "";//内容
            $data["startdate"] ? $activity["startdate"] = $data["startdate"] : "";//开始日期
            $data["enddate"] ? $activity["enddate"] = $data["enddate"] : "";//结束日期
            //高级设置
            $lucky["isonline"] = $data["isonline"];//是否上线 1上线 0下线
            if ($id) {
                //修改
                $data["bgurl"] ? $activity["bgurl"] = $bgurl : "";//活动背景图
                $activity["updated_at"] = date("Y-m-d H:i:s");
                $rs = Activity::where("id", $id)->update($activity);
                $activityid = $id;
            } else {
                //添加
                $activity["bgurl"] = $data["bgurl"] ? $bgurl : config('configure.activity.bgurl');//活动背景图
                $activity["created_at"] = date("Y-m-d H:i:s");
                $rsactivity = ActivityLucky::create($activity);
                $rs = $rsactivity->id;
                $activityid = $rsactivity->id;
            }
            //多图设置
            //添加图
            $addRsp[] =1;
            if (count($data["addpic"]) > 0) {
                foreach ($data["addpic"] as $k => $v) {
                    if ($v) {
                        $picture = $this->tmpToUploads($createUuid, $v, "activity");
                        if ($picture) {
                            //添加
                            $actpicData["uuid"] = create_uuid();
                            $actpicData["activityid"] = $activityid;
                            $actpicData["picture"] = $picture;
                            $actpicData["userid"] = $userid;
                            $actpicData["created_at"] = date("Y-m-d H:i:s");
                            $addRsp[] = ActivityImages::create($actpicData);
                        }else{
                            responseData(\StatusCode::NOT_EXIST_ERROR, "活动图上传错误，请重新上传");
                        }
                    }
                }
            }
            //删除图
            $delRsp[]=1;
            if (count($data["delpicids"]) > 0) {
                foreach ($data["delpicids"] as $k => $v) {
                        if ($v) {
                            $delRsp[] = ActivityImages::where("id", $v)->delete();
                        }
                    }
            }
            //结果处理
            if ($rs !== false && !in_array(false, $addRsp, true)&&!in_array(false, $delRsp, true)) {
                DB::commit();
                //删除缓存
                Cache::tags(["Acitivity-PageList".$companyid])->flush();
                return ["id" => $activityid,"isonline" => $lucky["isonline"], "listurl" => route("activity-index")];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "保存失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityBusiness-update:======' . $e->getMessage());
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
            $rowData = Activity::where("id", $id)->first();
            if (empty($rowData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }

            //修改数据
            $updateData["isonline"] = abs($rowData->isonline - 1);
            $updateData["updated_at"] = date("Y-m-d H:i:s");
            $rs = Activity::where("id", $id)->update($updateData);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Acitivity-PageList".$rowData->companyid])->flush();
                return ["isonline" => $updateData["isonline"]];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityBusiness-setting:======' . $e->getMessage());
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
            $row = Activity::where("id", $id)->first();
            if (empty($row)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }

            //不能删除已上线的活动。
            if ($row->isonline == 1 && $row->startdate <= date("Y-m-d H:i:s") && $row->enddate >= date("Y-m-d H:i:s")) {
                responseData(\StatusCode::OUT_ERROR, "不能删除已上线未过期的抽奖活动");
            }

            //删除数据
            $rs = Activity::where("id", $id)->delete();

            //结果处理
            if ($rs !== false) {
                DB::commit();

                //删除目录下所有文件
                (new \Upload())->delDir('activity', $row->uuid);

                //删除缓存
                Cache::tags(["Acitivity-PageList".$row->companyid])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "删除失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AcitivityBusiness-delete:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "删除异常");
        }
    }


}