<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 14:17
 */

namespace App\Http\Business\Server;


use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Dynamic\Dynamic;
use App\Http\Model\Dynamic\DynamicComment;
use App\Http\Model\Dynamic\DynamicImages;
use App\Http\Model\Dynamic\DynamicStatistics;
use App\Http\Model\Site\Site;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DynamicBusiness
{

    /**
     * @param $where
     * @param $request
     * @return mixed
     * 动态列表
     */
    public function getDynamicList( $where, $request )
    {
        $tag = 'DynamicListPc'.$where['companyid'];
        $tagWhere = implode('',$where).$request->input('page');
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $where, $request ){
            $sql = Dynamic::where( $where )->orderBy('id','desc');
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * 动态详情
     */
    public function dynamicInfo($where)
    {
        return Dynamic::where($where)->with('dynamicToImages')->first();
    }

    /**
     * @param $companyId
     * @param $uuid
     * @return bool|\stdClass
     * 更新工地进度数据
     */
    public function getSiteRenew( $companyId, $id )
    {
        $obj = new \stdClass();
        $site = Site::where(['companyid'=>$companyId,'id'=>$id])->select('stagetemplateid','stageid','name','isfinish')->first();
        if( $site )
        {
            if( $site->isfinish == 1 )
            {
                $obj->status = 0;
                $obj->msg = '已完工不能修改';
                return $obj;
            }
            //自定义模板
            $obj->tage = CompanyStageTemplateTag::where(['stagetemplateid'=>$site->stagetemplateid,'status'=>1,'companyid'=>$companyId])->get();
            $obj->stageid = $site->stageid;
            $obj->status = 1;
            $obj->msg = '更改进度信息';
            return $obj;
        }else
        {
            $obj->status = 0;
            $obj->msg = '未查询到信息';
            return $obj;
        }
    }


    /**
     * @param $uuid
     * @param $data
     * 动态修改
     */
    public function updateDynamic( $uuid, $data )
    {
        $where['uuid'] = $uuid;
        $where['companyid'] = $data['companyid'];
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
}