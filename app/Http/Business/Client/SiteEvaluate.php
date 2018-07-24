<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/21
 * Time: 14:45
 */

namespace App\Http\Business\Client;


use App\Http\Business\Common\ClientBase;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Site\SiteEvaluate as Evaluate;
use App\Http\Model\Site\Site;
use App\Http\Model\Site\SiteInvitation;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\DB;

class SiteEvaluate extends ClientBase
{
    /**
     * @param $siteid
     * @param $user
     *  业主评价
     */
    public function ownerEvaluate( $data, $user )
    {
        try{
            DB::beginTransaction();
            $site = Site::where(['companyid'=>$user->companyid,'id'=>$data['siteid']])->first();
            if( !$site )
            {
                responseData(\StatusCode::ERROR,'未查询到评价的项目信息');
            }
            $where['companyid'] = $user->companyid;
            $where['siteid'] = $data['siteid'];
            $userID = Evaluate::where($where)->value('userid');
            if( $userID && $userID != $user->id )
            {
                responseData(\StatusCode::ERROR,'您不是业主不能参与业主评价');
            }
            if( !$userID )
            {
                //第一次评价给邀请的成员表加数据
                $invitation['companyid'] = $user->companyid;
                $invitation['storeid'] = $site->storeid;
                $invitation['cityid'] = $site->cityid;
                $invitation['siteid'] = $site->id;
                $invitation['participantid'] = 0;
                $invitation['isowner'] = 1;
                $invitation['userid'] = $site->createuserid;//工地创建者
                $invitation['joinuserid'] = $user->id;
                $inv = SiteInvitation::firstOrCreate( $invitation );
                $inv->uuid = create_uuid();
                $inv->created_at = date("Y-m-d H:i:s");
                $inv->save();
                //设置用户为业主
                User::where(['companyid'=>$user->companyid,'id'=>$user->id])->update(['isowner'=>1]);
            }
            $evaluate = new Evaluate();
            $evaluate->companyid = $user->companyid;
            $evaluate->siteid = $data['siteid'];
            $evaluate->userid = $user->id;
            $evaluate->sitestageid = $data['sitestageid'];
            $evaluate->sitestagename = $data['sitestagename'];
            $evaluate->score = $data['score'];
            $evaluate->content = $data['content'];
            $evaluate->save();
            DB::commit();
            return true;
        }catch (\Exception $e)
        {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 评价信息
     */
    public function evaluateInfo( $data, $user )
    {
        $where['companyid'] = $user->companyid;
        $where['id'] = $data['id'];
        $res = Site::where($where)->first();
        if( !$res )
        {
            responseData(\StatusCode::ERROR,'未查询到评价的项目信息');
        }

        $obj = new \stdClass();
        $obj->name = $res->name;
        $obj->stageid = $res->stageid; //最新阶段
        $obj->template = CompanyStageTemplateTag::where(['companyid'=>$user->companyid,'stagetemplateid'=>$res->stagetemplateid])->orderBy('id','asc')->get()->toArray();
        return $obj;
    }

    /**
     * 评价信息
     */
    public function evaluateDestroy( $data, $user )
    {
        return Evaluate::where(['siteid'=>$data['siteid'],'companyid'=>$user->companyid])->delete();
    }
}