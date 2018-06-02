<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use Illuminate\Support\Facades\Cache;
class PublicBusiness extends ServerBase
{
    //请求
    protected  $request;
    //session
    protected  $sessionUser;
    //redis配置
    protected  $redisTag;
    protected  $redisKey;
    protected  $redisTimeout;
    /**
     * ActivityBusiness constructor.
     * @param $request
     */
    public function  __construct($request)
    {
        $this->request = $request;
    }


}