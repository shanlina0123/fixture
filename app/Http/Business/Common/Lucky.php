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

class Lucky
{
    public function getLuckyInfo( $data )
    {
        $res = new \stdClass();
        $res->info = ActivityLucky::where(['companyid'=>$data['companyid'],'id'=>$data['id']])->first();
        $res->luck_num = ActivityLuckyNum::where(['userid'=>$data['userid']])->first();

    }
}