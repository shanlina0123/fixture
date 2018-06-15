<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Data\Position;
use App\Http\Model\Filter\FilterFunction;
use App\Http\Model\Filter\FilterRole;
use App\Http\Model\Filter\FilterRoleFunction;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesBusiness extends ServerBase
{
    /***
     * 获取角色列表
     * @return mixed
     */
    public  function  index($isadmin,$companyid,$cityid,$storeid,$islook,$page,$tag = "Filter-RolePageList")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $companyid,$cityid,$storeid,$islook,$page));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($lookWhere) {
            $queryModel=FilterRole::orderBy('id','asc');
            //视野条件
            $queryModel = $queryModel->where($lookWhere)->orWhere("id",1);
            //查询
            $list=$queryModel->paginate(config('configure.sPage'));
            //返回数据库层查询结果
            return $list;
      });
    }

    /***
     * 新增角色 - 执行
     * @param $data
     */
    public  function  store($userid,$companyid,$cityid,$storeid,$data)
    {
        try{
            //开启事务
            DB::beginTransaction();

            //检测name是否存在
            $exist=FilterRole::where("name",$data["name"])->where("companyid",$companyid)->exists();
            if($exist>0)
            {
                responseData(\StatusCode::EXIST_ERROR,"名称".$data["name"]."已存在");
            }
            //业务处理
            //整理新增数据
            $role["uuid"]=create_uuid();
            $role["name"]=$data["name"];
            $role["companyid"]=$companyid;
            $role["cityid"]=$cityid;
            $role["storeid"]=$storeid;
            $role["userid"]=$userid;
            $role["created_at"]=date("Y-m-d H:i:s");
            //录入数据
            $rs=FilterRole::create($role);

            //加入职位
            $position["name"]=$data["name"];
            $position["companyid"]=$companyid;
            $position["roleid"]=$rs->id;
            $position["created_at"]=date("Y-m-d H:i:s");
            $rsP=Position::updateOrCreate(array('companyid' => $companyid,"roleid"=>$rs->id),$position);

            //结果处理
            if($rs->id!==false&&$rsP!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Filter-RolePageList","Filter-RoleFunctionList","Admin-RoleList","Data-CateList"])->flush();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"新增失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesBusiness-store:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"新增异常");
        }
    }


    /***
     * 修改角色 - 执行
     * @param $uuid
     */
    public  function  update($uuid,$data)
    {
        try{
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $roleData=FilterRole::where("uuid",$uuid)->first();
            if(empty($roleData))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR,"请求数据不存在");
            }

            //检测name是否存在
            if($roleData["name"]!==$data["name"])
            {
                $exist=FilterRole::where("name",$data["name"])->where("companyid",$roleData["companyid"])->exists();
                if($exist>0)
                {
                    responseData(\StatusCode::EXIST_ERROR,"名称".$data["name"]."已存在");
                }
            }else{
                responseData(\StatusCode::NOT_CHANGE,"名称无变化");
            }

            //整理修改数据
            $role["name"]=$data["name"];
            $role["updated_at"]=date("Y-m-d H:i:s");
            //修改数据
            $rs=FilterRole::where("uuid",$uuid)->update($role);

            //修改职位
            $position["name"]=$data["name"];
            $position["companyid"]=$roleData["companyid"];
            $position["roleid"]=$roleData["id"];
            $position["created_at"]=date("Y-m-d H:i:s");
            $rsP=Position::updateOrCreate(array('companyid' =>$roleData["companyid"],"roleid"=>$roleData["id"]),$position);

            //结果处理
            if($rs!==false&&$rsP!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Filter-RolePageList","Filter-RoleFunctionList","Admin-RoleList","Data-CateList"])->flush();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"修改失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesBusiness-update:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"修改异常");
        }
    }

    /***
     * 删除角色 - 执行
     */
    public  function delete($uuid)
    {
        try{
            //开启事务
            DB::beginTransaction();
            //业务处理
            //检测存在
            $row=FilterRole::where("uuid",$uuid)->first();
            if(empty($row))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR,"请求数据不存在");
            }

            //角色
            $roleid=$row->id;

            //不能删除管理员角色
            if($roleid==1)
            {
                responseData(\StatusCode::OUT_ERROR,"不能删除管理员角色");
            }

            //检测角色下是否有对应用户
            $adminExist=User::where("roleid",$roleid)->exists();
            if($adminExist>0)
            {
                responseData(\StatusCode::EXIST_NOT_DELETE,"角色下关联有用户，不能删除");
            }
            //删除数据
            $rs=FilterRole::where("uuid",$uuid)->delete();

            //删除角色功能
            $rsF=FilterRoleFunction::where("roleid",$roleid)->delete();

            //删除角色职位
            $rsP=Position::where("roleid",$roleid)->delete();

            //结果处理
            if($rs!==false&&$rsF!==false&&$rsP!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Filter-RolePageList","Filter-RoleFunctionList","Admin-RoleList","Data-CateList"])->flush();
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"删除失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesBusiness-delete:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"删除异常");
        }
    }


    /***
     * 启动禁用 - 执行
     * @param $uuid
     */
    public function setting($uuid)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            //检测存在
            $adminData = FilterRole::where("uuid", $uuid)->first();
            if (empty($adminData)) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "请求数据不存在,请刷新页面");
            }
            if ($adminData["isdefault"] == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能设置默认角色");
            }

            //整理修改数据
            $admin["status"] = abs($adminData["status"] - 1);
            $admin["updated_at"] = date("Y-m-d H:i:s");
            //修改数据
            $rs = FilterRole::where("uuid", $uuid)->update($admin);

            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Filter-RolePageList","Filter-RoleFunctionList","Admin-RoleList"])->flush();
                return ["status"=>$admin["status"]];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "设置失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesBusiness-setting:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "设置异常");
        }
    }

    /***
     * 进入权限编辑页
     * @param $roleid
     */
    public function  auth($roleid,$tag1="Filter-FunctionList",$tag2 = "Filter-RoleFunctionList")
    {
        //检查角色是否已禁用
        $list["role"]=FilterRole::select("id","name","status")->where("id",$roleid)->first()->toArray();
        if(empty($list["role"]))
        {
            return responseCData(\StatusCode::EMPTY_ERROR, "角色不存在");
        }
        if($list["role"]["status"]==0)
        {
            return responseCData(\StatusCode::ROLE_HIDDEN, "角色已禁用，不能进行权限设置");
        }
        //所有功能列表
        $list["functionList"] =Cache::get($tag1, function () use ($tag1) {
            //默认条件
            $objList = FilterFunction::where(["ismenu"=>1,"status"=>1])->select("id", "menuname", "pid", "level")->orderBy('sort', 'asc')->get();
            //结果检测
            if (empty($objList)) {
                return responseCData(\StatusCode::EMPTY_ERROR, "系统未配置权限功能，请联系管理员");
            }
            //生成tree数组
            $functionList= list_to_tree($objList->toArray(),"id","pid", '_child',0);
            //写入redis缓存
            Cache::put($tag1, $functionList, config('configure.sCache'));
            //返回数据库层查询结果
            return $functionList;
        });
        //角色对应的functions
        $tagKey = base64_encode(mosaic("", $tag2, $roleid));
        $list["roleFunctionList"]= Cache::tags($tag2)->remember($tagKey, config('configure.sCache'), function () use ($roleid) {
            $authList= FilterRoleFunction::select("functionid","islook")->where("roleid", $roleid)->get()->toArray();
            return array_column($authList,null,"functionid");
        });

        return responseCData(\StatusCode::SUCCESS, "",$list);

    }


    /***
     * 勾选权限
     * @param $uuid
     */
    public function updateAuth($roleid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检测角色是否存在
            $roleData = FilterRole::where("id", $roleid)->first();
            if (empty($roleData))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR, "角色名称不存在");
            }
            //角色id
            $roleid = $roleData->id;
            //检查管理员
            if ($roleid == 1) {
                responseData(\StatusCode::OUT_ERROR, "不能勾选管理员权限");
            }
            //检查门店管理员
            if ($roleid == 2) {
                responseData(\StatusCode::OUT_ERROR, "不能勾选门店管理员权限");
            }

            //清除所有权限
            if(count($data["funcislook"])==0)
            {
                $rs = FilterRoleFunction::where("roleid",$roleid)->delete(); //删除数据库原始的
            }else{
                //新添加
                $rolefunc = array();
                foreach ( $data["funcislook"] as $k=>$row  )
                {
                    $allFuncids[]=$row["funcid"];
                    $allLook=array();
                    if(!in_array($row["islook"],$allLook))
                    {
                        $allLook[]=$row["islook"];
                    }
                    $rolefunc[$k]["uuid"] = create_uuid();
                    $rolefunc[$k]["roleid"] = $roleid;
                    $rolefunc[$k]["functionid"] =$row["funcid"];
                    $rolefunc[$k]["islook"] = $row["islook"];
                    $rolefunc[$k]["created_at"] = date("Y-m-d H:i:s");
                }
                //检测是否勾选权限
                if(count($allFuncids)==0)
                {
                    responseData(\StatusCode::NOT_DEFINED, "您未选择权限");
                }
                //检测是否勾选视野
                if(count($allLook)==0)
                {
                    responseData(\StatusCode::NOT_DEFINED, "您未选择权限视野");
                }
                //检测视野是否存在
                $diffLook=array_diff($allLook,[1,2,3]);
                if(count($diffLook)>0)
                {
                    responseData(\StatusCode::NOT_DEFINED, "存在非定义视野数值，请移除");
                }
                //检测权限是否存在
                $existCount = FilterFunction::whereIn("id",$allFuncids)->count("id");
                if ($existCount !== count($allFuncids)) {
                    responseData(\StatusCode::NOT_DEFINED, "存在非定义权限数值，请移除");
                }

                //添加至数据库
                if(count($rolefunc)>0)
                {
                    FilterRoleFunction::where("roleid",$roleid)->delete(); //删除数据库原始的
                    $rs = FilterRoleFunction::insert($rolefunc);
                }
            }

            //结果处理
            if ($rs!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Filter-RolePageList","Filter-RoleFunctionList","Admin-RoleList"])->flush();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "勾选失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======RolesBusiness-updateAuth:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "勾选异常");
        }
    }
}