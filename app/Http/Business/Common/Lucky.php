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
use App\Http\Model\Client\Client;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param $data
     * 抽奖
     */
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
        if( strtotime($res->startdate) > time() )
        {
            responseData(\StatusCode::ERROR,'活动还未开始');
        }
        if( strtotime($res->enddate) < time() )
        {
            responseData(\StatusCode::ERROR,'活动已结束');
        }
        //判断参与人数
        if($res->ispeoplelimit == 1)
        {
            //限制了参与人数
            $luckNum = ActivityLuckyNum::where('activityluckyid',$data['id'])->count();
            if( $luckNum >= $res->peoplelimitnum )
            {
                responseData(\StatusCode::ERROR,'哎呦来晚了参与人数已达上限');
            }
        }
        //判断个人参与次数
        if( $res->ischancelimit == 1 )
        {
            //限制了个人抽奖机会
            $userLuckNum = ActivityLuckyNum::where(['activityluckyid'=>$data['id'],'userid'=>$data['userid']])->value('chanceusenum');
            if( $res->chancelimitnum <= $userLuckNum )
            {
                responseData(\StatusCode::ERROR,'您的抽奖次数已达上限');
            }
        }
        //查询奖品的数量
        $prize = ActivityLuckyPrize::where('activityluckyid',$data['id'])->select('id','levelname','lastnum','levelid','name')->get()->toArray();
        //计算概率
        $luckChance = $this->luckChance($data['id']);
        //超出概率
        if( $luckChance > $res->winpoint )
        {
           foreach ( $prize as $row )
           {
               if( $row['levelid'] == 1 )
               {
                   $saveData['userid'] = $data['userid'];
                   $saveData['iswin'] = 0;
                   $saveData['name'] = $row['name'];
                   $saveData['id'] = $row['id'];
               }
           }
           $luckRes = $this->saveLuck($res,$saveData);
           if( $luckRes )
           {
               responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$saveData['id']);
           }
            responseData(\StatusCode::ERROR,'参与失败');
        }
        //在概率范围内
        return $this->luckAlgorithm($prize, $res, $data['userid']);

    }

    /**
     * 中将算法
     */
    public function luckAlgorithm( $prize, $res, $uid )
    {
        $indexArr = array();
        for($i=0;$i<sizeof($prize);$i++)
        {
            //排除谢谢参与
            if($prize[$i]['levelid'] != 1 )
            {
                for($j=0;$j<$prize[$i]['lastnum'];$j++)
                {
                    array_push($indexArr, $i);
                }
            }
        }
        if( !count($indexArr) )
        {
            //返回不中将的结果
            foreach ( $prize as $row )
            {
                if( $row['levelid'] == 1 )
                {
                    $saveData['userid'] = $uid;
                    $saveData['iswin'] = 0;
                    $saveData['name'] = $row['name'];
                    $saveData['id'] = $row['id'];
                }
            }
            $luckRes = $this->saveLuck($res,$saveData);
            if( $luckRes )
            {
                responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$saveData['id']);
            }
            responseData(\StatusCode::ERROR,'参与失败');
        }

        //继续派奖
        shuffle($indexArr);
        $rand_index = array_rand($indexArr,1);
        //获取中奖信息
        $prize_index = $indexArr[$rand_index];
        $prizeInfo = $prize[$prize_index];
        $data['iswin'] = 1;
        $data['id'] = $prizeInfo['id'];
        $data['name'] = $prizeInfo['name'];
        $data['userid'] = $uid;
        $luckRes = $this->saveLuck($res,$data);
        if( $luckRes )
        {
           return $data['id'];
        }else
        {
           return false;
        }
    }

    /**
     * 概率
     */
    public function luckChance($id)
    {
        //中将人数
        $luck = ActivityLuckyRecord::where(['activityluckid'=>$id,'iswin'=>1])->count();
        $luckCount = ActivityLuckyRecord::where(['activityluckid'=>$id])->count();
        if( !$luckCount )
        {
            return 0;
        }
        return round(($luck/$luckCount),2 );
    }


    /**
     * 保存抽奖数据
     */
    public function saveLuck( $res, $data )
    {
        try{
            //开启事务
            DB::beginTransaction();
            //如果中奖了奖改变奖品数据
            if( $data['iswin'] == 1 )
            {
                $Lucky = ActivityLuckyPrize::where('id',$data['id'])->first();
                if ( $Lucky->lastnum <= 0 )
                {
                    return false;
                }
                $Lucky->lastnum = $Lucky->lastnum-1;
                $Lucky->save();
                //中了清除一下客户信息缓存
                Cache::tags(['luckyClient'.$res->companyid])->flush();
            }

            //客户数据统计
            $LuckyNum = ActivityLuckyNum::where(['activityluckyid'=>$res->id,'userid'=>$data['userid']])->first();
            if( $LuckyNum )
            {
                $LuckyNum->activityluckyid = $res->id;
                $LuckyNum->chanceusenum = $LuckyNum->chanceusenum+1;
                $LuckyNum->iswin = $LuckyNum->iswin?1:$data['iswin'];//第一次中了就不在修改了
                $LuckyNum->save();

            }else
            {
                $LuckyNum = new ActivityLuckyNum();
                $LuckyNum->activityluckyid = $res->id;
                $LuckyNum->clientid = 0;
                $LuckyNum->chancenum = $res->chancelimitnum;
                $LuckyNum->chanceusenum = 1;
                $LuckyNum->iswin = $data['iswin'];
                $LuckyNum->friendhelpusenum = 0;
                $LuckyNum->userid = $data['userid'];
                $LuckyNum->created_at = date('Y-m-d H:i:s');
                $LuckyNum->save();
            }

            $Record = new ActivityLuckyRecord();
            $Record->uuid = create_uuid();
            $Record->activityluckid = $res->id;
            $Record->prizeid = $data['id'];
            $Record->prizename = $data['name'];
            $Record->clientid = $LuckyNum->clientid;
            $Record->iswin = $data['iswin'];
            $Record->userid = $data['userid'];
            $Record->created_at = date('Y-m-d H:i:s');
            $Record->save();

            DB::commit();
            return true;
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }
}