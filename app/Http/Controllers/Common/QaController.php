<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 14:24
 */

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use App\Http\Model\Qa\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class QaController extends Controller
{
    public function feedback( Request $request )
    {
        $data = trimValue($request->all());
        $validator = Validator::make(
            $data,[
            'phone'=>'sometimes|required|regex:/^1[345789][0-9]{9}$/',//电话
            'content'=>'required|max:300',//内容
        ],[
            'phone.regex'=>'手机号码有误',
            'phone.required'=>'手机号码有误',
            'content.required'=>'内容不能为空',
            'content.max'=>'内容最多300个字',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $res = new Feedback;
        $res->uuid = create_uuid();
        $res->phone = array_has($data,'phone')?$data['phone']:"";
        $res->content = $data['content'];
        $res->isdealit = 0;
        $res->created_at = date("Y-m-d H:");
        if( $res->save() )
        {
            responseData(\StatusCode::SUCCESS,'反馈成功');
        }
        responseData(\StatusCode::ERROR,'反馈失败');
    }
}