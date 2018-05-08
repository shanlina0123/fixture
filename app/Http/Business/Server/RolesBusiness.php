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
use App\Http\Model\Filter\FilterRoleFunction;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RolesBusiness extends ServerBase
{
    /***
     * 获取角色列表
     * @return mixed
     */
    public  function  index($companyid,$cityid,$storeid,$islook,$page,$tag = "Role-PageList")
    {
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $companyid,$cityid,$storeid, $page));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($companyid,$cityid,$storeid,$islook) {
            //视野条件1全部 2城市 3门店
            switch($islook)
            {
                case 1:
                    $where["companyid"]=$companyid;
                    break;
                case 2:
                    $where["cityid"]=$cityid;
                    break;
                case 3:
                    $where["storeid"]=$storeid;
                    break;
                default:
                    $where["storeid"]=$storeid;
                    break;
            }
            $list=FilterRole::where($where)->orderBy('id','asc')->paginate(config('configure.sPage'));;
            //返回数据库层查询结果
            return $list;
       });
    }

    /***
     * 角色详情
     * @param $uuid
     * @return mixed
     */
    public function  edit($uuid)
    {
        try{
            //获取详情数据
            $row = FilterRole::where("uuid",$uuid)->select("uuid","name","status","isdeafult","created_at")->first();
            if(empty($row))
            {
                responseData(\StatusCode::NOT_EXIST_ERROR,"请求数据不存在");
            }
        }catch (\ErrorException $e)
        {
            //记录日志
            Log::error('======RolesBusiness-edit:======'. $e->getMessage());
            //业务执行失败
            responseData(\StatusCode::CATCH_ERROR,"获取异常");
        }finally{
            //返回处理结果数据
            return $row;
        }
    }

    /***
     * 新增角色 - 执行
     * @param $data
     */
    public  function  store($data)
    {
        try{
            //开启事务
            DB::beginTransaction();

            //检测name是否存在
            $exist=FilterRole::where("name",$data["name"])->exists();
            if($exist>0)
            {
                responseData(\StatusCode::EXIST_ERROR,"名称".$data["name"]."已存在");
            }

            //业务处理

            //整理新增数据
            $role["uuid"]=create_uuid();
            $role["name"]=$data["name"];
            $role["created_at"]=date("Y-m-d H:i:s");
            //录入数据
            $rs=FilterRole::create($role);

            //结果处理
            if($rs->id!==false)
            {
                DB::commit();
                //删除缓存
                Cache::forget('roleList');
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
                $exist=FilterRole::where("name",$data["name"])->exists();
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
            //结果处理
            if($rs!==false)
            {
                DB::commit();
                //删除缓存
                Cache::forget('roleList');
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

            $rsF=FilterRoleFunction::where("roleid",$roleid)->delete();
            //结果处理
            if($rs!==false&&$rsF!==false)
            {
                DB::commit();
                //删除缓存
                Cache::forget('roleList');
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
}