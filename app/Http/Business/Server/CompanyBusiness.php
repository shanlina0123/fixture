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
        $userInfo = session('userInfo');
        if( $userInfo->isadmin != 2 )
        {
            return false;
        }
        //根据用户信息查询
        $userInfo = session('userInfo');
        $user = User::where(['uuid'=>$userInfo->uuid])->first();
        $companyId = $user->companyid;
        if( $companyId )
        {
            try{
                $res = Company::find($companyId);
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
                $res->provinceid = $data['provinceid'];
                $res->cityid = $data['cityid'];
                $res->coucntryid = $data['coucntryid'];
                $res->name = $data['name'];
                $res->fullname = $data['fullname'];
                $res->contacts = $data['contacts'];
                $res->addr = $data['addr'];
                $res->fulladdr = $data['fulladdr'];
                $res->resume = $data['resume'];

                if( $res->save() )
                {
                    return true;

                }else
                {
                    return false;
                }
            }catch(Exception $e )
            {
                return false;
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
                $obj->contacts = $data['contacts'];
                $obj->addr = $data['addr'];
                $obj->fulladdr = $data['fulladdr'];
                $obj->resume = $data['resume'];
                $obj->clientappid = $data['clientappid'];
                $obj->save();
                //修改用户表
                $user->companyid = $obj->id;
                $user->save();
                //修改session
                $userInfo = session('userInfo');
                $userInfo->companyid = $obj->id;
                session(['userInfo'=>$userInfo]);
                DB::commit();
                return true;

            }catch( Exception $e )
            {
                //修改session
                $userInfo = session('userInfo');
                $userInfo->companyid = null;
                session(['userInfo'=>$userInfo]);
                DB::rollBack();
                return false;
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