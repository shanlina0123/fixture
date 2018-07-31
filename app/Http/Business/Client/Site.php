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
use App\Http\Model\Site\Site as SiteModel;

class Site extends ClientBase
{

    /**
     * @param $where
     * 工地列表
     */
    public function siteList( $where,$user )
    {
        $tag = 'siteScreeningList'.$user->companyid;
        $tags = http_build_query($where);
        $value = Cache::tags($tag)->remember( $tags,config('configure.sCache'), function() use( $where,$user ){
            $sql = SiteModel::where(['companyid'=>$user->companyid,'isopen'=>1])->orderBy('id','desc');
            //拼接条件
            if( array_has($where,'cityid') && $where['cityid'])
            {
                //城市
                $sql->where('cityid',$where['cityid']);
            }
            if( array_has($where,'roomtypeid') && $where['roomtypeid'])
            {
                //户型
                $sql->where('roomtypeid',$where['roomtypeid']);
            }
            if( array_has($where,'roomstyleid') && $where['roomstyleid'])
            {
                //装修风格
                $sql->where('roomstyleid',$where['roomstyleid']);
            }
            if( array_has($where,'budget') && $where['budget'])
            {
                //预算
                //1.拆分 2.计算
                $budget = explode(',',$where['budget']);
                if( is_array($budget) && count($budget)==2 )
                {
                    //符合数据格式
                    if( $budget[0] == 0 )
                    {
                        //开始价格
                        $sql->where('budget','<=',$budget[1]);
                    }elseif( $budget[1] == 0 )
                    {
                        //结束价格
                        $sql->where('budget','>=',$budget[0]);
                    }else
                    {
                        //区间价格
                        $sql->whereRaw('budget >= ? and budget <= ?',[$budget[0],$budget[1]]);
                    }
                }
            }
            $sql->with(['siteToCity'=>function($query){
                //关联城市
                $query->select('id','name');
            },'siteToRoomType'=>function($query){
                //关联户型
                $query->select('id','name');
            },'siteToRoomStyle'=>function($query){
                //关联风格
                $query->select('id','name');
            }]);
            return $sql->select('id','name','companyid','cityid','roomtypeid','roomstyleid','addr','explodedossurl','budget')->paginate(config('configure.sPage'));
        });
        return $value;
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
            $obj->city = array_prepend($obj->city, ['id'=>'','name'=>'不限','byname'=>'所在城市']);
            $obj->roomtype = RoomType::where('companyid',$companyId)->select('id','name')->get()->toArray(); //户型
            $obj->roomtype = array_prepend($obj->roomtype, ['id'=>'','name'=>'不限','byname'=>'户型选择']); //户型
            $obj->roomstyle = RoomStyle::where('companyid',$companyId)->select('id','name')->get()->toArray(); //装修风格
            $obj->roomstyle = array_prepend($obj->roomstyle, ['id'=>'','name'=>'不限','byname'=>'装修风格']);
            $obj->budget = config('configure.budget');
            Cache::put('siteScreening'.$companyId,$obj,config('configure.sCache'));
            return $obj;
        }
    }
}