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
     * 获取管理员列表
     * @return mixed
     */
    public function index($isadmin,$companyid,$cityid,$storeid,$islook,$page,$tag="Notice-PageList")
    {
        $tagKey = base64_encode(mosaic("", $tag, $companyid,$cityid,$storeid,$islook,$page));
        //redis缓存返回
        return Cache::tags($tag)->remember($tagKey, config('configure.sCache'), function ()  use ($isadmin,$companyid,$cityid,$storeid,$islook) {
            //查詢
            $queryModel=Notice::orderBy('id', 'desc');
            //管理员/视野条件1全部 2城市 3门店
            if($isadmin==0)
            {
                switch($islook)
                {
                    case 1:
                        $where["companyid"]=$companyid;
                        break;
                    case 2:
                        $where["cityid"]=$cityid;
                        break;
                    case 3:
                        $where["storeid"]=$storeid;
                        break;
                    default:
                        $where["storeid"]=$storeid;
                        break;
                }
                $queryModel=$queryModel->where($where);
            }

            $list =$queryModel
                ->paginate(config('configure.sPage'));
            return $list;
        });

    }


}