<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 15:17
 */

namespace App\Http\Business\Client;
use App\Http\Business\Common\ClientBase;
use App\Http\Model\Dynamic\DynamicStatistics;
use App\Http\Model\User\UserDynamicGive;
use Illuminate\Support\Facades\DB;

class SiteDynamicStatistics extends ClientBase
{

    /**
     * 点赞
     */
    public function Fabulous( $data, $user )
    {

        $where['dynamicid'] = $data['dynamicid'];
        $type = $data['type'];
        $statistics = DynamicStatistics::where($where)->first();
        if( $statistics )
        {
            DB::beginTransaction();
            //点赞
            if( $type == 1 )
            {
                $give['companyid'] = $user->companyid;
                $give['dynamicid'] = $data['dynamicid'];
                $give['userid'] = $user->id;
                $resGive = UserDynamicGive::firstOrCreate($give);
                $statistics->thumbsupnum = $resGive?$statistics->thumbsupnum+1:$statistics->thumbsupnum;

            }else
            {
                //取消点赞
                $give['companyid'] = $user->companyid;
                $give['dynamicid'] = $data['dynamicid'];
                $give['userid'] = $user->id;
                $resGive = UserDynamicGive::where($give)->delete();
                if( $resGive )
                {
                    $statistics->thumbsupnum =  $statistics->thumbsupnum? $statistics->thumbsupnum-1: $statistics->thumbsupnum;
                }
            }
            DB::commit();
            return $statistics->save();
        }else
        {
            DB::beginTransaction();
            $statistics = new DynamicStatistics();
            $statistics->dynamicid = $data['dynamicid'];
            $statistics->siteid = $data['siteid'];
            $statistics->commentnum = 0;
            $statistics->thumbsupnum = 1;
            $res = $statistics->save();
            //点赞
            if( $type == 1 )
            {
                $give['companyid'] = $user->companyid;
                $give['dynamicid'] = $data['dynamicid'];
                $give['userid'] = $user->id;
                $resGive = UserDynamicGive::firstOrCreate($give);

            }else
            {
                //取消点赞
                $give['companyid'] = $user->companyid;
                $give['dynamicid'] = $data['dynamicid'];
                $give['userid'] = $user->id;
                $resGive = UserDynamicGive::where($give)->delete();
            }
            if( $res &&  $resGive )
            {
                DB::commit();
                return true;
            }else
            {
                DB::rollBack();
                return false;
            }
        }
    }
}