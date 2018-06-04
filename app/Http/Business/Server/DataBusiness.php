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
use App\Http\Model\Data\Position;
use App\Http\Model\Data\Province;
use App\Http\Model\Data\RenovationMode;
use App\Http\Model\Data\RoomStyle;
use App\Http\Model\Data\RoomType;
use App\Http\Model\Data\SelectDefault;
use App\Http\Model\Store\Store;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataBusiness extends ServerBase
{
    /***
     * 获取列表
     * @return mixed
     */
    public function index($companyid,$tag="Data-SelectList")
    {
        $tagKey = base64_encode(mosaic("", $tag, $companyid));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($companyid) {
            return SelectDefault::where("pid",0)->orderBy('id', 'asc')->get();
        });
    }

    /***
     * 获取详情
     * @return mixed
     */
    public function edit($companyid,$cateid,$tag="Data-CateList")
    {
        //检测是否存在
        $list["cateData"]= SelectDefault::where("pid",0)->where("id",$cateid)->first()->toArray();
        if (empty($list["cateData"])) {
            return  responseCData(\StatusCode::NOT_EXIST_ERROR, "分类不存在");
        }

        $tagKey = base64_encode(mosaic("", $tag, $companyid,$cateid));
        //redis缓存返回
        $list["dataList"]= Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($companyid,$cateid) {

            switch($cateid*1){
                //装修方式
                case 1:
                    $list= RenovationMode::where("companyid",$companyid)->get();
                    break;
                //装修风格
                case 2:
                    $list= RoomStyle::where("companyid",$companyid)->get();
                    break;
                //户型
                case 3:
                    $list= RoomType::where("companyid",$companyid)->get();
                    break;
                //职位
                case 4:
                    $list= Position::where("companyid",$companyid)->get();
                    break;
            }
            return $list?$list->toArray():[];
        });

        return responseCData(\StatusCode::SUCCESS, "",$list);
    }


    /***
     * 修改 - 执行
     * @param $uuid
     */
    public function update($id,$companyid, $data)
    {
        try {
            //开启事务
            DB::beginTransaction();

            //业务处理
            $dataid=$id;
            //检测是否存在
            $existName = SelectDefault::where("pid",0)->where("id",$data["cateid"])->exists();
            if ($existName ==0) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "分类不存在");
            }
           //新增数据
            $caseSaveData["name"] = $data["name"];
            $caseSaveData["companyid"] = $companyid;
            $caseSaveData["created_at"] = date("Y-m-d H:i:s");
            //修改数据
            $caseUpdateData["name"] = $data["name"];
            $caseUpdateData["companyid"] = $companyid;
            $caseUpdateData["updated_at"] = date("Y-m-d H:i:s");
            switch($data["cateid"]*1){
                //装修方式
                case 1:
                    $existId = $id>0?RenovationMode::where("id",$id)->exists():0;
                    if ($existId ==0) {
                        $rsCase = RenovationMode::create($caseSaveData);
                        $rs = $rsCase->id;
                        $dataid=$rs;
                    }else{
                        $rs = RenovationMode::where("id",$id)->update($caseUpdateData);
                    }
                    break;
                //装修风格
                case 2:
                    $existId=$id>0?RoomStyle::where("id",$id)->exists():0;
                    if ($existId ==0) {
                        $rsCase = RoomStyle::create($caseSaveData);
                        $rs = $rsCase->id;
                        $dataid=$rs;
                    }else{
                        $rs = RoomStyle::where("id",$id)->update($caseUpdateData);
                    }
                    break;
                //户型
                case 3:
                    $existId=$id>0?RoomType::where("id",$id)->exists():0;
                    if ($existId ==0) {
                        $rsCase = RoomType::create($caseSaveData);
                        $rs = $rsCase->id;
                        $dataid=$rs;
                    }else{
                        $rs = RoomType::where("id",$id)->update($caseUpdateData);
                    }
                    break;
                //职位
                case 4:
                    $existId=$id>0?Position::where("id",$id)->exists():0;
                    if ($existId ==0) {
                        $rsCase = Position::create($caseSaveData);
                        $rs = $rsCase->id;
                        $dataid=$rs;
                    }else{
                        $rs = Position::where("id",$id)->update($caseUpdateData);
                    }
                    break;
            }
            //结果处理
            if ($rs !== false) {
                DB::commit();
                //删除缓存
                Cache::tags(["Data-CateList"])->flush();
                Cache::forget("roomType".$companyid);
                Cache::forget("roomStyle".$companyid);
                Cache::forget("renovationMode".$companyid);
                return ["dataid"=>$dataid];
            } else {
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR, "修改失败");
            }
        } catch (\ErrorException $e) {
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======DataBusiness-update:======' . $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR, "修改异常");
        }
    }

    /***
     * 删除 - 执行
     */
    public  function delete($id,$companyid,$data)
    {
        try{
            //检测是否存在
            $existName = SelectDefault::where("pid",0)->where("id",$data["cateid"])->exists();
            if ($existName ==0) {
                responseData(\StatusCode::NOT_EXIST_ERROR, "分类不存在");
            }
            switch($data["cateid"]*1){
                //装修方式
                case 1:
                    $rs = RenovationMode::where("id",$id)->delete();
                    break;
                //装修风格
                case 2:
                    $rs=RoomStyle::where("id",$id)->delete();
                    break;
                //户型
                case 3:
                    $rs=RoomType::where("id",$id)->delete();
                    break;
                //职位
                case 4:
                    $rs=Position::where("id",$id)->delete();
                    break;
            }

            //结果处理
            if($rs!==false)
            {
                DB::commit();
                //删除缓存
                Cache::tags(["Data-CateList"])->flush();
                Cache::forget("roomType".$companyid);
                Cache::forget("roomStyle".$companyid);
                Cache::forget("renovationMode".$companyid);
            }else{
                DB::rollBack();
                responseData(\StatusCode::DB_ERROR,"删除失败");
            }
        }catch (\ErrorException $e){
            //业务执行失败
            DB::rollBack();
            //记录日志
            Log::error('======DataBusiness-delete:======'. $e->getMessage());
            responseData(\StatusCode::CATCH_ERROR,"删除异常");
        }
    }

}