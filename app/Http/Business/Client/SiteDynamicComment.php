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
        $where['siteid'] = $data['siteid'];
        return DynamicComment::where( $where )->delete();
    }

    /**
     * @param $data
     * 添加评论
     */
    public function commentAdd( $data )
    {
        $dynamic = new DynamicComment();
        $dynamic->uuid = create_uuid();
        $dynamic->dynamicid = $data['dynamicid'];
        $dynamic->siteid = $data['siteid'];
        $dynamic->pid = $data['pid'];
        $dynamic->content = $data['content'];
        $dynamic->createuserid = $data['createuserid'];
        $dynamic->created_at = date("Y-m-d H:i:s");
        return $dynamic->save();
    }
}