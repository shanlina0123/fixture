<?php

namespace App\Http\Controllers\Store;
use App\Http\Controllers\Common\StoreBaseController;
use App\Http\Model\Store;
use Illuminate\Http\Request;
class StoreController extends StoreBaseController
{
    protected $request;
    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    /**
     * 门店列表
     */
    public function storeList()
    {
        $data = trimValue( $this->request->all() );
        if(  $data['isadmin'] == 2 )
        {
            $where['companyid'] = $data['companyid'];
        }else
        {
            $where['companyid'] = $data['companyid'];
            $where['storeid'] = $data['storeid'];
        }
        $res = Store::where($where)->get();
        responseData(\StatusCode::SUCCESS,'店铺信息',$res);
    }

}
