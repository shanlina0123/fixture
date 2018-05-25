<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 10:42
 */

namespace App\Http\Business\Client;
use App\Http\Model\Activity\Activity;
use App\Http\Model\Activity\ActivityInrecord;
use Illuminate\Support\Facades\Cache;

class ClientActivityInrecord
{

    /**
     * @param $id
     * @param $request
     * 活动
     */
    public function activityInrecord( $id ,$request )
    {
        //Cache::flush();
        $tag = 'activityInrecord'.$id;
        $tagWhere = $request->input('page');
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $id, $request ){
            $sql = ActivityInrecord::where( 'userid', $id )->orderBy('id','desc')->with('activityToInrecord');
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
    public function activityInfo( $companyID, $uuid )
    {
        $res = Activity::where(['uuid'=>$uuid,'companyid'=>$companyID])->select('title','resume','content','created_at')->first();
        if( !$res )
        {
            responseData(\StatusCode::ERROR,'未查询到结果',$res);
        }
        return $res;
    }
}