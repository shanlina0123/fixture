<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Filter\FilterRole;
use App\Http\Model\Site\Site;
use App\Http\Model\Store\Store;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminBusiness extends ServerBase
{
    /***
     * 获取管理员列表
     * @return mixed
     */
    public function index($isadmin,$companyid,$cityid,$storeid,$islook,$page,$data,$tag="Admin-PageList",$tag1="Admin-RoleList",$tag2="Admin-StoreList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        $tagKey = base64_encode(mosaic("", $tag, $companyid,$cityid,$storeid,$islook,$page));
        //redis缓存返回
        $list["userList"]= Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($lookWhere,$data) {
            //查詢
            $queryModel=User::select("id","uuid", "nickname", "username", "roleid", "storeid", "isdefault", "status","created_at")
                ->where(["isadminafter"=>1,"type"=>0,"isinvitationed"=>0]);
            //视野条件
            $queryModel = $queryModel->where($lookWhere);
            if($data)
            {
                $searchNickname=searchFilter($data['nickname']);
                $searchStoreid=$data["storeid"];
                if($searchNickname)
                {
                    $queryModel =$queryModel->where("nickname","like","%$searchNickname%");
                }
                if($searchStoreid)
                {
                    $queryModel =$queryModel->where("storeid",$searchStoreid);
                }
            }

            $list =$queryModel
                ->with(["dynamicToRole" => function ($query){
                    //关联角色
                    $query->select("id", "name");
                }])
                ->with(["dynamicToStore" => function ($query){
                    //关联门店
                    $query->select("id", "name");
                }])
                ->orderBy('id', 'asc')
                ->paginate(config('configure.sPage'));
            return $list;
        });

        //获取角色数据
        $list["roleList"] =Cache::get($tag1, function () use ($lookWhere,$tag1) {
            //视野条件
            $roleList = FilterRole::where("status",1)->where($lookWhere)->select("id", "name")->get();
            Cache::put($tag1, $roleList, config('configure.sCache'));
            //返回数据库层查询结果
            return $roleList;
        });
        //获取门店数据
        $list["storeList"] =Cache::get($tag2, function () use ($lookWhere,$tag2) {
            $storeList = Store::select(DB::raw('id,id as storeid,name'))->where($lookWhere)->get();
            Cache::put($tag2, $storeList, config('configure.sCache'));
            //返回数据库层查询结果
            return $storeList;
        });
        return  $list;
    }

    /***
     * 新增用户 - 执行
     * @param $data
     */
    public function store($companyid,$data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检查roleid是否存在
            $roleData = FilterRole::where("id", $data["roleid"])->first();
            if (empty($roleData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色值不存在");
            }

            //检查storeid是否存在
            if($data["storeid"])
            {
                $storeData = Store::where("id", $data["storeid"])->first();
                if (empty($storeData)) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "门店值不存在");
                }
            }

            //检测是账号或姓名是否存在
            $existName = User::where("username",$data["username"])->orWhere("nickname",$data["nickname"])->exists();
            if ($existName > 0) {
                responseData(\StatusCode::EXIST_ERROR, "账号或姓名已存在");
            }

            //业务处理
            //整理新增数据
            $admin["uuid"] = create_uuid();
            $admin["username"] = $data["username"];
            $admin["nickname"] = $data["nickname"];
            $admin["roleid"] = $data["roleid"];
            $admin["storeid"] = $data["storeid"];
            $admin["isadmin"]=$roleData["id"]==1?1:0;
            $admin["isadminafter"]=1;
            $admin["type"]=0;
            $admin["isinvitationed"]=0;
            $admin["status"]=$data["status"];
            $admin["password"] = optimizedSaltPwd("admin",$data['password']);
            $admin["companyid"]=$companyid;
            $admin["cityid"]=$storeData["cityid"];
            $admin["provinceid"]=$storeData["provinceid"];
            $admin["created_at"] = date("Y-m-d H:i:s");

            //录入数据
            $rsAdmin = User::create($admin);
            $adminid = $rsAdmin->id;

            //结果处理
            if ($adminid !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Admin-PageList"])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "新增失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======Admin-StoreList-store:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "新增异常");
        }
    }


    /***
     * 修改用户 - 执行
     * @param $uuid
     */
    public function update($uuid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检查管理员信息
            $row = User::where("uuid", $uuid)->first();
            if ($row["isdefault"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能修改默认用户");
            }

            //检查roleid是否存在
            $roleExist = FilterRole::where("id", $data["roleid"])->exists();
            if ($roleExist == 0) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色值不存在");
            }


            //检查storeid是否存在
            if($data["storeid"])
            {
                $storeData = Store::where("id", $data["storeid"])->first();
                if (empty($storeData)) {
                    responseData(\StatusCode::NOT_EXIST_ERROR, "门店值不存在");
                }
            }

            //检测是账号或姓名是否存在
            $existName = User::whereRaw("id!=".$row["id"]." AND (username='".$data["username"]."' OR nickname='".$data["nickname"]."')")
                ->exists();
            if ($existName > 0) {
                responseData(\StatusCode::EXIST_ERROR, "账号或姓名已存在");
            }

            //整理修改数据
            $admin["username"] = $data["username"];
            $admin["nickname"] = $data["nickname"];
            $admin["roleid"] = $data["roleid"];
            $admin["storeid"] = $data["storeid"];
            $admin["cityid"]=$storeData["cityid"];
            $admin["provinceid"]=$storeData["provinceid"];
            $admin["isadmin"]=$row["roleid"]==1?1:0;
            $admin["isadminafter"]=1;
            $admin["type"]=0;
            $admin["isinvitationed"]=0;
            $admin["status"]=$data["status"];
            $admin["updated_at"] = date("Y-m-d H:i:s");
            //修改Admin数据
            $rs = User::where("uuid", $uuid)->update($admin);
            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Admin-PageList"])->flush();

                //修改token
                Cache::put('userToken'.$row['id'],['token'=>$row['token'],'type'=>1],config('session.lifetime'));

            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AdminBusiness-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "修改异常");
        }
    }

    /***
     * 启动禁用用户 - 执行
     * @param $uuid
     */
    public function setting($uuid)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $adminData = User::where("uuid", $uuid)->first();
            if (empty($adminData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }
            if ($adminData["isdefault"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能设置默认用户");
            }

            //整理修改数据
            $admin["status"] = abs($adminData["status"] - 1);
            $admin["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = User::where("uuid", $uuid)->update($admin);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Admin-PageList"])->flush();
                //修改token
                Cache::put('userToken'.$adminData['id'],['token'=>$adminData['token'],'type'=>1],config('session.lifetime'));
                return ["status"=>$admin["status"]];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AdminService-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }


    /***
     * 删除用户 - 执行
     */
    public  function delete($uuid)
    {
        try{
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row=User::where("uuid",$uuid)->first();
            if(empty($row))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR,"请求数据不存在,请刷新页面");
            }

            //后台用户id
            $adminid=$row->id;

            //不能删除管理员角色
            if($row->isdefault==1)
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除默认用户");
            }

            //不能删除非后端用户
            if($row->isadminafter==0)
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除非后端用户");
            }
            //不能删除C端用户
            if($row->type==1)
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除C端用户");
            }

            //不能删除邀请的工地参与者
            if($row->isinvitationed==1)
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除邀请的工地参与者");
            }

            //检测用户下是否有工地
            $siteExist = Site::where("createuserid", $adminid)->exists();
            if ($siteExist>0) {
                responseData(\StatusCode::EXIST_NOT_DELETE, "用户下有创建的工地不能删除");
            }

            //删除数据
            $rs=User::where("uuid",$uuid)->delete();

            //结果处理
            if($rs!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Admin-PageList"])->flush();
                //修改token
                Cache::put('userToken'.$row['id'],['token'=>$row['token'],'type'=>2],config('session.lifetime'));
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"删除失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======AdminBusiness-delete:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"删除异常");
        }
    }

}