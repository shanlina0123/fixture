<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Log\Notice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NoticeBusiness extends ServerBase
{
    /***
     * 获取列表
     * @return mixed
     */
    public function index($isadmin,$companyid,$cityid,$storeid,$islook)
    {
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
            //查詢
            $queryModel=Notice::where("iscreate",1)->orderBy('id', 'desc');
            //视野条件
            $queryModel=$queryModel->where($lookWhere);
            //修改已读
            $updateData["isread"]=1;
            Notice::where($lookWhere)->update($updateData);
            Cache::tags(["Notice-IsHasNotice"])->flush();
            //查询列表
            $list =$queryModel
                ->paginate(config('configure.sPage'));
           return $list;

    }

    /***
     * 获取未读的通知数量
     * @param $isadmin
     * @param $companyid
     * @param $cityid
     * @param $storeid
     * @param $islook
     * @param $page
     * @param string $tag
     * @return mixed
     */
    public function  listen($isadmin,$companyid,$cityid,$storeid,$islook,$tag="Notice-IsHasNotice")
    {
        //非管理员/视野条件1全部 2城市 3门店
        $lookWhere = $this->lookWhere($isadmin, $companyid, $cityid, $storeid, $islook);
        $tagKey = base64_encode(mosaic("", $tag, $companyid,$cityid,$storeid,$islook));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($lookWhere) {
            //查詢
            $queryModel=Notice::where('isread', 0);
            //视野条件
            $queryModel=$queryModel->where($lookWhere);
            //查询列表
            $count =$queryModel
                ->count();
            return $count;
        });
    }


}