<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Model\Company\CompanyStageTemplate;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Data\RenovationMode;
use App\Http\Model\Data\RoomStyle;
use App\Http\Model\Data\RoomType;
use App\Http\Model\Data\StageTemplate;
use App\Http\Model\Dynamic\Dynamic;
use App\Http\Model\Dynamic\DynamicComment;
use App\Http\Model\Dynamic\DynamicImages;
use App\Http\Model\Dynamic\DynamicStatistics;
use App\Http\Model\Site\Site;
use App\Http\Model\Site\SiteFollowrecord;
use App\Http\Model\Site\SiteInvitation;
use App\Http\Model\Site\SiteStageschedule;
use App\Http\Model\Store\Store;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteBusiness extends ServerBase
{

    /**
     * @param $data
     * 工地列表
     */
    public function getSiteList( $where, $user )
    {
        $tag = 'site'.$user->companyid;
        $tags = $user->roleid.$where['page'].$where['name'].$where['isopen'].$where['storeid'];
        $tags = base64_encode($tags);
        $value = Cache::tags($tag)->remember( $tags,config('configure.sCache'), function() use( $user,$where ){
            //网站管理员
            if( $user->isadmin == 1 )
            {
                $sWhere['companyid'] =  $user->companyid;
            }else
            {
                //检测权限
                if( !empty($user->islook) )
                {
                    //存在
                    switch ( (int)$user->islook )
                    {
                        case 1://全部
                            $sWhere['companyid'] =  $user->companyid;
                            break;
                        case 2://城市
                            $sWhere['companyid'] =  $user->companyid;
                            $sWhere['cityid'] =  $user->cityid;
                            break;
                        case 3://门店
                            $sWhere['companyid'] =  $user->companyid;
                            $sWhere['storeid'] =  $user->storeid;
                            break;
                        default://默认
                            $sWhere['companyid'] =  $user->companyid;
                            $sWhere['storeid'] =  $user->storeid;
                            break;
                    }
                }else
                {
                    //不存在
                    $sWhere['companyid'] =  $user->companyid;
                    $sWhere['storeid'] =  $user->storeid;
                }
            }
            //展示状态
            if( $where['isopen'] != '' )
            {
                $sWhere['isopen'] = $where['isopen'];
            }
            $sql = Site::where( $sWhere )->orderBy('id','desc')->with('siteToStore','siteToDataTag','siteToCommpanyTag');
            //名称搜索
            if( $where['name'] )
            {
                $sql->where('name','like',"%{$where['name']}%");
            }
            //店铺
            if( $where['storeid'] )
            {
                $sql->where('storeid',$where['storeid']);
            }
            return $sql->paginate(config('configure.sPage'));
        });
        return $value;
    }

    /**
     * 添加工地获取门店信息
     */
    public function getStore( $user )
    {
        //总管理员
        if( $user->isadmin == 1 )
        {
            //查询门店
            if( Cache::get('storeCompany'.$user->companyid) )
            {
                $store =  Cache::get('storeCompany'.$user->companyid);
            }else
            {
                $store = Store::where('companyid',$user->companyid)->get();
                Cache::put('storeCompany'.$user->companyid,$store,config('configure.sCache'));
            }
            return $store;
        }else
        {
            if( Cache::get('store'.$user->storeid) )
            {
                $store =  Cache::get('store'.$user->storeid);
            }else
            {
                //检测权限
                if( !empty($user->islook) )
                {
                    //存在
                    switch ( (int)$user->islook )
                    {
                        case 1://全部
                            $sWhere['companyid'] =  $user->companyid;
                            break;
                        case 2://城市
                            $sWhere['companyid'] =  $user->companyid;
                            $sWhere['cityid'] =  $user->cityid;
                            break;
                        case 3://门店
                            $sWhere['companyid'] =  $user->companyid;
                            $sWhere['id'] =  $user->storeid;
                            break;
                        default://默认
                            $sWhere['companyid'] =  $user->companyid;
                            $sWhere['id'] =  $user->storeid;
                            break;
                    }
                }else
                {
                    //不存在
                    $sWhere['companyid'] =  $user->companyid;
                    $sWhere['id'] =  $user->storeid;
                }
                $store = Store::where($sWhere)->get();
                Cache::put('store'.$user->storeid,$store,config('configure.sCache'));
            }
            return $store;
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
     * 系统模板
     */
    public function getStageTemplate()
    {
        if( Cache::get('stagetemplate') )
        {
            $stage = Cache::get('stagetemplate');
        }else
        {
            $stage = StageTemplate::where('status',1)->select('id','name')->get();
            Cache::put('stagetemplate',$stage,config('configure.sCache'));
        }
        return $stage;
    }

    /**
     * 公司定义模板
     */
    public function getCompanyStageTemplate( $user )
    {
        $companyID = $user->companyid;
        if( Cache::get('companystagetemplate'.$companyID) )
        {
            $stageTemplate = Cache::get('companystagetemplate'.$companyID);
        }else
        {
            $stageTemplate = CompanyStageTemplate::where(['companyid'=>$companyID,'status'=>1])->select('id','name')->get();
            Cache::put('companystagetemplate'.$companyID,$stageTemplate,config('configure.sCache'));
        }
        return $stageTemplate;
    }



    /**
     * @param $data
     * @return bool
     * 添加工地
     */
    public function siteSave( $data )
    {
        try{

            DB::beginTransaction();
            //添加工地
            $uuid = create_uuid();
            $site = new Site();
            if( $data['photo'] )
            {
                $res = $this->toSsoImg($uuid,$data['photo']);
                if( $res == true )
                {
                    $site->explodedossurl = 'site/'.$uuid.'/info/'.$data['photo'];
                }
            }

            //检测门店
            if($data['storeid'])
            {
                $data['cityid']=Store::where("id",$data['storeid'])->value("cityid");
            }

            $site->uuid = $uuid;
            $site->companyid = $data['companyid'];
            $site->storeid = $data['storeid'];
            $site->cityid = $data['cityid'];
            $site->stageid = $data['stageid'];
            $site->stagetemplateid = $data['stagetemplateid'];
            $site->roomtypeid = $data['roomtypeid'];
            $site->roomstyleid = $data['roomstyleid'];
            $site->renovationmodeid = $data['renovationmodeid'];
            $site->budget = $data['budget'];
            $site->name = $data['name'];
            $site->addr = $data['addr'];
            $site->lng = $data['lng'];
            $site->lat = $data['lat'];
            $site->doornumber = $data['doornumber'];
            $site->acreage = $data['acreage'];
            $site->roomshap = $data['room'].'室'.$data['office'].'厅'.$data['kitchen'].'厨'.$data['wei'].'卫';
            $site->isopen =  array_has($data,'isopen')?1:0;
            $site->isfinish = 0;
            $site->createuserid = $data['createuserid'];
            $site->save();
            //添加动态
            $dynamic = new Dynamic();
            $dynamic->uuid = create_uuid();
            $dynamic->companyid = $data['companyid'];
            $dynamic->storeid = $data['storeid'];
            $dynamic->sitetid = $site->id;
            $dynamic->createuserid = $data['createuserid'];
            $dynamic->content = str_replace('【工地名称】',$data['name'],config('template.13'));
            $dynamic->title = $data['name'];
            $dynamic->sitestagename = $data['sitestagename'];
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
            $progress->stageuserid = $data['createuserid'];
            $progress->positionid = $data['createuserid'];
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
     * 获取模板进度内容
     */
    public function getTemplateTag( $tid, $user )
    {
        $companyid = $user->companyid;
        //公司模板
        $data = CompanyStageTemplateTag::where(['stagetemplateid'=>$tid,'status'=>1,'companyid'=>$companyid])->get();
        return $data;
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
     * @param $uuid
     * @param $companyId
     * @return mixed
     * 工地信息
     */
    public function editSite( $uuid, $companyId )
    {
        $res = Site::where(['uuid'=>$uuid,'companyid'=>$companyId])->first();
        $res->tage = CompanyStageTemplateTag::where(['stagetemplateid'=>$res->stagetemplateid,'status'=>1,'companyid'=>$companyId])->get();
        return $res;
    }

    /**
     * @param $data
     * @param $id
     * 修改工地
     */
    public function siteUpdate( $data, $id )
    {

        $obj = new \stdClass();
        $site = Site::where(['uuid'=>$id,'companyid'=>$data['companyid']])->first();
        if( $site == false )
        {
            $obj->status = 0;
            $obj->msg = '未查询到信息';
            return $obj;
        }
        if( $site->isfinish == 1 )
        {
            $obj->status = 0;
            $obj->msg = '已完工不能修改';
            return $obj;
        }
        if( $data['photo'] )
        {
            $res = $this->toSsoImg($id,$data['photo']);
            if( $res == true )
            {
                if( $site->explodedossurl )
                {
                    //删除原始图片
                    (new \Upload())->delImg($site->explodedossurl);
                }
                $site->explodedossurl = 'site/'.$id.'/info/'.$data['photo'];
            }
        }
        $site->stageid = $data['stageid'];
        $site->roomtypeid = $data['roomtypeid'];
        $site->roomstyleid = $data['roomstyleid'];
        $site->renovationmodeid = $data['renovationmodeid'];
        $site->budget = $data['budget'];
        $site->name = $data['name'];
        $site->addr = $data['addr'];
        $site->lng = $data['lng'];
        $site->lat = $data['lat'];
        $site->doornumber = $data['doornumber'];
        $site->acreage = $data['acreage'];
        $site->roomshap = $data['room'].'室'.$data['office'].'厅'.$data['kitchen'].'厨'.$data['wei'].'卫';
        $site->isopen =  array_has($data,'isopen')?1:0;
        $site->isfinish = 0;
        if( $site->save() )
        {
            $obj->status = 1;
            $obj->msg = '修改成功';
            return $obj;
        }else
        {
            $obj->status = 0;
            $obj->msg = '修改失败';
            return $obj;
        }
    }


    /**
     * @param $companyId
     * @param $id
     * @return bool
     * 删除工地
     */
    public function siteDel( $companyId, $id )
    {

        try{
            DB::beginTransaction();
            //删除工地
            $site = Site::where(['companyid'=>$companyId,'uuid'=>$id])->first();
            if( $site == false )
            {
                return false;
            }

            //删除工地动态
            $dynamic = Dynamic::where(['companyid'=>$site->companyid,'sitetid'=>$site->id])->first();
            if( $dynamic )
            {
                //删除统计
                DynamicStatistics::where(['siteid'=>$site->id,'dynamicid'=>$dynamic->id])->delete();
                //删除评论
                DynamicComment::where(['siteid'=>$site->id,'dynamicid'=>$dynamic->id])->delete();
                //删除动态图片
                DynamicImages::where(['dynamicid'=>$dynamic->id])->delete();
                (new \Upload())->delDir('site', $site->uuid);
                $dynamic->delete();
            }
            //删除工地参与者
            SiteInvitation::where('siteid',$site->id)->delete();
            //删除工地阶段记录
            SiteStageschedule::where('siteid',$site->id)->delete();
            //删除观光团关注的工地
            SiteFollowrecord::where('siteid',$site->id)->delete();
            //删除工地
            $site->delete();
            DB::commit();
            return true;
        }catch ( Exception $e )
        {
            DB::rollBack();
            return false;
        }
    }


    /**
     * @param $companyId
     * @param $uuid
     * @return bool|\stdClass
     * 更新工地进度
     */
    public function getSiteRenew( $companyId, $uuid )
    {
        $obj = new \stdClass();
        $site = Site::where(['companyid'=>$companyId,'uuid'=>$uuid])->select('stagetemplateid','stageid','name','isfinish')->first();
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
            $obj->uuid = $uuid;
            $obj->companyid = $companyId;
            $obj->time = date("Y-m-d H:i:s");
            $obj->name = $site->name;
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
     * @param $data
     * @param $companyId
     * @param $uuid
     * @return bool
     * 保存更新
     */
    public function saveSiteRenew( $data, $uuid  )
    {
        try{
            $obj = new \stdClass();
            DB::beginTransaction();
            $site = Site::where(['companyid'=>$data['companyid'],'uuid'=>$uuid])->first();
            //添加动态
            $dynamic = new Dynamic();
            $dynamic->uuid = create_uuid();
//            $dynamic->companyid = $data['companyid'];
//            $dynamic->storeid = $data['storeid'];
            $dynamic->sitetid = $site->id;
            $dynamic->createuserid = $data['createuserid'];
            $dynamic->content = $data['content'];
            $dynamic->title = $data['title'];
            $dynamic->sitestagename = $data['sitestagename'];
            $dynamic->type = 0;
            $dynamic->status = 1;
            $dynamic->created_at = date("Y-m-d H:i:s");
            $dynamic->save();
            //添加阶段动态
            $site_tag = new SiteStageschedule();
            $site_tag->uuid = create_uuid();
            $site_tag->dynamicid = $dynamic->id;
            $site_tag->siteid = $site->id;
            $site_tag->stagetagid = $data['stagetagid'];
            $site_tag->stageuserid = $data['createuserid'];
            $site_tag->created_at = date("Y-m-d H:i:s");
            $site_tag->save();
            //添加图片
            if( $data['img'] )
            {
                $upload = new \Upload();
                $arr = explode(',',$data['img']);
                foreach ( $arr as $k=>$row )
                {
                    $res =  $upload->uploadProductImage( $site->uuid, $row, 'site_dynamic' );
                    $img = array();
                    if( $res )
                    {
                        //写入数据库
                        $img[$k]['dynamicid'] = $dynamic->id;
                        $img[$k]['ossurl'] = 'site/'.$site->uuid.'/dynamic/'.$row;
                        $img[$k]['type'] = 0;
                        $img[$k]['created_at'] = date("Y-m-d H:i:s");
                    }
                    if( count($img) )
                    {
                        DynamicImages::insert( $img );
                    }
                }
            }
            //更新主表
            $site->stageid = $data['stagetagid'];
            $site->save();
            DB::commit();
            $obj->status = 1;
            $obj->msg = '更新成功';
            return $obj;
        }catch ( Exception $e )
        {
            DB::rollBack();
            $obj->status = 0;
            $obj->msg = '更新失败';
            return $obj;
        }
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
    /***
     * 获取扩展详情
     * @return mixed
     */
    public function extension($uuid, $companyid)
    {
        //获取小程序二维码
        $wx = new  WxAuthorize();
        $accessToken = $wx->getUserAccessToken(null, $companyid);
        $wxcode = $accessToken ? $wx->getWxappCode($accessToken, $uuid,"sitepage") : "";
        $list["wxappcode"] = $wxcode;
        $list["uuid"] = $uuid;
        return responseCData(\StatusCode::SUCCESS, "", $list);
    }
}