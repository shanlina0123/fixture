<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 10:17
 */

namespace App\Http\Controllers\Store;


use App\Http\Business\Common\WxAlone;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Business\Store\ParticipantBusiness;
use App\Http\Controllers\Common\StoreBaseController;

class ParticipantController extends StoreBaseController
{

    public $participant;
    public function __construct( ParticipantBusiness $participant )
    {
        parent::__construct();
        $this->participant = $participant;

    }

    /**
     * 参与者列表
     */
    public function participantList()
    {
        $user = $this->apiUser;
        $where['companyid'] = $user->companyid;
        $res = $this->participant->participantList( $where );
        responseData(\StatusCode::SUCCESS,'参与者列表',$res);
    }

    /**
     * 职位
     */
    public function  positionList()
    {
        $where['status'] = 1;
        $where['companyid'] = $this->apiUser->companyid;
        $res = $this->participant->positionList( $where );
        responseData(\StatusCode::SUCCESS,'职位列表',$res);
    }

    /**
     * 二维码
     */
    public function code()
    {
        //1单独部署
        if( config('wxtype.type') == 1 )
        {
            $wx = new WxAlone();
        }else
        {
            $wx = new WxAuthorize();
        }
        $companyid = $this->request->input('companyid');
        $uid = $this->request->input('uid');
        $positionid = $this->request->input('positionid');
        $type = 'allow';
        $scene = http_build_query(['uid'=>$uid,'positionid'=>$positionid,'type'=>1]);
        $wx->createWxappCode($companyid,$type, $scene,'400');
    }
}