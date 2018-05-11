<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\BusinessServerRegiste;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
class RegisterController extends ServerBaseController
{

    protected $user;
    public function __construct(BusinessServerRegiste $user)
    {
        $this->user = $user;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     */
    public function register( Request $request )
    {
        if( $request->method() === 'POST' )
        {
            $data = trimValue($request->all());
            $request->validate([
                'phone' => 'required|numeric|unique:user|regex:/^1[34578][0-9]{9}$/',
                'password' => 'required|min:6|max:12|confirmed',
                'agree' => 'accepted',
                'code' => 'required|numeric',
            ],[
                'phone.required'=>'电话号码不能为空',
                'phone.numeric'=>'电话号码有误',
                'phone.regex'=>'电话号码有误',
                'phone.unique'=>'该电话号码已被注册',
                'password.min'=>'密码最小为6为字符',
                'password.max'=>'密码最大为12为字符',
                'password.confirmed'=>'两次输入密码不一致',
                'agree.accepted'=>'请选择用户协议',
                'code.required'=>'请填写验证码',
                'code.numeric'=>'验证码有误',
            ]);
            $res = $this->user->userSave($data);
            if( $res == true )
            {
                return redirect()->route('login');
            }else
            {
                return redirect()->route('register')->with('msg','注册失败');
            }
        }else
        {
            return view('server.userentrance.register');
        }
    }
}