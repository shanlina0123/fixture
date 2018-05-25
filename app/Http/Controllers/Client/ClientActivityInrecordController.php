<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Business\Client\ClientActivityInrecord;
use App\Http\Controllers\Common\ClientBaseController;
class ClientActivityInrecordController extends ClientBaseController
{
    public $clientActivityInrecord;
    public function __construct(ClientActivityInrecord $clientActivityInrecord)
    {
        parent::__construct();
        $this->clientActivityInrecord = $clientActivityInrecord;
    }


    /**
     * 活动列表
     */
    public function activityInrecord()
    {
        $userID = $this->apiUser->id;
        $res = $this->clientActivityInrecord->activityInrecord( $userID, $this->request );
        responseData(\StatusCode::SUCCESS,'活动信息',$res);
    }


    /**
     *  活动详情
     */
    public function activityInfo( $uuid )
    {
        $companyID = $this->apiUser->companyid;
        $res = $this->clientActivityInrecord->activityInfo( $companyID, $uuid );
        responseData(\StatusCode::SUCCESS,'活动详情',$res);
    }
}