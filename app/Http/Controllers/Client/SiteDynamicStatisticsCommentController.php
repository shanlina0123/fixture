<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 17:48
 */

namespace App\Http\Controllers\Client;

use App\Http\Business\Client\SiteDynamicStatistics;
use App\Http\Controllers\Common\ClientBaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class SiteDynamicStatisticsCommentController extends ClientBaseController
{

    public $dynamicStatistics;
    public function __construct( SiteDynamicStatistics $dynamicStatistics )
    {
        parent::__construct();
        $this->dynamicStatistics = $dynamicStatistics;
    }

    /**
     * 点赞
     */
    public function Fabulous()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,[
                'dynamicid'=>'required',
            ]
        );
        if ($validator->fails())
        {
            responseData(\StatusCode::CHECK_FORM,'验证失败');
        }
        $res = $this->dynamicStatistics->Fabulous( $data );
        if( $res )
        {
            //写日志
            event('log.notice',array('type'=>2,$this->apiUser,'event'=>$data,'notice_type'=>true));
            Cache::tags(['DynamicList'.$this->apiUser->companyid])->flush();
            responseData(\StatusCode::SUCCESS,'点赞成功');
        }
        responseData(\StatusCode::ERROR,'点赞失败');
    }
}