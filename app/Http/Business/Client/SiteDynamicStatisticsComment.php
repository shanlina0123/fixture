<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 15:17
 */

namespace App\Http\Business\Client;
use App\Http\Business\Common\ClientBase;
class SiteDynamicStatistics extends ClientBase
{

    /**
     * 点赞
     */
    public function Fabulous()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,[
                'dynamicid'=>'required|numeric',//动态
                'siteid'=>'required|numeric',//工地id
                'pid'=>'present',//pid
                'content'=>'required',//地址
            ]
        );
        $data['createuserid'] = $this->apiUser->id;
        if ($validator->fails())
        {
            responseData(\StatusCode::CHECK_FORM,'验证失败');
        }
        $res = $this->dynamicComment->commentAdd($data);
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,'评论成功');
        }
        responseData(\StatusCode::ERROR,'评论失败');
    }
}