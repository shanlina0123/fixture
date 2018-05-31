<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 10:42
 */

namespace App\Http\Business\Client;


use App\Http\Model\Activity\ActivityLuckyRecord;
use Illuminate\Support\Facades\Cache;

class ClientActivityLuckyRecord
{

    /**
     * @param $id
     * @param $request
     * 活动
     */
    public function LuckyRecord( $id ,$request )
    {
        //Cache::flush();
        $tag = 'LuckyRecord'.$id;
        $tagWhere = $request->input('page');
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $id, $request ){
            $sql = ActivityLuckyRecord::where( ['userid'=>$id,'iswin'=>1] )->orderBy('id','desc')->with(['luckyRecordToLucky'=>function($query){
                $query->select('title','id');
            }]);
            return $sql->select('prizename','activityluckid','created_at')->paginate(config('configure.sPage'));
        });
        return $value;
    }

}