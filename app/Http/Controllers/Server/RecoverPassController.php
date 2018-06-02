<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\UserBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RecoverPassController extends ServerBaseController
{

    protected $user;
    protected $request;
    public function __construct(UserBusiness $user,Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }


    public function recoverPass()
    {
        if( $this->request->method() == "GET" )
        {
            return view('server.userentrance.recoverpass');
        }else
        {
            $this->request->validate(
                [
                    'password' => 'required|min:6|max:12|confirmed',
                    'code'=>'bail|numeric',//类型
                ],[
                    'password.min'=>'密码最小为6为字符',
                    'password.max'=>'密码最大为12为字符',
                    'password.confirmed'=>'两次输入密码不一致',
                    'code.numeric'=>'验证码不正确',
                ]
            );
            $phone = $this->request->input('phone');
            if( config('configure.is_sms') == true )
            {
                $code = $this->request->input('code');
                $code_cache = Cache::get('tel_'.$phone);
                if( $code != $code_cache )
                {
                    return redirect()->route('recover-pass')->with('msg','验证码不正确');
                }
            }

            $where['phone'] = $phone;
            $data['password'] = optimizedSaltPwd($this->request->input('password'),config('configure.salt'));
            $res = $this->user->setPass( $data,$where );
            if( $res )
            {
                Cache::forget('tel_'.$phone);
                return redirect()->route('login')->with('msg','修改成功');
            }else
            {
                return redirect()->route('recover-pass')->with('msg','修改失败');
            }
        }
    }
}