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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Lucky
{
    public function getLuckyInfo( $data )
    {
        $res = new \stdClass();
        $res->info = ActivityLucky::where(['companyid'=>$data['companyid'],'id'=>$data['id']])->first();
        $res->luck_num = ActivityLuckyNum::where(['userid'=>$data['userid'],'activityluckyid'=>$data['id']])->first();
        //判断如果中途修改了人数限制那么就得判断
        if( $res->info->ischancelimit == 1 )
        {
            if( $res->luck_num )
            {
                if( $res->luck_num->chancenum != $res->info->chancelimitnum )
                {
                    $res->luck_num->chancenum = $res->info->chancelimitnum;
                    $res->luck_num->save();
                }

                if( $res->luck_num->chanceusenum > $res->info->chancelimitnum )
                {
                    $res->luck_num->chanceusenum = $res->info->chancelimitnum ;
                }
            }

        }
        $res->luck_user = $this->getLuckUser($data['id']);
        $res->luck_prize = ActivityLuckyPrize::where(['activityluckyid'=>$data['id']])->orderBy('id','asc')->get();
        return $res;
    }


    /**
     * @param $id
     * @return mixed
     * 中奖客户
     */
    public function getLuckUser( $id )
    {

        if( Cache::has('getLuckUser'.$id) )
        {
            return Cache::get('getLuckUser'.$id);
        }else
        {
            $arr = [];
            $data = ActivityLuckyRecord::where(['activityluckid'=>$id,'iswin'=>1])->with(['luckyRecordToClient'=>function($query){
                $query->select('id','phone','name');
            }])->get();
            foreach ( $data as $row )
            {
                if($row->luckyRecordToClient)
                {
                    $arr[] = '恭喜用户'.substr_replace($row->luckyRecordToClient->phone,'****',3,4).'抽中了'.$row->prizename;
                }
            }
            Cache::put('getLuckUser'.$id,$arr,config('configure.sCache'));
            return $arr;
        }


    }

    /**
     * @param $data
     * @return mixed
     * 我的中将信息
     */
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
        $prize = ActivityLuckyPrize::where('activityluckyid',$data['id'])->select('id','levelname','lastnum','levelid','name','picture')->get()->toArray();
        //计算概率
        $luckChance = $this->luckChance($data['id']);
        //超出概率
        if( $luckChance > $res->winpoint )
        {
           foreach ( $prize as $k=>$row )
           {
               if( $row['levelid'] == 1 )
               {
                   $saveData['userid'] = $data['userid'];
                   $saveData['iswin'] = 0;
                   $saveData['name'] = $row['name'];
                   $saveData['id'] = $row['id'];
                   $saveData['index'] = $k;
                   $saveData['picture'] = $row['picture'];
               }
           }
           $luckRes = $this->saveLuck($res,$saveData);
           if( $luckRes )
           {
               responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$saveData);
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
            foreach ( $prize as $k=>$row )
            {
                if( $row['levelid'] == 1 )
                {
                    $saveData['userid'] = $uid;
                    $saveData['iswin'] = 0;
                    $saveData['name'] = $row['name'];
                    $saveData['id'] = $row['id'];
                    $saveData['index'] = $k;
                    $saveData['picture'] = $row['picture'];
                }
            }
            $luckRes = $this->saveLuck($res,$saveData);
            if( $luckRes )
            {
                responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$saveData);
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
        $data['picture'] = $prizeInfo['picture'];
        $luckRes = $this->saveLuck($res,$data);
        if( $luckRes )
        {
           return $data;
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
                Cache::forget('getLuckUser'.$res->id);

                //TODO::抽完奖，立即提交客户信息

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
                $LuckyNum->uuid = create_uuid();
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

    /**
     * @param $data
     * @return bool
     * 抽奖客户
     */
    public function lucyClient( $data )
    {
       try{
            //开启事务
            DB::beginTransaction();

           //TODO::因所有抽完中奖后未填写客户资料时候都会记录client表，所以之后再填写客户信息就是完善客户信息update (name phone)

            //添加用户
            $client = new Client();
            $client->uuid = create_uuid();
            $client->companyid = $data['companyid'];
            $client->storeid = $data['storeid']?$data['storeid']:0;
            $client->sourcecateid = $data['sourcecateid'];
            $client->sourceid = $data['sourceid'];
            $client->phone = $data['phone'];
            $client->name = $data['name'];
            $client->area = 0;
            $client->content = $data['content'];
            $client->wechatopenid = $data['wechatopenid'];
            $client->created_at = date("Y-m-d H:i:s");
            $client->save();
            //修改抽奖数据
            $res = ActivityLucky::where('id',$data['activityluckyid'])->first();

            //写记录
            if( $res->ishasconnectinfo == 1)
            {
                $LuckyNum = new ActivityLuckyNum();
                $LuckyNum->uuid = create_uuid();
                $LuckyNum->activityluckyid = $data['activityluckyid'];
                $LuckyNum->clientid = $client->id;
                $LuckyNum->chancenum = $res->chancelimitnum;
                $LuckyNum->chanceusenum = 0;
                $LuckyNum->iswin = 0;
                $LuckyNum->friendhelpusenum = 0;
                $LuckyNum->userid = $data['userid'];
                $LuckyNum->created_at = date('Y-m-d H:i:s');
                $LuckyNum->save();
            }

            //修改记录
            if( $res->ishasconnectinfo == 2 )
            {
                $LuckyNum = ActivityLuckyNum::where(['activityluckyid'=>$data['activityluckyid'],'userid'=>$data['userid']])->first();
                $LuckyNum->clientid = $client->id;
                $LuckyNum->save();
                ActivityLuckyRecord::where(['activityluckid'=>$data['activityluckyid'],'userid'=>$data['userid']])->update(['clientid'=>$client->id]);
            }
            DB::commit();
            return true;
       }catch (\Exception $e){
            DB::rollBack();
            return false;
       }
    }
}