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
        $data = trimValue( $this->request->all() );

        if(  $data['isadmin'] == 1 )
        {
            $where['companyid'] = $this->apiUser->companyid;
        }else
        {
            $where['companyid'] = $this->apiUser->companyid;
            $where['storeid'] = $this->apiUser->storeid;
        }
        $res = Store::where($where)->get();
        responseData(\StatusCode::SUCCESS,'店铺信息',$res);
    }

}
