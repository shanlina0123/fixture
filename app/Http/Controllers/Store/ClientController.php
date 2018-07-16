<?php

namespace App\Http\Controllers\Store;

use App\Http\Business\Store\ClientBusiness;
use App\Http\Controllers\Common\StoreBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClientController extends StoreBaseController
{

    protected $client;
    public function __construct( ClientBusiness $client )
    {
        parent::__construct();
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientList()
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
                        $where['storeid'] = $user->cityid;
                        break;
                    case 3:
                        //门店
                        $where['storeid'] = $user->storeid;
                        break;
                }
            }else
            {
                $where['storeid'] = $user->storeid;
            }
            $where['companyid'] = $this->apiUser->companyid;
            $where['sourcecateid'] = 1;
        }else
        {
            responseData(\StatusCode::SUCCESS,'客户信息',[]);
        }
        $res = $this->client->getClientList( $where,$this->request );
        responseData(\StatusCode::SUCCESS,'客户信息',$res);

    }
}
