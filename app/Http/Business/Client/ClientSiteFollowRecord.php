<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 10:42
 */

namespace App\Http\Business\Client;


use App\Http\Model\Site\SiteFollowrecord;
use Illuminate\Support\Facades\Cache;

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
        $tag = 'followRecord'.$where['userid'];
        $tagWhere = $request->input('page');
       // Cache::flush();
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $where, $request ){
            $sql = SiteFollowrecord::where( $where )->orderBy('id','desc');
            //关联工地
            $sql->with(['followToSite'=>function( $query ) use($where){
                //关联阶段和数据统计
                $query->with(['siteToCommpanyTag'=>function( $query ) use($where){
                    $query->where(['companyid'=>$where['companyid']])->select('name','id');
                }])->select('stageid','id','name','addr','explodedossurl');
            },'followToDynamicStatistics']);
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }
}