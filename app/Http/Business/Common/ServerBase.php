<?php
/**
 * PC端
 */
namespace App\Http\Business\Common;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Http\Model\Data;
use Illuminate\Support\Facades\Log;

class ServerBase
{

    public static $sCache = 120;
    public static $sPage = 10;

    /***
     * 获取数据源
     * @param $mode
     * @return mixed
     */
    public function getParticipatory()
    {
        $cacheKey="DataParticipatory";
        $modeData=Cache::get($cacheKey);
        if(empty($modeData))
        {
            $modeData = Data\Participatory::where('status',1)->get();
            Cache::put($cacheKey,$modeData,static::$sCache);
        }
        return $modeData;
    }


    /***
     * 将tmp图片上传到uploads
     * @param $uuid
     * @param $name
     * @param $type
     * @return bool
     */
    public function tmpToUploads($uuid, $name,$type="site_info")
    {
        $upload = new \Upload();
        $dbPath=$upload->uploadProductImage( $uuid, $name, $type);
        if($dbPath)
        {
            return $dbPath."/".$name;
        }else{
            return false;
        }
    }

    /***
     * 删除
     * @param $path
     * @return bool
     */
   public function UoloadsDel($path)
   {
       $upload = new \Upload();
       return $upload->delImg($path);
   }

    /***
     * json返回
     * @param $data
     * @return string
     */
    public  function response($data)
    {
        $responseData= [
            "status"=>$data["status"]?$data["status"]:"",
            "msg"=>$data["msg"]?$data["msg"]:"",
            "data"=>$data["data"]?$data["data"]:"",
        ];
        echo    json_encode($responseData);
        die;
    }


     //视野条件
    function lookWhere($isadmin,$companyid,$cityid,$storeid,$islook)
    {
        $where=array();
        //管理员/视野条件1全部 2城市 3门店
        if($isadmin==0) {
            switch ($islook) {
                case 1:
                    $where["companyid"] = $companyid;
                    break;
                case 2:
                    $where["cityid"] = $cityid;
                    break;
                case 3:
                    $where["storeid"] = $storeid;
                    break;
                default:
                    $where["storeid"] = $storeid;
                    break;
            }
        }else{
            $where["companyid"] = $companyid;
        }
        return $where;
    }

}