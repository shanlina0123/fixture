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
        $res->luck_num = ActivityLuckyNum::where(['userid'=>$data['userid'],'activityluckyid'=>$data['id']])->with('LuckyNumToClient')->first();
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
    public function lucyDraw( $data, $user )
    {
        //1.判断活动是不是在线
        //2.判断活动开始时间
        //3.判断活动结束时间
        //4.判断个人活动参与次数
        //5.判断中将次数
        //6.抽奖
        $res = ActivityLucky::where(['companyid'=>$user->companyid,'id'=>$data['id']])->first();
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
            $userLuckNum = ActivityLuckyNum::where(['activityluckyid'=>$data['id'],'userid'=>$user->id])->value('chanceusenum');
            if( $res->chancelimitnum <= $userLuckNum )
            {
                responseData(\StatusCode::ERROR,'您的抽奖次数已达上限');
            }
        }
        //查询奖品的数量
        $prize = ActivityLuckyPrize::where('activityluckyid',$data['id'])->select('id','levelname','lastnum','levelid','name','picture')->get()->toArray();
        //判断中奖次数
        $RecordNum = ActivityLuckyRecord::where(['activityluckid'=>$data['id'],'userid'=>$user->id,'iswin'=>1])->count();
        if( $RecordNum >= $res->everywinnum )
        {
            foreach ( $prize as $k=>$row )
            {
                if( $row['levelid'] == 1 )
                {
                    $saveData['iswin'] = 0;
                    $saveData['name'] = $row['name'];
                    $saveData['id'] = $row['id'];
                    $saveData['index'] = $k;
                    $saveData['picture'] = $row['picture'];
                }
            }
            $luckRes = $this->saveLuck($res,$saveData,$user);
            if( $luckRes )
            {
                responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$saveData);
            }
        }
        //计算概率
        $luckChance = $this->luckChance($data['id']);
        //超出概率
        if( $luckChance > $res->winpoint )
        {
           foreach ( $prize as $k=>$row )
           {
               if( $row['levelid'] == 1 )
               {
                   $saveData['iswin'] = 0;
                   $saveData['name'] = $row['name'];
                   $saveData['id'] = $row['id'];
                   $saveData['index'] = $k;
                   $saveData['picture'] = $row['picture'];
               }
           }
           $luckRes = $this->saveLuck($res,$saveData,$user);
           if( $luckRes )
           {
               responseData(\StatusCode::SUCCESS,'您的抽奖次信息',$saveData);
           }
            responseData(\StatusCode::ERROR,'参与失败');
        }
        //在概率范围内
        return $this->luckAlgorithm($prize, $res, $user);

    }

    /**
     * 中将算法
     */
    public function luckAlgorithm( $prize, $res, $user )
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
                    $saveData['iswin'] = 0;
                    $saveData['name'] = $row['name'];
                    $saveData['id'] = $row['id'];
                    $saveData['index'] = $k;
                    $saveData['picture'] = $row['picture'];
                }
            }
            $luckRes = $this->saveLuck($res,$saveData,$user);
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
        $data['picture'] = $prizeInfo['picture'];
        $luckRes = $this->saveLuck($res,$data,$user);
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
    public function saveLuck( $res, $data, $user )
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
            }
            //客户数据统计
            $LuckyNum = ActivityLuckyNum::where(['activityluckyid'=>$res->id,'userid'=>$user->id])->first();
            if( $LuckyNum )
            {
                //没有客户信息
                if( $LuckyNum->clientid == false )
                {
                    //添加用户
                    $client = new Client();
                    $client->uuid = create_uuid();
                    $client->companyid = $res->companyid;
                    $client->storeid = $res->storeid;
                    $client->cityid = $res->cityid;
                    $client->sourcecateid = 2;//客户来源分类
                    $client->sourceid = 5;//客户来源
                    $client->name = $user->nickname;
                    $client->wechatopenid = $user->wechatopenid;
                    $client->area = 0;
                    $client->content = $res->title;
                    $client->created_at = date("Y-m-d H:i:s");
                    $client->save();
                    $LuckyNum->clientid = $client->id;
                }
                $LuckyNum->activityluckyid = $res->id;
                $LuckyNum->chanceusenum = $res->ischancelimit?$LuckyNum->chanceusenum+1:0;//不限制机会
                $LuckyNum->iswin = $LuckyNum->iswin?1:$data['iswin'];//第一次中了就不在修改了
                $LuckyNum->save();

            }else
            {
                //添加用户
                $client = new Client();
                $client->uuid = create_uuid();
                $client->companyid = $res->companyid;
                $client->storeid = $res->storeid;
                $client->cityid = $res->cityid;
                $client->sourcecateid = 2;//客户来源分类
                $client->sourceid = 5;//客户来源
                $client->name = $user->nickname;
                $client->wechatopenid = $user->wechatopenid;
                $client->area = 0;
                $client->content = $res->title;
                $client->created_at = date("Y-m-d H:i:s");
                $client->save();

                //添加抽奖数据统计
                $LuckyNum = new ActivityLuckyNum();
                $LuckyNum->uuid = create_uuid();
                $LuckyNum->activityluckyid = $res->id;
                $LuckyNum->clientid = $client->id;
                $LuckyNum->chancenum = $res->chancelimitnum;
                $LuckyNum->chanceusenum = 1;
                $LuckyNum->iswin = $data['iswin'];
                $LuckyNum->friendhelpusenum = 0;
                $LuckyNum->userid = $user->id;
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
            $Record->userid = $user->id;
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
     * 抽奖客户填写资料
     */
    public function lucyClient( $data, $user )
    {
       try{
            //开启事务
            DB::beginTransaction();
            //查询活动
            $res = ActivityLucky::where('id',$data['activityluckyid'])->first();
            //查询奖品统计数据
            $LuckyNum = ActivityLuckyNum::where(['activityluckyid'=>$data['activityluckyid'],'userid'=>$user->id])->first();
            if( $LuckyNum )
            {
                //已经参与了抽奖
                if($LuckyNum->clientid)
                {
                    //有客户信息了修改
                    $client = Client::where(['companyid'=>$user->companyid,'id'=>$LuckyNum->clientid])->first();
                    $client->phone = $data['phone'];
                    $client->name = $data['name'];
                    $client->save();
                }else
                {
                    //新建客户信息
                    $client = new Client();
                    $client->uuid = create_uuid();
                    $client->companyid = $res->companyid;
                    $client->storeid = $res->storeid;
                    $client->cityid = $res->cityid;
                    $client->sourcecateid = 2;//客户来源分类
                    $client->sourceid = 5;//客户来源
                    $client->phone = $data['phone'];
                    $client->name = $data['name'];
                    $client->area = 0;
                    $client->content = $res->title;
                    $client->wechatopenid = $user->wechatopenid;
                    $client->created_at = date("Y-m-d H:i:s");
                    $client->save();
                }
            }else
            {
                //新建客户信息和个人抽奖数据
                //新建客户信息
                $client = new Client();
                $client->uuid = create_uuid();
                $client->companyid = $res->companyid;
                $client->storeid = $res->storeid;
                $client->cityid = $res->cityid;
                $client->sourcecateid = 2;//客户来源分类
                $client->sourceid = 5;//客户来源
                $client->phone = $data['phone'];
                $client->name = $data['name'];
                $client->area = 0;
                $client->content = $res->title;
                $client->wechatopenid = $user->wechatopenid;
                $client->created_at = date("Y-m-d H:i:s");
                $client->save();

                $LuckyNum = new ActivityLuckyNum();
                $LuckyNum->uuid = create_uuid();
                $LuckyNum->activityluckyid = $data['activityluckyid'];
                $LuckyNum->clientid = $client->id;
                $LuckyNum->chancenum = $res->chancelimitnum;
                $LuckyNum->chanceusenum = 0;
                $LuckyNum->iswin = 0;
                $LuckyNum->friendhelpusenum = 0;
                $LuckyNum->userid = $user->id;
                $LuckyNum->created_at = date('Y-m-d H:i:s');
                $LuckyNum->save();
            }
            DB::commit();
            return true;
       }catch (\Exception $e){
            DB::rollBack();
            return false;
       }
    }

    /**
     * @param $user
     * 抽奖列表
     */
    public function lucyDrawList( $user )
    {
        $where['isonline'] = 1;
        $where['companyid'] = $user->companyid;
        if( Cache::get('lucyDrawList'.$user->companyid) )
        {
            return Cache::get('lucyDrawList'.$user->companyid);
        }else
        {
            $data = ActivityLucky::where($where)->select('id','advurl')->orderBy('id','desc')->get()->toArray();
            Cache::put('lucyDrawList'.$user->companyid,$data,config('configure.sCache'));
            return $data;
        }
    }
}