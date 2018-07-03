<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 10:23
 */

namespace App\Http\Business\Store;


use App\Http\Model\Company\CompanyParticipant;
use App\Http\Model\Data\Position;
use App\Http\Model\Site\SiteInvitation;
use App\Http\Model\User\User;
use App\Http\Model\User\UserToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ParticipantBusiness
{
    /**
     * @param $where
     * 公司成员列表
     */
    public function participantList( $where )
    {
       if(Cache::has('companyParticipant'.$where['companyid']))
       {
           $data = Cache::get('companyParticipant'.$where['companyid']);
       }else
       {
           $data = CompanyParticipant::where($where)->with('participantToPosition')->get();
           Cache::put('companyParticipant'.$where['companyid'],$data,config('configure.sCache'));
       }
       return $data;
    }

    /**
     * 职位列表
     */
    public function positionList( $where )
    {
        return Position::where($where)->get();
    }

    /**
     * @param $data
     * 添加成员
     */
    public function addParticipant( $data )
    {
        $obj = new CompanyParticipant;
        $obj->uuid = create_uuid();
        $obj->companyid = $data['companyid'];
        $obj->positionid = $data['positionid'];
        $obj->name = $data['name'];
        $obj->userid = $data['userid'];
        $obj->created_at = date('Y-m-d H:i:d');
        return $obj->save();
    }

    /**
     * 工地添加成员
     */
    public function participantToInvitation( $where )
    {
        $data = CompanyParticipant::where(['companyid'=>$where['companyid']])->with('participantToPosition')->get();
        $invitation = SiteInvitation::where(['companyid'=>$where['companyid'],'siteid'=>$where['siteid']])->pluck('participantid')->toArray();
        foreach ( $data as $row )
        {
            if(in_array($row->id,$invitation))
            {
                $row->isadd = 1;
            }else
            {
                $row->isadd = 2;
            }
        }
        return $data;
    }

    /**
     * @param $where
     * 删除工地成员
     */
    public function delParticipant( $where )
    {
        //注册成邀请的用户
        try{
            DB::beginTransaction();
            $res = SiteInvitation::where($where)->delete();
            if( $res )
            {
                $num = SiteInvitation::where(['companyid'=>$where['companyid'],'joinuserid'=>$where['joinuserid']])->count();
                if( $num == 0 )
                {
                    //没有参与的工地了只能为c端身份
                    $user = User::where(['companyid'=>$where['companyid'],'id'=>$where['joinuserid']])->first();
                    $user->isadmin = 0;
                    $user->isadminafter = 0;
                    $user->isinvitationed = 0;
                    $user->type = 1;
                    $user->save();
                    //清除用户的token
                    $uToken = UserToken::where('userid',$where['joinuserid'])->first();
                    Cache::forget($uToken->token);
                    $uToken->delete();
                }
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }catch ( Exception $e )
        {
            DB::rollBack();
            return false;
        }
    }
}