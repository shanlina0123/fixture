<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Business\Client\SiteDynamic;
use App\Http\Controllers\Common\ClientBaseController;
class SiteDynamiController extends ClientBaseController
{
    public $dynamic;
    public function __construct(SiteDynamic $dynamic)
    {
        parent::__construct();
        $this->dynamic = $dynamic;
    }


    /**
     * 动态列表
     */
    public function getDynamicList()
    {
        $sitetid = $this->request->input('sitetid');
        if(  $sitetid )
        {
            //有工地ID
            $where['companyid'] = $this->apiUser->companyid;
            $where['sitetid'] = $sitetid;
        }else
        {
            //没有工地id
            $where['companyid'] = $this->apiUser->companyid;
        }
        $res = $this->dynamic->DynamicList( $where, $this->request );
        responseData(\StatusCode::SUCCESS,'动态信息',$res);
    }
}