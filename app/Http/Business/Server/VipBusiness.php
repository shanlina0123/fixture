<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;

use App\Http\Business\Common\ServerBase;
use App\Http\Model\Vip\ConfVipfunctionpoint;
use App\Http\Model\Vip\LogVipupgrade;
use Illuminate\Support\Facades\DB;

class VipBusiness extends ServerBase
{

    /****
     * 介绍页面
     * @param $companyid
     * @param $vipmechanismid
     */
    public function index($companyid, $vipmechanismid)
    {
        //申请记录
        $upData = LogVipupgrade::where("companyid", $companyid)->first();
        $data["tipname"]="";
        if ($upData) {
            if ($upData["status"] == 0) {
                $data["tipname"] = "您好，已收到您专业版升级申请，我们会尽快和您联系！";
            }
        }
        //当前版本
        $data["id"]=$vipmechanismid?$vipmechanismid:1;
        switch ($data["id"])
        {
            case 1:
                $data["name"]="标准版";
                break;
            case 2:
                $data["name"]="专业版";
                break;
            default:
                $data["name"]="标准版";
        }

        //VIP功能
        $data["list"]=ConfVipfunctionpoint::where("status",1)->get()->toArray();
        return $data;

    }

    /****
     * 申请专业版
     * @param $companyid
     * @param $vipmechanismid
     */
    public function store($companyid, $vipmechanismid)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //检测是否存在
            $upData = LogVipupgrade::where("companyid", $companyid)->first();
            if ($upData) {
                if ($upData["status"] == 0)
                    responseData(\StatusCode::EXIST_ERROR, "您已申请过");
                if ($upData["status"] == 1 && date("Y-m-d H:i:s") <= $upData["deadline"]) {
                    responseData(\StatusCode::EXIST_ERROR, "您已是专业版");
                }
            }

            //业务处理
            //整理新增数据
            $vipup["uuid"] = create_uuid();
            $vipup["vipmechanismid"] = $vipmechanismid;
            $vipup["companyid"] = $companyid;
            $vipup["created_at"] = date("Y-m-d H:i:s");
            //录入数据
            $rsVipup = LogVipupgrade::create($vipup);
            $vipupid = $rsVipup->id;

            //结果处理
            if ($vipupid !== false) {
                DB::commit();
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "申请失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======VipBusiness-store:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "申请异常");
        }
    }
}