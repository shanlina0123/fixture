<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;


use App\Http\Business\Client\ClientActivityLuckyRecord;
use App\Http\Controllers\Common\ClientBaseController;
class ClientActivityLuckyRecordController extends ClientBaseController
{
    public $activityLuckyRecord;
    public function __construct(ClientActivityLuckyRecord $activityLuckyRecord)
    {
        parent::__construct();
        $this->activityLuckyRecord = $activityLuckyRecord;
    }


    /**
     * 中奖列表
     */
    public function luckyRecordList()
    {
        $userID = $this->apiUser->id;
        $res = $this->activityLuckyRecord->LuckyRecord( $userID, $this->request );
        responseData(\StatusCode::SUCCESS,'中奖列表',$res);
    }
}