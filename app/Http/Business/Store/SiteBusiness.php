<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Store;
use App\Http\Business\Common\StoreBase;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Data\RenovationMode;
use App\Http\Model\Data\RoomStyle;
use App\Http\Model\Data\RoomType;
use App\Http\Model\Dynamic\Dynamic;
use App\Http\Model\Site\Site;
use App\Http\Model\Site\SiteInvitation;
use App\Http\Model\Site\SiteParticipant;
use Illuminate\Support\Facades\Cache;

class SiteBusiness extends StoreBase
{
    /**
     * @param $data
     * @return mixed
     * 工地列表
     */
    public function siteList( $sWhere, $data )
    {
        $tag = 'siteHome'.$sWhere['companyid'];
        $where = array_has($data,'page')?$data['page']:1;
        $where = $where.implode('',$sWhere);
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $sWhere, $data ){
            return Site::where( $sWhere )->orderBy('id','desc')->with(
                [
                 'siteToCommpanyTag'=>function( $query ){
                     $query->select('id','stagetemplateid','name');
                 }
                ]
            )->select('id','uuid','name','addr','explodedossurl','stageid','isfinish','isopen','linkednum','follownum')->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * @param $sWhere
     * @param $data
     * @return mixed
     * 搜索工地
     */
    public function searchSiteList( $sWhere, $data )
    {
        $sql =  Site::where( $sWhere )->orderBy('id','desc')->with(
            [
                'siteToCommpanyTag'=>function( $query ){
                    $query->select('id','stagetemplateid','name');
                }
            ]
        )->where('name','like',"%{$data['name']}%")->select('id','uuid','name','addr','explodedossurl','stageid','isfinish','isopen','linkednum','follownum');
        return $sql->paginate(config('configure.sPage'));
    }

    /**
     * 工地是否公开
     */
    public function siteIsOpen( $data )
    {
        $sWhere['companyid'] = $data['companyid'];
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
        $sWhere['id'] = $data['id'];
        $res = Site::where($sWhere)->first();
        if( $res )
        {
            $res->store = $res->siteToStore?$res->siteToStore->name:'';//关联店铺
            //公司模板阶段
            $res->tagName = $res->siteToCommpanyTag?$res->siteToCommpanyTag->name:'';
            //模板
            $res->tag = CompanyStageTemplateTag::where(['stagetemplateid'=>$res->stagetemplateid,'companyid'=>$res->companyid])->get();
            $res->roomStyle = $this->getRoomStyle( $data['companyid'] ); //装修风格
            $res->renovationMode = $this->getRenovationMode( $data['companyid'] );//装修方式
            $res->roomType = $this->getRoomType( $data['companyid'] ); //户型
            return $res;

        }else
        {
            responseData(\StatusCode::ERROR,'工地信息不存在',$res);
        }
    }


    /**
     * 户型
     */
    public function getRoomType( $companyId )
    {
        if( Cache::get('roomType'.$companyId) )
        {
            $roomType = Cache::get('roomType'.$companyId);
        }else
        {
            $roomType = RoomType::where(['status'=>1,'companyid'=>$companyId])->select('id','name')->get();
            Cache::put('roomType'.$companyId,$roomType,config('configure.sCache'));
        }
        return $roomType;
    }

    /**
     * 装修风格
     */
    public function getRoomStyle( $companyId )
    {
        if( Cache::get('roomStyle'.$companyId) )
        {
            $roomStyle = Cache::get('roomStyle'.$companyId);
        }else
        {
            $roomStyle = RoomStyle::where(['status'=>1,'companyid'=>$companyId])->select('id','name')->get();
            Cache::put('roomStyle'.$companyId,$roomStyle,config('configure.sCache'));
        }
        return $roomStyle;
    }

    /**
     * @return mixed
     *
     */
    public function getRenovationMode( $companyId )
    {
        if( Cache::get('renovationMode'.$companyId) )
        {
            $renovationMode = Cache::get('renovationMode'.$companyId);
        }else
        {
            $renovationMode = RenovationMode::where(['status'=>1,'companyid'=>$companyId])->select('id','name')->get();
            Cache::put('renovationMode'.$companyId,$renovationMode,config('configure.sCache'));
        }
        return $renovationMode;
    }


    /**
     * @param $data
     * 工地详情
     */
    public function siteInfo( $data )
    {
        $sWhere['companyid'] = $data['companyid'];
        $sWhere['id'] = $data['id'];
        if( $data['userType'] == 1 )
        {
            //不公开只针对C端
            $sWhere['isopen'] = 1;
        }
        $res = Site::where( $sWhere )->orderBy('id','desc')->with(
            [
                'siteToRenovationMode'=>function( $query ){ //装修方式
                    $query->select('id','name');
                },
                'siteToRoomStyle'=>function( $query ){//风格
                    $query->select('id','name');
                },'siteToFolloWrecord'=>function( $query )//观光团
                {
                    $query->select('id','siteid','userid')->with(['followToUser'=>function( $query ){
                        $query->select('faceimg','id')->orderBy('id','desc')->take(8);
                    }]);
                }
            ]
        )->select('explodedossurl','addr','budget','acreage','roomtypeid','roomstyleid','renovationmodeid','stagetemplateid','companyid','id','roomshap','stageid','name','storeid','cityid','linkednum','follownum','uuid')->first();
        if( !$res )
        {
            responseData(\StatusCode::ERROR,'工地未公开');
        }else
        {
            //如果工地存在就加浏览量
            event('site.statistics',array( $res,'event'=>'linkednum'));
        }
        //公司模板
        $res->tag = CompanyStageTemplateTag::orderBy('sort','asc')->where(['stagetemplateid'=>$res->stagetemplateid,'companyid'=>$res->companyid])->select('id','name')->get();
        //工地参与者
        $res->siteInvitation = SiteInvitation::where(['companyid'=>$data['companyid'],'siteid'=>$data['id']])->with(['invitationToUser'=>function($query){
            $query->select('id','positionid','nickname','faceimg')->with('userToPosition');
        }])->get();
        //自己关注统计
        $res->siteToFolloWrecord = $res->siteToFolloWrecord()->where('userid',$data['userid'])->count();
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
        $where = $data;
        $comment = Dynamic::where(['companyid'=>$data['companyid'],'sitetid'=>$data['id'],'type'=>0])->orderBy('id','desc')->with('dynamicToImages');//关联图片
        //关联用户
        $comment = $comment->with(['dynamicToUser'=>function( $query ) use($where){
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
        }])->get();
        return $comment;
    }
}