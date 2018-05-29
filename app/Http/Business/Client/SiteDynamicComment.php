<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 15:17
 */

namespace App\Http\Business\Client;


use App\Http\Business\Common\ClientBase;
use App\Http\Model\Dynamic\DynamicComment;
use App\Http\Model\Dynamic\DynamicStatistics;
use Illuminate\Support\Facades\DB;

class SiteDynamicComment extends ClientBase
{
    /**
     * @param $data
     * 删除评论
     */
    public function commentDestroy( $data )
    {
        $where['id'] = $data['id'];
        $where['dynamicid'] = $data['dynamicid'];
        return DynamicComment::where( $where )->delete();
    }

    /**
     * @param $data
     * 添加评论
     */
    public function commentAdd( $data )
    {
        try{
            DB::beginTransaction();
            $dynamic = new DynamicComment();
            $dynamic->uuid = create_uuid();
            $dynamic->dynamicid = $data['dynamicid'];
            $dynamic->siteid = $data['siteid'];
            $dynamic->pid = $data['pid'];
            $dynamic->content = $data['content'];
            $dynamic->createuserid = $data['createuserid'];
            $dynamic->created_at = date("Y-m-d H:i:s");
            $dynamic->save();

            $where['dynamicid'] = $data['dynamicid'];
            $statistics = DynamicStatistics::where($where)->first();
            if( $statistics )
            {
                $statistics->commentnum = $statistics->commentnum+1;
                $statistics->save();
            }else
            {
                $statistics = new DynamicStatistics();
                $statistics->dynamicid = $data['dynamicid'];
                $statistics->siteid = $data['siteid'];
                $statistics->linkednum = 0;
                $statistics->commentnum = 1;
                $statistics->thumbsupnum = 0;
                $statistics->follownum = 0;
                $statistics->save();
            }
            DB::commit();
            return $dynamic;
        }catch (\Exception $e)
        {
            DB::rollBack();
            return false;
        }

    }
}