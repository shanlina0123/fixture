<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/6
 * Time: 18:52
 */

namespace App\Http\Controllers\Common;


use App\Http\Business\Common\Lucky;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class LuckyController extends Controller
{

    public $apiUser;
    public $request;
    public $lucky;
    public function __construct( Lucky $lucky)
    {
        $this->middleware(function ($request, $next) {
            $this->request = $request;
            $apiUser = $request->get('apiUser');
            $this->apiUser = $apiUser?$apiUser->tokenToUser:'';
            return $next( $request );
        });
        $this->lucky = $lucky;
    }

    /**
     * 奖品详情
     */
    public function luckyInfo()
    {
        $data = $this->request->all();
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
            'id'=>'sometimes|required'
             ],[
                'id.required'=>'活动ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $this->lucky->getLuckyInfo($data);
    }
}