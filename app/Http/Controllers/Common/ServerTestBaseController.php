<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ServerTestBaseController extends Controller
{
    public $userInfo;
    public function __construct()
    {
        //判断公司信息是否完善
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('userInfo');
            $this->userInfo = $userInfo;
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
