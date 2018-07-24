<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20
 * Time: 17:21
 */

namespace App\Http\Business\Client;


use App\Http\Business\Common\ClientBase;
use App\Http\Model\Data\City;
use App\Http\Model\Data\RoomStyle;
use App\Http\Model\Data\RoomType;
use App\Http\Model\Store\Store;
use Illuminate\Support\Facades\Cache;

class Site extends ClientBase
{

    /**
     * @param $where
     * 工地列表
     */
    public function siteList( $where )
    {

    }

    /**
     * 工地查询筛选
     */
    public function siteScreeningConditions( $companyId )
    {
        if( Cache::get('siteScreening'.$companyId) )
        {
            return Cache::get('siteScreening'.$companyId);
        }else
        {
            $obj = new \stdClass();
            //查询店铺所在的城市得到筛选的市
            $cityID = Store::where('companyid',$companyId)->groupBy('cityid')->pluck('cityid')->toArray();
            $obj->city = City::whereIn('id',$cityID)->select('id','name')->get()->toArray();
            $obj->city = array_prepend($obj->city, ['id'=>'','name'=>'不限']);
            $obj->roomtype = RoomType::where('companyid',$companyId)->select('id','name')->get()->toArray(); //户型
            $obj->roomtype = array_prepend($obj->roomtype, ['id'=>'','name'=>'不限']); //户型
            $obj->roomstyle = RoomStyle::where('companyid',$companyId)->select('id','name')->get()->toArray(); //装修风格
            $obj->roomstyle = array_prepend($obj->roomstyle, ['id'=>'','name'=>'不限']);
            $obj->budget = config('configure.budget');
            Cache::put('siteScreening'.$companyId,$obj,config('configure.sCache'));
            return $obj;
        }
    }
}