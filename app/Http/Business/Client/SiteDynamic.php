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
use App\Http\Model\Dynamic\DynamicComment;
use App\Http\Model\Dynamic\DynamicImages;
use App\Http\Model\Dynamic\DynamicStatistics;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteDynamic extends ClientBase
{
    /**
     * 动态列表
     */
    public function DynamicList( $where, $request, $user, $siteID )
    {
        $tag = 'DynamicList'.$where['companyid'];
        if(is_array($siteID))
        {
            //缓存标签
            $tagWhere = $request->input('page').implode('',$where).implode('',$siteID);
        }else
        {
            $tagWhere = $request->input('page').implode('',$where);
        }
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $where, $request,$siteID ){
                $sql = Dynamic::where( $where )->orderBy('id','desc')->with('dynamicToImages');//关联图片
                //参与者的动态
                if( $siteID )
                {
                    $sql->whereIn('sitetid',$siteID);
                }
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
                    },'dynamicCommentToReplyUser'=>function($query){
                        $query->select('id','nickname');
                    }]);
                },'dynamicToStatistics'=>function($query){
                    $query->select('dynamicid','thumbsupnum','commentnum');
                }]);
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * 删除动态
     */
    public function destroyDynamic( $where )
    {
        try{
            DB::beginTransaction();
            //查询
            $dynamic = Dynamic::where($where)->first();
            if( $dynamic == false )
            {
                DB::commit();
                return false;
            }
            //删除统计
            DynamicStatistics::where(['dynamicid'=>$dynamic->id])->delete();
            //删除评论
            DynamicComment::where(['dynamicid'=>$dynamic->id])->delete();
            //删除动态图片
            $img = DynamicImages::where('dynamicid',$dynamic->id)->pluck('ossurl');
            if( count($img) )
            {
                foreach( $img as $row )
                {
                    (new \Upload())->delImg($row);
                }
            }
            DynamicImages::where('dynamicid',$dynamic->id)->delete();
            $dynamic->delete();
            DB::commit();
            return true;
        }catch ( \Exception $e )
        {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 动态详情
     */
    public function dynamicInfo($where)
    {
        return Dynamic::where($where)->with('dynamicToImages')->first();
    }

    /**
     * @param $where
     * @param $data
     * 修改动态
     */
    public function dynamicUp($where,$data)
    {
        $res = Dynamic::where($where)->first();
        if( $res )
        {
            try{
                DB::beginTransaction();
                //查询
                $res->content = $data['content'];
                //添加图片
                $img = $data['img'];
                if( $img )
                {
                    $upload = new \Upload();
                    $arr = explode(',',$data['img']);
                    foreach ( $arr as $k=>$row )
                    {
                        $addImg = $upload->uploadProductImage( $res->sitetid, $row, 'site_dynamic' );
                        $img = array();
                        if( $addImg )
                        {
                            //写入数据库
                            $img[$k]['dynamicid'] = $res->id;
                            $img[$k]['ossurl'] = 'site/'.$res->sitetid.'/dynamic/'.$row;
                            $img[$k]['type'] = 0;
                            $img[$k]['created_at'] = date("Y-m-d H:i:s");
                        }
                        if( count($img) )
                        {
                            DynamicImages::insert( $img );
                        }
                    }
                }
                //删除图片
                $delImg = $data['delimg'];
                if( $delImg )
                {
                    $upload = new \Upload();
                    $arrDel = explode(',',$data['delimg']);
                    foreach ( $arrDel as $dk=>$dRow )
                    {
                        $imgWhere['dynamicid'] = $res->id;
                        $imgWhere['ossurl'] = $dRow;
                        $del = DynamicImages::where($imgWhere)->delete();
                        if( $del )
                        {
                            $upload->delImg($dRow);
                        }
                    }
                }
                $res->save();
                DB::commit();
                return true;
            }catch ( \Exception $e )
            {
                DB::rollBack();
                return false;
            }
        }else
        {
            return false;
        }
    }
}