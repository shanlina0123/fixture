<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MessageBusiness extends ServerBase
{
    /***
     * 获取列表
     * @return mixed
     */
    public function index()
    {
        return null;
    }

    public function setSmallProgram( $data )
    {
        $res = SmallProgram::where(['companyid'=>$data['companyid']])->first();
        if( !$res )
        {
            $res = new SmallProgram();
            $res->companyid = $data['companyid'];
            $res->token = str_random(32);
            $res->EncodingAESKey = str_random(43);
            $res->type = 1;
            $res->save();
            return SmallProgram::where(['companyid'=>$data['companyid']])->first();
        }else
        {
            $res->companyid = $data['companyid'];
            $res->token = str_random(32);
            $res->EncodingAESKey = str_random(43);
            $res->type = 1;
            $res->save();
            return $res;
        }

    }
}