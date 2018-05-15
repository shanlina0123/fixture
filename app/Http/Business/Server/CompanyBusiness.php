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
use App\Http\Model\Site\Site;
use App\Http\Model\Store\Store;
use App\Http\Model\User\User;
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
                }
                $res->name = $data['name'];
                $res->phone = $data['phone'];
                $res->fullname = $data['fullname'];
                $res->resume = $data['resume'];
                if( $res->save() )
                {
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
                    if( $isImg === true )
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
                $store->cityid = $obj->cityid;
                $store->name = $obj->fullname;
                $store->addr = $obj->addr;
                $store->fulladdr = $obj->fulladdr;
                $store->save();
                //修改用户表
                $user->companyid = $obj->id;
                $user->storeid = $store->id;
                $user->cityid = $store->cityid;
                $user->save();
                //修改session
                $userInfo = session('userInfo');
                $userInfo->companyid = $obj->id;
                $userInfo->storeid = $store->id;
                $userInfo->cityid = $store->cityid;
                session(['userInfo'=>$userInfo]);
                DB::commit();

                $obj->ststus = 1;
                $obj->msg = '修改成功';
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