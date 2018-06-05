<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Data\City;
use App\Http\Model\Data\Province;
use App\Http\Model\Store\Store;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreBusiness extends ServerBase
{
    /***
     * 获取管理员列表
     * @return mixed
     */
    public function index($isadmin,$companyid,$provinceid,$cityid,$storeid,$islook,$page,$data,$tag="Store-PageList",$tag1="Store-ProvinceList",$tag2="Store-cityList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        //搜索字段
        $searchName=$data?searchFilter($data['name']):"";
        $list["searchData"] =[
            "name"=>$searchName,
        ];
        //缓存key
        $tagKey = base64_encode(mosaic("", $tag, $searchName,$companyid,$provinceid,$cityid,$storeid,$islook,$page));
        //redis缓存返回
        $list["storeList"]= Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($lookWhere,$data,$searchName) {
            $queryModel=Store::orderBy('id', 'asc');
            //视野条件
            $lookWhere["id"]=$lookWhere["storeid"];
            unset($lookWhere["storeid"]);
            $queryModel = $queryModel->where($lookWhere);
            //搜索条件
            $searchName?$queryModel =$queryModel->where("name","like","%$searchName%"):"";
            //查询
            $list =$queryModel
                ->with(["StoreToCity" => function ($query){
                    //关联角色
                    $query->select("id", "name");
                }])
                ->with(["StoreToProvince" => function ($query){
                    //关联门店
                    $query->select("id", "name");
                }])
                ->paginate(config('configure.sPage'));
            return $list;
        });
        //获取省份数据
        $list["provinceList"] =Cache::get($tag1, function () use ($tag1) {
            $provinceList = Province::where("status",1)->select("id", "name")->get();
            Cache::put($tag1, $provinceList, config('configure.sCache'));
            //返回数据库层查询结果
            return $provinceList;
        });
        //获取市数据
        $list["cityList"] =Cache::get($tag2, function () use ($tag2) {
            $cityList = City::where("status",1)->select("id", "name","provinceid")->get()->toArray();
            $newCityList=array();
            foreach($cityList as $k=>$v)
            {
                $newCityList[$v["provinceid"]][$v["id"]]=$v;
            }
            Cache::put($tag2, $newCityList, config('configure.sCache'));
            //返回数据库层查询结果
            return $newCityList;
        });

        $list["cityListJson"]=json_encode($list["cityList"]);

        //获取登录信息
        $list["loginData"]=[
            "provinceid"=>$provinceid,
            "cityid"=>$cityid
        ];
        return  $list;
    }

    /***
     * 新增 - 执行
     * @param $data
     */
    public function store($companyid,$data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检测是否存在
            $existName = Store::where("name",$data["name"])->exists();
            if ($existName > 0) {
                responseData(\StatusCode::EXIST_ERROR, "名称已存在");
            }

            //业务处理
            //整理新增数据
            $store["uuid"] = create_uuid();
            $store["provinceid"] = $data["provinceid"];
            $store["cityid"] = $data["cityid"];
            $store["name"] = $data["name"];
            $store["addr"] = $data["addr"];
            $store["fulladdr"] = $data["addr"];
            $store["companyid"]=$companyid;
            $store["created_at"] = date("Y-m-d H:i:s");
            //录入数据
            $rsStore = Store::create($store);
            $storeid = $rsStore->id;

            //结果处理
            if ($storeid !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Store-PageList","Admin-StoreList"])->flush();
                Cache::forget("storeCompany".$companyid);
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "新增失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======StoreBusiness-store:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "新增异常");
        }
    }


    /***
     * 修改 - 执行
     * @param $uuid
     */
    public function update($uuid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理

            //检查是否存在
            $storeData = Store::where("name", $data["name"])->where("uuid","!=",$uuid)->first();
            if ($storeData) {
                responseData(\StatusCode::EXIST_ERROR, "名称已存在");
            }

            //整理修改数据
            $store["provinceid"] = $data["provinceid"];
            $store["cityid"] = $data["cityid"];
            $store["name"] = $data["name"];
            $store["addr"] = $data["addr"];
            $store["fulladdr"] = $data["addr"];
            $store["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = Store::where("uuid", $uuid)->update($store);
            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Store-PageList","Admin-StoreList"])->flush();
                Cache::forget("storeCompany".$storeData["companyid"]);
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======StoreBusiness-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "修改异常");
        }
    }

    /***
     * 删除 - 执行
     */
    public  function delete($uuid)
    {
        try{
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row=Store::where("uuid",$uuid)->first();
            if(empty($row))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR,"请求数据不存在,请刷新页面");
            }
            //门店id
            $storeid=$row["id"];

            //检测用户下是否有用户
            $siteExist = User::where("storeid", $storeid)->exists();
            if ($siteExist>0) {
                responseData(\StatusCode::EXIST_NOT_DELETE, "门店下有用户不能删除");
            }

            //删除数据
            $rs=Store::where("uuid",$uuid)->delete();

            //结果处理
            if($rs!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Store-PageList","Admin-StoreList"])->flush();
                Cache::forget("storeCompany".$row["companyid"]);
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"删除失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======StoreBusiness-delete:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"删除异常");
        }
    }

}