<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 16:04
 */

namespace App\Http\Business\Client;


use App\Http\Model\Site\SiteInvitation;
use Illuminate\Support\Facades\Cache;

class ClientSiteInvitation
{
    /**
     * @param $where
     * @param $request
     * 我的工地
     */
    public function siteInvitation( $where, $request )
    {
        $tag = 'siteInvitation'.$where['userid'];
        $tagWhere = $request->input('page');
         Cache::flush();
        $value = Cache::tags($tag)->remember( $tag.$tagWhere,config('configure.sCache'), function() use( $where, $request ){
            $sql = SiteInvitation::where( $where )->orderBy('id','desc');
            //关联工地
            $sql->with(['invitationToSite'=>function( $query ) use($where){
                //关联阶段和数据统计
                $query->with(['siteToCommpanyTag'=>function( $query ) use($where){
                    $query->where(['companyid'=>$where['companyid']])->select('name','id');
                }])->select('stageid','id','name','addr','explodedossurl');
            },'invitationToDynamicStatistics']);
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }
}