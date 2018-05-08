<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use Illuminate\Support\Facades\Cache;
class RolesBusiness extends ServerBase
{
    //请求
    protected  $request;
    //session
    protected  $sessionUser;
    //redis配置
    protected  $redisTag;
    protected  $redisKey;
    protected  $redisTimeout;
    /**
     * ActivityBusiness constructor.
     * @param $request
     */
    public function  __construct($request)
    {
        $this->request = $request;
    }


    /***
     * 获取角色列表
     * @return mixed
     */
    public function index()
    {
        //获取用户信息
        $sessionUser = session('userInfo');
        //设置redis
        $redisTag = mosaic("", 'activity',$sessionUser->companyid);//设置redis存储文件夹名称
        $redisKey = mosaic("",$redisTag,$sessionUser->storeid,$this->request->input('page'));//设置文件夹下key名称
        $redisTimeout = config("configure.sCache");
        //业务开始
        //Cache::tags($this->redisTag)->flush();//清除缓存
        return Cache::tags($redisTag)->remember($redisKey,$redisTimeout, function() use($sessionUser){
            return $this->getListData($sessionUser);
        });
    }


    /***
     * 获取活动详情、预览
     * @param $uuid
     * @return mixed
     */
    public  function  show($uuid)
    {
        //获取用户信息
        $sessionUser = session('userInfo');
        //获取条件信息
        $condition["uuid"]=$uuid;
        $condition["companyid"]=$sessionUser["companyid"];
        $Activity=Activity::firstOrNew($condition);
        //业务检测
        if(empty($Activity))
        {
            //抱歉，您不能操作其他公司活动信息
            $Activity["errorinfo"]="请求记录不存在";
        }
        //业务开始
        //返回结果
        return $Activity;
    }

    /***
     * 设置是否公开
     * @param $requestData
     * @return mixed
     */
    public  function  setting($requestData)
    {
        //获取用户信息
        $sessionUser = session('userInfo');
        //获取条件信息
        $condition["uuid"]=$requestData["uuid"];
        $condition["companyid"]=$sessionUser["companyid"];
        $Activity=Activity::firstOrNew($condition);
        //业务检测
        if(empty($Activity))
        {
            //抱歉，您不能操作其他公司活动信息
            $this->response(array("status"=>102,"msg"=>"请求记录不存在","data"=>"")) ;
        }

        //业务开始

        //更新数据
        $Activity->isopen=abs($requestData["isopen"]-1);
        $result = $Activity->save();
        //清除缓存
        $redisTag = mosaic("", 'activity',$sessionUser->companyid);//设置redis存储文件夹名称
        Cache::tags($redisTag)->flush();
        //返回结果
        return $result;

    }

    /***
     * 活动列表信息
     * @param $sessionUser
     * @return mixed
     */
    protected  function  getListData($sessionUser)
    {
        //网站管理员
        if( $sessionUser->isadmin == 2 )
        {
            $condition['companyid'] =  $sessionUser->companyid;
        }else
        {
            $condition['companyid'] =  $sessionUser->companyid;
            $condition['storeid'] =  $sessionUser->storeid;
        }
        return Activity::where( $condition )->orderBy('id','desc')->with("participatory")->paginate(config("configure.sPage"));
    }


}