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
                'dynamicid'=>'required|numeric',//公司
                'siteid'=>'required|numeric',//门店
            ]
        );
        if ($validator->fails())
        {
            responseData(\StatusCode::CHECK_FORM,'验证失败');
        }
        $res = $this->dynamicStatistics->Fabulous( $data );
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,'点赞成功');
        }
        responseData(\StatusCode::ERROR,'点赞失败');
    }
}