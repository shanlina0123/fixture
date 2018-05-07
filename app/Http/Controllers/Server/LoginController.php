<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\BusinessServerLogin;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends ServerBaseController
{

    protected $user;
    public function __construct(BusinessServerLogin $user)
    {
        $this->user = $user;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     */
    public function login( Request $request )
    {
        if( $request->method() === 'POST' )
        {
            $type = (int)$request->input('logintype');
            $data = trimValue(array_except($request->all(),['_token']));
            switch ( $type )
            {
                case 1:
                    //密码登陆
                    if( is_numeric($data['username']) && strlen($data['username']) )
                    {
                        //手机号码
                        $request->validate([
                            'username' => 'bail|required|regex:/^1[34578][0-9]{9}$/',
                            'password' => 'bail|required|min:6|max:12',
                        ],[
                            'username.required'=>'用户名不能为空',
                            'username.regex'=>'请输入正确的手机号',
                            'username.unique'=>'该手机号还未注册',
                            'password.required'=>'密码不能为空',
                            'password.min'=>'密码最小为6为字符',
                            'password.max'=>'密码最大为12为字符',
                        ]);

                    }else
                    {
                        //用户名称
                        $request->validate([
                            'username' => 'bail|required|min:3|max:20',
                            'password' => 'bail|required|min:6|max:12',
                        ],[
                            'username.required'=>'用户名不能为空',
                            'username.min'=>'用户名最小为3为字符',
                            'username.max'=>'用户名大为20为字符',
                            'password.required'=>'密码不能为空',
                            'password.min'=>'密码最小为6为字符',
                            'password.max'=>'密码最大为12为字符',
                        ]);
                    }
                    $res = $this->user->checkUser($data);
                    break;
                case 2:
                    //验证码登陆
                    $request->validate([
                        'username' => 'bail|regex:/^1[34578][0-9]{9}$/|unique:user',
                        'code' => 'required|numeric|min:4?maz',
                    ],[
                        'username.regex'=>'请输入正确的手机号',
                        'username.unique'=>'该手机号还未注册',
                        'code.required'=>'验证码不能为空',
                        'code.min'=>'验证码错误',
                        'code.max'=>'验证码错误',
                    ]);
                    break;
            }

            if( $res == false )
            {
                return redirect()->route('login')->with('msg','登陆失败');
            }else
            {
                return redirect()->route('index');
            }
        }else
        {
            return view('server.userentrance.login');
        }
    }


    /**
     * 退出登陆
     */
    public function signOut()
    {
        session()->flush();
        return redirect()->route('login');
    }
}