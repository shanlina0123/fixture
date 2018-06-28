<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 10:17
 */

namespace App\Http\Controllers\Store;


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
}