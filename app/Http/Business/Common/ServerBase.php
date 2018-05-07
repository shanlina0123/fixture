<?php
/**
 * PC端
 */
namespace App\Http\Business\Common;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Http\Model\Data;
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




}