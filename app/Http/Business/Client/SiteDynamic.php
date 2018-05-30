<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:35
 */

namespace App\Http\Business\Client;


use App\Http\Business\Common\ClientBase;
use App\Http\Model\Dynamic\Dynamic;
use Illuminate\Support\Facades\Cache;

class SiteDynamic extends ClientBase
{
    /**
     * 动态列表
     */
    public function DynamicList( $where, $request )
    {
        //Cache::flush();
        $tag = 'DynamicList'.$where['companyid'];
        $tagWhere = $request->input('page').json_encode($where,JSON_FORCE_OBJECT);
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $where, $request ){
            $sql = Dynamic::where( $where )->orderBy('id','desc')->with('dynamicToImages');//关联图片
                 //关联用户
                $sql->with(['dynamicToUser'=>function( $query ) use($where){
                    //关联用户表的职位
                    $query->with(['userToPosition'=>function( $query ) use($where){
                        $query->where(['companyid'=>$where['companyid']]);
                   }])->select('companyid','id','positionid','nickname','faceimg');
                    //关联评论
                },'dynamicToFollo'=>function( $query ){
                    //关联评论用户
                    $query->with(['dynamicCommentToUser'=>function( $query ){
                        $query->select('id','nickname');
                    }]);
                },'dynamicToStatistics'=>function($query){
                    $query->select('dynamicid','thumbsupnum','commentnum');
                }]);
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }
}