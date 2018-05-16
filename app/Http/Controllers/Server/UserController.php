<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\UserBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends ServerBaseController
{
    protected $request;
    protected $user;
    public function __construct( UserBusiness $user, Request $request)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * 用户信息
     */
    public function userInfo()
    {
        $userInfo = session('userInfo');
        if( $this->request->method() == "GET" )
        {
            $user = $userInfo;
            return view('server.user.info',compact('user'));
        }else
        {
            $this->request->validate(
                [
                    'phone'=>'bail|regex:/^1[34578][0-9]{9}$/',
                    'code'=>'bail|numeric',//类型
                ],[
                    'phone.regex'=>'手机号码不正确',
                    'code.numeric'=>'验证码不正确',
                ]
            );

            $phone = $this->request->input('phone');
            $code = $this->request->input('code');
            $code_cache = Cache::get('tel_'.$phone);
            if( $code != $code_cache )
            {
                return redirect()->route('user-info')->with('msg','验证码不正确');
            }
            $data['phone'] = $phone;
            $data['token'] = create_uuid();
            $where['uuid'] = $userInfo->uuid;
            $where['companyid'] = $userInfo->companyid;
            $where['id'] = $userInfo['id'];
            $res = $this->user->setPhone( $data,$where );
            if( $res )
            {
                Cache::forget('tel_'.$phone);
                $userInfo->phone = $phone;
                $userInfo->token = $data['token'];
                session(['userInfo'=>$userInfo]);
                Cache::put('userToken'.$userInfo['id'],['token'=>$data['token'],'type'=>2],config('session.lifetime'));
                return redirect()->route('user-info')->with('msg','修改成功');
            }else
            {
                return redirect()->route('user-info')->with('msg','修改失败');
            }
        }
    }

    /**
     * 修改密码
     */
    public function setPass()
    {
        $userInfo = session('userInfo');
        if( $this->request->method() == "GET" )
        {
            $user = $userInfo;
            return view('server.user.setpass',compact('user'));
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
            $code = $this->request->input('code');
            $code_cache = Cache::get('tel_'.$phone);
            if( $code != $code_cache )
            {
                return redirect()->route('set-pass')->with('msg','验证码不正确');
            }
            $where['uuid'] = $userInfo->uuid;
            $where['companyid'] = $userInfo->companyid;
            $where['id'] = $userInfo['id'];
            $data['password'] = optimizedSaltPwd($this->request->input('password'),config('configure.salt'));
            $data['token'] = create_uuid();
            $res = $this->user->setPass( $data,$where );
            if( $res )
            {
                Cache::forget('tel_'.$phone);
                $userInfo->token = $data['token'];
                session(['userInfo'=>$userInfo]);
                Cache::put('userToken'.$userInfo['id'],['token'=>$data['token'],'type'=>2],config('session.lifetime'));
                return redirect()->route('set-pass')->with('msg','修改成功');
            }else
            {
                return redirect()->route('set-pass')->with('msg','修改失败');
            }
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 小程序授权页面
     */
    public function userAuthorize()
    {
        return view('server.user.userauthorize');
    }
}