<?php

namespace App\Http\Controllers\Store;
use App\Http\Controllers\Common\StoreBaseController;
use App\Http\Model\Store\Store;

class StoreController extends StoreBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 门店列表
     */
    public function storeList()
    {
        $user = $this->apiUser;
        //判断用户信息如果是B端只显示当前店铺的动态
        if( $user->type == 0 )
        {
            if( $user->isinvitationed != 1 )
            {
                //B端用户
                switch ( (int)$user->islook )
                {
                    case 1:
                        //全部
                        break;
                    case 2:
                        //城市
                        $where['cityid'] = $user->cityid;
                        break;
                    case 3:
                        //门店
                        $where['storeid'] = $user->storeid;
                        break;
                }
            }
            $where['companyid'] = $this->apiUser->companyid;
        }else
        {
            responseData(\StatusCode::SUCCESS,'店铺信息',[]);
        }
        $res = Store::where($where)->get();
        responseData(\StatusCode::SUCCESS,'店铺信息',$res);

    }

}
