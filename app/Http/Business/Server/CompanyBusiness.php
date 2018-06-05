<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Company\Company;
use App\Http\Model\Company\CompanyStageTemplate;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Data\Position;
use App\Http\Model\Data\RenovationMode;
use App\Http\Model\Data\RoomStyle;
use App\Http\Model\Data\RoomType;
use App\Http\Model\Data\SelectDefault;
use App\Http\Model\Data\StageTemplate;
use App\Http\Model\Site\Site;
use App\Http\Model\Store\Store;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CompanyBusiness extends ServerBase
{

    /**
     * @param $data
     * 设置公司信息
     */
    public function setCompany( $data )
    {
        $obj = new \stdClass();
        $userInfo = session('userInfo');
        if( $userInfo->isadmin != 1 )
        {
            $obj->ststus = 0;
            $obj->msg = '非管理员不可操作';
            return $obj;
        }
        //根据用户信息查询
        $userInfo = session('userInfo');
        $user = User::where(['uuid'=>$userInfo->uuid])->first();
        $companyId = $user->companyid;
        if( $companyId )
        {
            try{
                $res = Company::find($companyId);
                //查询是否写入工地
                $storeID = Store::where(['companyid'=>$res->id,'isdefault'=>1])->value('id');
                $site = Site::where(['companyid'=>$res->id,'storeid'=>$storeID])->count();
                if( $data['logo'] )
                {
                    $upload = new \Upload();
                    $isImg =  $upload->uploadProductImage( $res->uuid, $data['logo'], 'user' );
                    if( $isImg == true )
                    {
                        if($res->logo)
                        {
                            $upload->delImg( $res->logo );
                        }
                        $res->logo = 'user/'.$res->uuid.'/'.$data['logo'];
                    }
                }
                if( $site )
                {
                    $obj->ststus = 1;
                    $obj->msg = '公司所在的地区已经添加了项目不能修改';

                }else
                {
                    $res->provinceid = $data['provinceid'];
                    $res->cityid = $data['cityid'];
                    $res->coucntryid = $data['coucntryid'];
                    $res->addr = $data['addr'];
                    $res->fulladdr = $data['fulladdr'];
                    $obj->ststus = 1;
                    $obj->msg = '修改成功';

                    //用户信息
                    $user->provinceid = $res->provinceid;
                    $user->cityid = $res->cityid;

                }
                $res->name = $data['name'];
                $res->phone = $data['phone'];
                $res->fullname = $data['fullname'];
                $res->resume = $data['resume'];
                if( $res->save() )
                {
                    $user->token = create_uuid();
                    $user->save();
                    Cache::put('userToken'.$user->id,['token'=>$user->token,'type'=>1],config('session.lifetime'));
                    return $obj;
                }else
                {
                    $obj->ststus = 0;
                    $obj->msg = '修改失败';
                    return $obj;
                }
            }catch(Exception $e )
            {
                $obj->ststus = 0;
                $obj->msg = '修改失败';
                return $obj;
            }
        }else
        {
            try{
                DB::beginTransaction();
                //公司信息
                $obj = new Company();
                $obj->uuid = create_uuid();
                if( $data['logo'] )
                {
                    $upload = new \Upload();
                    $isImg =  $upload->uploadProductImage( $obj->uuid, $data['logo'], 'user' );
                    if($isImg!==false)
                    {
                        $obj->logo = 'user/'.$obj->uuid.'/'.$data['logo'];
                    }
                }
                $obj->provinceid = $data['provinceid'];
                $obj->cityid = $data['cityid'];
                $obj->coucntryid = $data['coucntryid'];
                $obj->name = $data['name'];
                $obj->fullname = $data['fullname'];
                $obj->phone = $data['phone'];
                $obj->addr = $data['addr'];
                $obj->fulladdr = $data['fulladdr'];
                $obj->resume = $data['resume'];
                $obj->save();
                //添加门店
                $store = new Store();
                $store->uuid = create_uuid();
                $store->companyid = $obj->id;
                $store->provinceid = $obj->provinceid;
                $store->cityid = $obj->cityid;
                $store->name = $obj->fullname;
                $store->addr = $obj->addr;
                $store->fulladdr = $obj->fulladdr;
                $store->save();
                //修改用户表
                $user->provinceid = $obj->provinceid;
                $user->companyid = $obj->id;
                $user->storeid = $store->id;
                $user->cityid = $obj->cityid;
                $user->token = create_uuid();
                $user->save();
                //添加默认模板
                $res = StageTemplate::where(['isdefault'=>1,'status'=>1])->with('stageTemplateToTemplateTag')->first();
                if( $res )
                {
                    $template = new CompanyStageTemplate;
                    $template->uuid = create_uuid();
                    $template->companyid = $obj->id;
                    $template->name = $res->name;
                    $template->defaulttemplateid = $res->id;
                    $template->issystem = 1;
                    $template->isdefault = 1;
                    $template->created_at = date("Y-m-d H:i:s");
                    $template->save();
                    $tag = array();
                    foreach ($res->stageTemplateToTemplateTag as $k => $row) {
                        $tag[$k]['uuid'] = create_uuid();
                        $tag[$k]['companyid'] = $obj->id;
                        $tag[$k]['stagetemplateid'] = $template->id;
                        $tag[$k]['name'] = $row->name;
                        $tag[$k]['sort'] = $k;
                        $tag[$k]['created_at'] = date("Y-m-d H:i:s");
                    }
                    CompanyStageTemplateTag::insert($tag);
                }
                //添加属性信息
                $selectData = SelectDefault::where('status',1)->get();
                $roomRenov = array(); //装修方式
                $roomStyle = array(); //装修风格
                $roomType = array(); //户型
               // $position = array(); //职位
                foreach ( $selectData as $k=>$rowData )
                {
                    if( $rowData->pid != 0 )
                    {
                        switch ( (int)$rowData->pid )
                        {
                            case 1:
                                $roomRenov[$k]['name'] = $rowData->name;
                                $roomRenov[$k]['status'] = 1;
                                $roomRenov[$k]['companyid'] = $obj->id;
                                $roomRenov[$k]['created_at'] = date("Y-m-d H:i:s");
                                $roomRenov[$k]['updated_at'] = date("Y-m-d H:i:s");
                                break;
                            case 2:
                                $roomStyle[$k]['name'] = $rowData->name;
                                $roomStyle[$k]['status'] = 1;
                                $roomStyle[$k]['companyid'] = $obj->id;
                                $roomStyle[$k]['created_at'] = date("Y-m-d H:i:s");
                                $roomStyle[$k]['updated_at'] = date("Y-m-d H:i:s");
                                break;
                            case 3:
                                $roomType[$k]['name'] = $rowData->name;
                                $roomType[$k]['status'] = 1;
                                $roomType[$k]['companyid'] = $obj->id;
                                $roomType[$k]['created_at'] = date("Y-m-d H:i:s");
                                $roomType[$k]['updated_at'] = date("Y-m-d H:i:s");
                                break;
//                            case 4:
//                                $position[$k]['name'] = $rowData->name;
//                                $position[$k]['status'] = 1;
//                                $position[$k]['companyid'] = $obj->id;
//                                $position[$k]['created_at'] = date("Y-m-d H:i:s");
//                                $position[$k]['updated_at'] = date("Y-m-d H:i:s");
//                                break;
                        }
                    }
                }
                if(count($roomRenov))
                {
                    RenovationMode::insert($roomRenov);
                }
                if(count($roomStyle))
                {
                    RoomStyle::insert($roomStyle);
                }
                if(count($roomType))
                {
                    RoomType::insert($roomType);
                }
//                if(count($position))
//                {
//                    Position::insert($position);
//                }
                //清除缓存
                Cache::tags(["Data-CateList",'siteTemplate'.$obj->id,'roomType'.$obj->id,'roomStyle'.$obj->id,'renovationMode'.$obj->id])->flush();
                DB::commit();

                $obj->ststus = 1;
                $obj->msg = '修改成功';
                Cache::put('userToken'.$user->id,['token'=>$user->token,'type'=>1],config('session.lifetime'));
                return $obj;

            }catch( Exception $e )
            {
                DB::rollBack();
                $obj->ststus = 0;
                $obj->msg = '修改失败';
                return $obj;
            }
        }
    }

    /**
     * @return mixed
     * 获取公司信息
     */
    public function getCompany()
    {
        $userInfo = session('userInfo');
        $companyId = User::where(['uuid'=>$userInfo->uuid])->value('companyid');
        if( $companyId )
        {
            return Company::where('id',$companyId)->first();
        }else
        {
            return false;
        }
    }
}