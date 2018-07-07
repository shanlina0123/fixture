<?php

namespace App\Http\Controllers\Store;
use App\Http\Controllers\Common\StoreBaseController;
use App\Http\Model\Site\SiteInvitation;
use App\Http\Model\Store\Store;
use App\Http\Model\User\User;

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


    /**
     * 参与者切换店铺列表
     */
    public function invitationStoreList()
    {
        $user = $this->apiUser;
        $storeId = SiteInvitation::where(['companyid'=>$user->companyid,'joinuserid'=>$user->id])->pluck('storeid')->toArray();
        $res = Store::where('companyid',$user->companyid)->whereIn('id',$storeId)->get();
        responseData(\StatusCode::SUCCESS,'店铺信息',$res);
    }

    /**
     * 邀请用户切换门店
     */
    public function invitationStoreUp()
    {
        $user = $this->apiUser;
        $storeId = $this->request->input('storeid');
        $res = User::where(['companyid'=>$user->companyid,'id'=>$user->id])->first();
        if( $res )
        {
            if( $res->type == 0 && $res->isinvitationed != 1 )
            {
                $res->storeid = $storeId;
                if( $res->save() )
                {
                    $apiUser = $this->request->get('apiUser');
                    $apiUser->tokenToUser->storeid=$storeId;
                    $this->request->attributes->add(['apiUser'=>$apiUser]);
                    responseData(\StatusCode::SUCCESS,'切换成功',$storeId);
                }
            }
        }
        responseData(\StatusCode::ERROR,'切换失败');
    }
}
