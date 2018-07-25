<?php
/**
 * PC端
 */
namespace App\Http\Business\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminBase
{

    public static $sCache = 120;
    public static $sPage = 10;

    public function __construct()
    {
        //切换后台数据库
        DB::connection('mysql_admin');
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