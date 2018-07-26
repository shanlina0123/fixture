<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 10:42
 */

namespace App\Http\Business\Client;
use App\Http\Model\Activity\Activity;
use Illuminate\Support\Facades\Cache;

class ClientActivity
{

    /**
     * @param $id
     * @param $request
     * 活动
     */
    public function activityList( $user ,$request )
    {
        //Cache::flush();
        $tag = 'activityList'.$user->companyid;
        $tagWhere = $request->input('page');
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $user, $request ){
            $sql = Activity::where(['companyid'=>$user->companyid,'isonline'=>1])->orderBy('id','desc')->select('id','title','resume','bgurl','created_at');
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * @param $companyID
     * @param $uuid
     * @return mixed
     * 活动详情
     */
    public function activityInfo( $companyID, $id )
    {
        $res = Activity::where(['id'=>$id,'companyid'=>$companyID])->first();
        if( !$res )
        {
            responseData(\StatusCode::ERROR,'未查询到结果',$res);
        }
        return $res;
    }
}