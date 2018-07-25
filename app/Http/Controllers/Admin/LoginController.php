<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Common\AdminBaseController;
use App\Http\Business\Admin\LoginBusiness;

/***
 * 登录模块
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class LoginController extends AdminBaseController
{

    protected $login_business;
    public function __construct(LoginBusiness $login_business)
    {
        parent::__construct();
        $this->login_business = $login_business;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登录页面、登录
     */
    public function login()
    {
        if ($this->request->method() === 'POST') {
            $data = trimValue(array_except($this->request->all(), ['_token']));
            //密码登陆
            if (is_numeric($data['username']) && strlen($data['username']) == 11) {
                //手机号码
                $this->request->validate([
                    'username' => 'bail|required|regex:/^1[34578][0-9]{9}$/',
                    'password' => 'bail|required|min:6|max:12',
                ], [ 'username.required' => '用户名不能为空','username.regex' => '请输入正确的手机号','username.unique' => '该手机号还未注册',
                    'password.required' => '密码不能为空','password.min' => '密码最小为6为字符', 'password.max' => '密码最大为12为字符',]);
                $where['phone'] = $data['username'];
            } else {
                //用户名称
                $this->request->validate([
                    'username' => 'bail|required|min:3|max:20',
                    'password' => 'bail|required|min:6|max:12',
                ], [
                    'username.required' => '用户名不能为空','username.min' => '用户名最小为3为字符','username.max' => '用户名大为20为字符',
                    'password.required' => '密码不能为空','password.min' => '密码最小为6为字符','password.max' => '密码最大为12为字符',
                ]);
                $where['username'] = $data['username'];
            }
            $where['password'] = $data['password'];
            //业务调用
            $res = $this->login_business->login($where);
            if ($res->status == 0) {
                return redirect()->route('login')->with('msg', $res->msg)->withInput($this->request->all());
            } else {
                return redirect()->route('index');
            }
        } else {
            return view('admin.usercenter.login');
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