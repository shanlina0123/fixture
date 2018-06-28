<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 10:23
 */

namespace App\Http\Business\Store;


use App\Http\Model\Site\SiteParticipant;
use Illuminate\Support\Facades\Cache;

class ParticipantBusiness
{
    /**
     * @param $where
     * 公司成员列表
     */
    public function participantList( $where )
    {
       if(Cache::has('siteParticipant'.$where['companyid']))
       {
           $data = Cache::get('siteParticipant'.$where['companyid']);
       }else
       {
           $data = SiteParticipant::where($where)->with('participantToPosition')->get();
           Cache::put('siteParticipant'.$where['companyid'],$data,config('configure.sCache'));
       }
       return $data;
    }
}