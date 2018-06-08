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

    public function lucyDraw( $data )
    {
        //1.判断活动是不是在线
        //2.判断活动开始时间
        //3.判断活动结束时间
        //4.判断个人活动参与次数
        //5.判断中将次数
        //6.抽奖
        $res = ActivityLucky::where(['companyid'=>$data['companyid'],'id'=>$data['id']])->first();
        if( !$res )
        {
            responseData(\StatusCode::ERROR,'未查询到信息');
        }
        if( $res->isonline != 1 )
        {
            responseData(\StatusCode::ERROR,'活动已下线');
        }
        if( strtotime($res->startdate) < time() )
        {
            responseData(\StatusCode::ERROR,'活动还未开始');
        }
        if( strtotime($res->enddate) < time() )
        {
            responseData(\StatusCode::ERROR,'活动已结束');
        }
        if()
        {

        }
    }
}