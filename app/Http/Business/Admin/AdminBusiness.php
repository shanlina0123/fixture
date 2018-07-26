<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Admin;

use App\Http\Business\Common\AdminBase;
use App\Http\Model\Admin\User\User;
use Illuminate\Support\Facades\Cache;

class AdminBusiness extends AdminBase
{

    public function __construct()
    {
       parent::__construct();
    }

    /**
     * @param $data
     * @param $where
     * @return mixed
     * 修改密码
     */
    public function setPass( $data, $where )
    {
        return User::where($where)->update( $data );
    }
}