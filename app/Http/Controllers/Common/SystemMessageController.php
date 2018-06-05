<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 14:24
 */

namespace App\Http\Controllers\Common;

use App\Http\Business\Common\SystemMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class SystemMessageController extends Controller
{

    public $systemMessage;
    public $request;
    public $apiUser;
    public function __construct(SystemMessage $systemMessage, Request $request)
    {
        $this->request = $request;
        $this->systemMessage = $systemMessage;
        $this->middleware(function ($request, $next) {
            $apiUser = $request->get('apiUser');
            $this->apiUser = $apiUser?$apiUser->tokenToUser:'';
            return $next( $request );
        });
    }


    /*
     * 消息列表
     */
    public function notice()
    {
        $data = trimValue($this->request->all());
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
            'userid'=>'required',
            ],[
            'userid.required'=>'用户信息不存在',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $res = $this->systemMessage->getNoticeList( $data );
        responseData(\StatusCode::SUCCESS,'通知信息',$res);
    }

    /**
     * 读取消息
     */
    public function readNotice()
    {
        $data = trimValue($this->request->all());
        $data['userid'] = $this->apiUser->id;
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,[
                'userid'=>'required',
                'id'=>'sometimes|required'
            ],[
              'userid.required'=>'用户信息不存在',
              'id.required'=>'消息ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->systemMessage->readNotice( $data );
        if ($res)
        {
            Cache::tags(['NoticeList'.$data['userid']])->flush();
            responseData(\StatusCode::SUCCESS,'读取成功');
        }
        responseData(\StatusCode::ERROR,'读取失败');

    }
}