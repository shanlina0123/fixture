<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/6
 * Time: 18:59
 */

namespace App\Http\Business\Common;


use App\Http\Model\Activity\ActivityLucky;
use App\Http\Model\Activity\ActivityLuckyNum;
use App\Http\Model\Activity\ActivityLuckyPrize;
use App\Http\Model\Activity\ActivityLuckyRecord;

class Lucky
{
    public function getLuckyInfo( $data )
    {
        $res = new \stdClass();
        $res->info = ActivityLucky::where(['companyid'=>$data['companyid'],'id'=>$data['id']])->first();
        $res->luck_num = ActivityLuckyNum::where(['userid'=>$data['userid'],'activityluckyid'=>$data['id']])->first();
        $res->luck_user = ActivityLuckyRecord::where(['activityluckid'=>$data['id'],'iswin'=>1])->whereHas('luckyRecordToClient')->get();
        $res->luck_prize = ActivityLuckyPrize::where(['activityluckyid'=>$data['id']])->orderBy('id','asc')->get();
        return $res;
    }

    public function myLucky($data)
    {
        return ActivityLuckyRecord::where(['activityluckid'=>$data['id'],'iswin'=>1,'userid'=>$data['userid']])->get();
    }

    public function lucyDraw()
    {

    }
}