<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Store;
use App\Http\Business\Common\StoreBase;
use App\Http\Model\Company\CompanyStageTemplate;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Data\RenovationMode;
use App\Http\Model\Data\RoomStyle;
use App\Http\Model\Data\RoomType;
use App\Http\Model\Data\StageTemplate;
use App\Http\Model\Data\StageTemplateTag;
use App\Http\Model\Dynamic\Dynamic;
use App\Http\Model\Dynamic\DynamicComment;
use App\Http\Model\Dynamic\DynamicImages;
use App\Http\Model\Dynamic\DynamicStatistics;
use App\Http\Model\Site\Site;
use App\Http\Model\Site\SiteFollowrecord;
use App\Http\Model\Site\SiteParticipant;
use App\Http\Model\Site\SiteStageschedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteBusiness extends StoreBase
{
    /**
     * @param $data
     * @return bool
     * 发不工地
     */
    public function siteSave( $data )
    {
        try{

            DB::beginTransaction();
            //添加工地
            $site = new Site();
            $site->uuid = create_uuid();
            $site->companyid = $data['companyid'];
            $site->storeid = $data['storeid'];
            $site->stageid = $data['stageid'];
            $site->stagetemplateid = $data['stagetemplateid'];
            $site->isdefaulttemplate = $data['isdefaulttemplate'];
            $site->isopen = $data['isopen'];
            $site->doornumber = $data['doornumber'];
            $site->name = $data['name'];
            $site->lat = $data['lat'];
            $site->lng = $data['lng'];
            $site->addr = $data['addr'];
            $site->createuserid = 17;//发布者的id
            $site->save();
            //添加动态
            $dynamic = new Dynamic();
            $dynamic->uuid = create_uuid();
            $dynamic->companyid = $data['companyid'];
            $dynamic->storeid = $data['storeid'];
            $dynamic->sitetid = $site->id;
            $dynamic->tablesign = 1;
            $dynamic->createuserid = $site->createuserid;
            $dynamic->content = '新建工地：感谢业主大大信任，'.$data['name'].'今日开工啦。大吉大利，家宅平安!';
            $dynamic->type = 0;
            $dynamic->status = 1;
            $dynamic->created_at = date("Y-m-d H:i:s");
            $dynamic->save();
            //添加进度
            $progress = new SiteStageschedule();
            $progress->uuid = create_uuid();
            $progress->dynamicid = $dynamic->id;
            $progress->siteid = $site->id;
            $progress->stagetagid = $data['stageid'];
            $progress->isstagedefault = $data['isdefaulttemplate'];
            $progress->tablesign = 1;
            $progress->stageuserid = $site->createuserid;
            $progress->positionid = $site->createuserid;
            $progress->created_at = date("Y-m-d H:i:s");
            $progress->save();

            DB::commit();
            return true;

        }catch ( Exception $e )
        {
            DB::rollBack();
            return false;
        }

    }


    /**
     * @param $data
     * @return mixed
     * 工地列表
     */
    public function siteList( $data )
    {
        //Cache::flush();
        $tag = 'siteHome'.$data['storeid'];
        $where = array_has($data,'page')?$data['page']:1;
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $data ){
            $sWhere['companyid'] = $data['companyid'];
            $sWhere['storeid'] = $data['storeid'];
            return Site::where( $sWhere )->orderBy('id','desc')->with(
                [
                 'siteToDynamicStatistics'=>function( $query ){
                     $query->select('siteid','linkednum','follownum');
                 },
                 'siteToDataTag'=>function( $query ){
                     $query->select('id','stagetemplateid','name');
                 },
                 'siteToCommpanyTag'=>function( $query ){
                     $query->select('id','stagetemplateid','name');
                 },'siteToFolloWrecord'=>function( $query ){
                     $query->select('siteid');
                 }
                ]
            )->select('id','uuid','name','addr','explodedossurl','stageid','isfinish','isopen')->paginate(config('configure.sPage'));
        });
        return $value;
    }


    /**
     * 删除工地
     */
    public function siteDestroy( $data )
    {
        try{
            $swhere['companyid'] = $data['companyid'];
            $swhere['storeid'] = $data['storeid'];
            $swhere['id'] = $data['id'];
            $res = Site::where($swhere)->first();
            if( $res )
            {
                DB::beginTransaction();
                //删除工地动态
                $dynamic = Dynamic::where(['companyid'=>$res->companyid,'sitetid'=>$res->id])->first();
                if( $dynamic )
                {
                    //删除统计
                    DynamicStatistics::where(['siteid'=>$res->id,'dynamicid'=>$dynamic->id])->delete();
                    //删除评论
                    DynamicComment::where(['siteid'=>$res->id,'dynamicid'=>$dynamic->id])->delete();
                    //删除动态图片
                    DynamicImages::where(['dynamicid'=>$dynamic->id])->deleted();

                    $dynamic->delete();
                }
                //删除工地参与者
                SiteParticipant::where('siteid',$res->id)->delete();
                //删除工地阶段记录
                SiteStageschedule::where('siteid',$res->id)->delete();
                //删除观光团关注的工地
                SiteFollowrecord::where('siteid',$res->id)->delete();
                //删除工地
                $res->delete();
                DB::commit();
                return true;
            }else
            {
                responseData(\StatusCode::ERROR,'工地信息不存在',$res);
            }
        }catch (\Exception $e)
        {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 工地是否公开
     */
    public function siteIsOpen( $data )
    {
        $sWhere['companyid'] = $data['companyid'];
        $sWhere['storeid'] = $data['storeid'];
        $sWhere['id'] = $data['id'];
        $res = Site::where($sWhere)->first();
        if( $res )
        {
            $res->isopen = $data['isopen'];
            return $res->save();
        }else
        {
            responseData(\StatusCode::ERROR,'工地信息不存在',$res);
        }
    }

    /**
     * @param $data
     * @return mixed
     * 设置完工
     */
    public function siteIsFinish( $data )
    {
        $sWhere['companyid'] = $data['companyid'];
        $sWhere['storeid'] = $data['storeid'];
        $sWhere['id'] = $data['id'];
        $res = Site::where($sWhere)->first();
        if( $res )
        {
            $res->isfinish = 1;
            return $res->save();
        }else
        {
            responseData(\StatusCode::ERROR,'工地信息不存在',$res);
        }
    }

    /**
     * @param $data
     * @return mixed
     * 工地数据
     */
    public function siteEdit( $data )
    {
        $sWhere['companyid'] = $data['companyid'];
        $sWhere['storeid'] = $data['storeid'];
        $sWhere['id'] = $data['id'];
        $res = Site::where($sWhere)->first();
        if( $res )
        {
            $res->store = $res->siteToStore?$res->siteToStore->name:'';//关联店铺
            if( $res->isdefaulttemplate )
            {
                //系统模板
                $res->tag = StageTemplate::where('id',$res->stagetemplateid)->with(['stageTemplateToTemplateTag'=>function($query){
                        $query->orderBy('sort','asc')->select('id','name','stagetemplateid');
                    }])->select('id','name')->first();
            }else
            {
                //公司模板
                $res->tag = CompanyStageTemplate::where(['companyid'=>$data['companyid'],'id'=>$res->stagetemplateid])->with(['stageTemplateToTemplateTag'=>function($query){
                    $query->orderBy('sort','asc')->select('id','name','stagetemplateid');
                }])->select('id','name')->first();
            }
            $res->roomStyle = $this->getRoomStyle(); //装修风格
            $res->renovationMode = $this->getRenovationMode();//装修方式
            $res->roomType = $this->getRoomType(); //户型
            return $res;

        }else
        {
            responseData(\StatusCode::ERROR,'工地信息不存在',$res);
        }
    }


    /**
     * 户型
     */
    public function getRoomType()
    {
        if( Cache::get('roomType') )
        {
            $roomType = Cache::get('roomType');
        }else
        {
            $roomType = RoomType::where('status',1)->select('id','name')->get();
            Cache::put('roomType',$roomType,config('configure.sCache'));
        }
        return $roomType;
    }

    /**
     * 装修风格
     */
    public function getRoomStyle()
    {
        if( Cache::get('roomStyle') )
        {
            $roomStyle = Cache::get('roomStyle');
        }else
        {
            $roomStyle = RoomStyle::where('status',1)->select('id','name')->get();
            Cache::put('roomStyle',$roomStyle,config('configure.sCache'));
        }
        return $roomStyle;
    }

    /**
     * @return mixed
     * 装修方式
     */
    public function getRenovationMode()
    {
        if( Cache::get('renovationMode') )
        {
            $renovationMode = Cache::get('renovationMode');
        }else
        {
            $renovationMode = RenovationMode::where('status',1)->select('id','name')->get();
            Cache::put('renovationMode',$renovationMode,config('configure.sCache'));
        }
        return $renovationMode;
    }

    /**
     * @param $data
     * 修改工地
     */
    public function siteUpdate( $data )
    {
        $site = Site::where(['id'=>$data['id'],'companyid'=>$data['companyid'],'storeid'=>$data['storeid']])->first();
        if( $site == false )
        {
            responseData(\StatusCode::ERROR,'未查询到信息');
        }
        if( $site->isfinish == 1 )
        {
            responseData(\StatusCode::ERROR,'已完工不可修改');
        }
        if( $data['photo'] )
        {
            $res = $this->toSsoImg($site->uuid,$data['photo']);
            if( $res == true )
            {
                if( $site->explodedossurl )
                {
                    //删除原始图片
                    (new \Upload())->delImg($site->explodedossurl);
                }
                $site->explodedossurl = 'site/'.$site->uuid.'/info/'.$data['photo'];
            }
        }
        $site->name = $data['name'];
        $site->stageid = $data['stageid'];
        $site->addr = $data['addr'];
        $site->lng = $data['lng'];
        $site->lat = $data['lat'];
        $site->doornumber = $data['doornumber'];//门牌
        $site->roomtypeid = $data['roomtypeid'];//户型
        $site->roomstyleid = $data['roomstyleid'];//风格
        $site->renovationmodeid = $data['renovationmodeid'];//方式
        $site->budget = $data['budget'];//预算
        $site->acreage = $data['acreage'];//面积
        $site->roomshap = $data['room'].'室'.$data['office'].'厅'.$data['kitchen'].'厨'.$data['wei'].'卫';//房型
        if( $site->save() )
        {
            return true;
        }else return false;
    }

    /**
     * @param $uuid
     * @param $name
     * @return bool
     * 图片上传到oss
     */
    public function toSsoImg( $uuid, $name )
    {
        $upload = new \Upload();
        return $upload->uploadProductImage( $uuid, $name, 'site_info' );
    }


    /**
     * @param $data
     * 工地详情
     */
    public function siteInfo( $data )
    {
        $sWhere['companyid'] = $data['companyid'];
        $sWhere['storeid'] = $data['storeid'];
        $sWhere['id'] = $data['id'];
        $res =  Site::where( $sWhere )->orderBy('id','desc')->with(
            [
                'siteToRenovationMode'=>function( $query ){ //装修方式
                    $query->select('id','name');
                },
                'siteToRoomType'=>function( $query ){
                    $query->select('id','name');//户型
                },
                'siteToRoomStyle'=>function( $query ){//风格
                    $query->select('id','name');
                },'siteToFolloWrecord'=>function( $query )//观光团
                {
                    $query->select('id','siteid','followuserid')->with('followToOuristparty');
                }
            ]
        )->first();
        if( $res->isdefaulttemplate )
        {
            //系统模板
            $res->tag = StageTemplateTag::orderBy('sort','asc')->where('stagetemplateid',$res->stagetemplateid)->select('stagetemplateid','id','name')->get();
        }else
        {
            //公司模板
            $res->tag = CompanyStageTemplateTag::orderBy('sort','asc')->where(['stagetemplateid'=>$res->stagetemplateid,'companyid'=>$res->companyid])->get();
        }
        //动态
       /* $comment = Dynamic::where(['companyid'=>$res->companyid,'storeid'=>$res->storeid,'sitetid'=>$res->id,'type'=>0])->with(
            [
                'dynamicToFollo'=>function( $query )
                {
                     $query->orderBy('id','desc')->select('dynamicid','content');
                },'dynamicToImages'=>function( $query )
                {
                     $query->orderBy('id','desc')->select('dynamicid','ossurl','type');
                }
        ])->paginate(config('configure.sPage'));;*/
        //$res->comment = $comment;
        return $res;
    }


    /**
     * @param $data
     * @return mixed
     * 工地详情动态
     */
    public function siteDynamic( $data )
    {
        //动态
        $comment = Dynamic::where(['companyid'=>$data['companyid'],'storeid'=>$data['storeid'],'sitetid'=>$data['id'],'type'=>0])->with(
            [
                'dynamicToFollo'=>function( $query )
                {
                    $query->orderBy('id','desc')->select('dynamicid','content');
                },'dynamicToImages'=>function( $query )
            {
                $query->orderBy('id','desc')->select('dynamicid','ossurl','type');
            }
            ])->paginate(config('configure.sPage'));
        return $comment;
    }
}