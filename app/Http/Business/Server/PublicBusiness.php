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
class PublicBusiness extends ServerBase
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
    /***
     *  获取菜单列表
     * @return mixed
     */
    public function getMenu($adminid,$roleFunids,$tag="menuList")
    {
        //定义tag的key
        $tagKey = base64_encode(mosaic("", $tag, $adminid));
        //redis缓存返回
        //return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function () use ($adminid, $roleFunids) {

        //获取菜单列表
        $queryModel= Functions::select("id", "menuname","menuicon", "pid", "level","url")
            ->where("ismenu",1)
            ->where("level","<=",2)
            ->where("status",1)
            ->orderBy('sort', 'asc');
        //检查权限
        if(count($roleFunids)>0)
        {
            $queryModel->whereIn("id",$roleFunids);
        }

        $objList =$queryModel->get();

        //结果检测
        if (empty($objList)) {
            responseData(\StatusCode::EMPTY_ERROR, "无结果");
        }
        //生成tree数组
        $list=list_to_tree($objList->toArray(),"id","pid", '_child',0);
        //写入redis缓存
        Cache::put('menuList', $list, config('configure.sCache'));
        //返回数据库层查询结果
        return $list;
        //});
    }
}