<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBaseController extends Controller
{

    public $userInfo;
    public $request;
    public function __construct()
    {
        //切换后台数据库
        DB::connection('mysql_admin');
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('adminInfo');
            $this->userInfo = $userInfo;
            $this->request=$request;
            return $next($request);
        });

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
