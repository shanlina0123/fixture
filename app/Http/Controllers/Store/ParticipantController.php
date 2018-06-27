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


    /**
     * 工地参与者
     */
    public function siteParticipantList()
    {
        $user = $this->apiUser;
        $where['companyid'] = $user->companyid;
        $data = trimValue( $this->request->all());
        $validator = Validator::make(
            $data, [
            'storeid' => 'bail|required|numeric',//门店
            ],
            [
             'storeid.numeric' => '门店信息数据类型不正确',
            ]
        );
        $where['siteid'] = $data['siteid'];
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        //$res =

    }
}