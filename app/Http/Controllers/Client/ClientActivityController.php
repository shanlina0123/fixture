<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Business\Client\ClientActivity;
use App\Http\Controllers\Common\ClientBaseController;
class ClientActivityController extends ClientBaseController
{
    public $clientActivity;
    public function __construct(ClientActivity $clientActivity)
    {
        parent::__construct();
        $this->clientActivity = $clientActivity;
    }


    /**
     * 活动列表
     */
    public function activityList()
    {
        $res = $this->clientActivity->activityList( $this->apiUser, $this->request );
        responseData(\StatusCode::SUCCESS,'活动信息',$res);
    }


    /**
     *  活动详情
     */
    public function activityInfo()
    {
        $companyID = $this->apiUser->companyid;
        $id = $this->request->input('id');
        $res = $this->clientActivity->activityInfo( $companyID, $id );
        responseData(\StatusCode::SUCCESS,'活动详情',$res);
    }
}