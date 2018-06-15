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
        $user = $this->apiUser;
        //判断用户信息如果是B端只显示当前店铺的动态
        if( $user->type == 0 )
        {
            //B端用户
            //根据权限显示
            $where['storeid'] = $this->apiUser->storeid;

        }else
        {
            //C端用户
            if(  $sitetid )
            {
                //有工地ID
                $where['companyid'] = $this->apiUser->companyid;
            }
        }
        $where['companyid'] = $this->apiUser->companyid;
        $res = $this->dynamic->DynamicList( $where, $this->request );
        responseData(\StatusCode::SUCCESS,'动态信息',$res);
    }

    /**
     * 删除动态
     */
    public function destroyDynamic()
    {

    }
}