<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;

class FilterBusiness extends ServerBase
{

    /**
     * @return mixed
     * 获取门店列表信息
     */
    public function getStoreList()
    {
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