<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26
 * Time: 14:54
 */

namespace App\Http\Business\Store;


use App\Http\Model\Client\Client;
use Illuminate\Support\Facades\Cache;

class ClientBusiness
{
    /**
     * 预约客户列表
     */
    public function getClientList( $where,$request )
    {
        $tag = 'clientWx'.$where['companyid'];
        $swhere = $tag.implode('',$where).$request->input('page');
        $value = Cache::tags($tag)->remember($tag.$swhere, config('configure.sCache'), function () use ($where, $request) {
            return Client::where($where)->orderBy('id', 'desc')->paginate(config('configure.sPage'));
        });
        return $value;
    }
}