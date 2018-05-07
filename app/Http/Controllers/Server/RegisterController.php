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
            $request->validate([
                'phone' => 'required|numeric|unique:user|regex:/^1[34578][0-9]{9}$/',
                'password' => 'required|min:6|max:15',
                'confirmed' => 'password_confirmation',
                'agree' => 'required|numeric',
                'code' => 'required|numeric',
            ]);

            $data = trimValue(array_except($request->all(),['_token','agree']));
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