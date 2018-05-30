<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:35
 */

namespace App\Http\Business\Common;


use App\Http\Model\Log\Notice;
use Illuminate\Support\Facades\Cache;

class SystemMessage
{
    /**
     * @param $data
     * @return mixed
     * 消息列表
     */
    public function getNoticeList( $data )
    {
        $tag = 'NoticeList'.$data['userid'];
        $tagWhere = $data['page'];
        // Cache::flush();
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $data ){
            $sql = Notice::where('userid',$data['userid'] )->orderBy('id','desc');
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * @param $data
     * @return mixed
     * 读取消息
     */
    public function readNotice( $data )
    {
        return Notice::where( $data )->update(['isread'=>1]);
    }
}