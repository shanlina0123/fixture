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

class SiteDynamicStatistics extends ClientBase
{

    /**
     * 点赞
     */
    public function Fabulous( $data )
    {

        $where['dynamicid'] = $data['dynamicid'];
        $statistics = DynamicStatistics::where($where)->first();
        if( $statistics )
        {
            $statistics->thumbsupnum = $statistics->thumbsupnum+1;
            return $statistics->save();
        }else
        {
            if( $data['siteid'] )
            {
                $statistics = DynamicStatistics::where('siteid',$data['siteid'])->first();
                if($statistics)
                {
                    $statistics->dynamicid = $data['dynamicid'];
                    $statistics->thumbsupnum = $statistics->thumbsupnum+1;
                    return $statistics->save();
                }else
                {
                    $statistics = new DynamicStatistics();
                }
            }else
            {
                $statistics = new DynamicStatistics();
            }
            $statistics->dynamicid = $data['dynamicid'];
            $statistics->siteid = $data['siteid'];
            $statistics->linkednum = 0;
            $statistics->commentnum = 0;
            $statistics->thumbsupnum = 1;
            $statistics->follownum = 0;
            return $statistics->save();
        }
    }
}