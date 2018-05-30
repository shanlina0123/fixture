<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 15:10
 */

namespace App\Http\Controllers\Client;


use App\Http\Business\Client\SiteDynamicComment;
use App\Http\Controllers\Common\ClientBaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SiteDynamicCommentController extends ClientBaseController
{
    public $dynamicComment;
    public function __construct( SiteDynamicComment $dynamicComment )
    {
        parent::__construct();
        $this->dynamicComment = $dynamicComment;
    }

    /**
     * 删除评论
     */
    public function commentDestroy()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,[
            'dynamicid'=>'required|numeric',//动态id
            'id'=>'required|numeric',//id
            ]
        );
        if ($validator->fails())
        {
            responseData(\StatusCode::CHECK_FORM,'验证失败');
        }
        $res = $this->dynamicComment->commentDestroy($data);
        if( $res )
        {
            Cache::tags(['DynamicList'.$this->apiUser->companyid])->flush();
            responseData(\StatusCode::SUCCESS,'删除成功');
        }
        responseData(\StatusCode::ERROR,'删除失败');
    }

    /**
     * 添加评论
     */
    public function commentAdd()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,[
                'dynamicid'=>'required|numeric',//动态
                'siteid'=>'required|numeric',//工地id
                'replyuserid'=>'present',//replyuserid
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
            Cache::tags(['DynamicList'.$this->apiUser->companyid])->flush();
            responseData(\StatusCode::SUCCESS,'评论成功',$res);
        }
        responseData(\StatusCode::ERROR,'评论失败');
    }
}