<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 10:42
 */

namespace App\Http\Business\Client;


use App\Http\Model\Dynamic\DynamicStatistics;
use App\Http\Model\Site\Site;
use App\Http\Model\Site\SiteFollowrecord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClientSiteFollowRecord
{

    /**
     * @param $where
     * @param $request
     * @return mixed
     * 我的关注工地
     */
    public function followRecord( $where, $request )
    {
      /*  $tag = 'followRecord'.$where['userid'];
        $tagWhere = $request->input('page');
       // Cache::flush();
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $where, $request ){
        */    $sql = SiteFollowrecord::where( $where )->orderBy('id','desc');
            //关联工地
            $sql->with(['followToSite'=>function( $query ) use($where){
                //关联阶段和数据统计
                $query->with(['siteToCommpanyTag'=>function( $query ) use($where){
                    $query->where(['companyid'=>$where['companyid']])->select('name','id');
                }])->select('stageid','id','name','addr','explodedossurl','linkednum','follownum');
            }]);
            return $sql->paginate(config('configure.sPage'));
       /* });
        return $value;*/
    }

    /**
     * @param $where
     * @param $request
     * 关注和取消
     */
    public function recordSite($where, $user, $request)
    {
        try{
            DB::beginTransaction();
            $res = SiteFollowrecord::where($where)->first();
            if( $res )
            {
                //取消关注未开发

                DB::commit();
               return true;
            }else
            {
                $wrecord = new SiteFollowrecord();
                $wrecord->uuid = create_uuid();
                $wrecord->companyid = $where['companyid'];
                $wrecord->storeid = $request->input('storeid');
                $wrecord->siteid = $request->input('siteid');
                $wrecord->cityid = $request->input('cityid');
                $wrecord->userid = $user->id;
                $wrecord->created_at = date("Y-m-d H:i:s");
                $wrecord->save();

                $res = Site::where(['companyid'=>$user->companyid,'id'=>$where['siteid']])->first();
                $res->follownum = (int)$res->follownum+1;
                $res->save();
            }
            DB::commit();
            return true;
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }
}