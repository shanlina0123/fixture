<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Store\Store;

class FilterBusiness extends ServerBase
{

    /**
     * @return mixed
     * 获取门店列表信息
     */
    public function getStoreList()
    {
      
      $res = Store::where()->select();
      dd($res);
      return true;
    }

    /**
     * @return mixed
     * 获取角色列表信息
     */
    public function getRoleList()
    {
        return true;
    }


}