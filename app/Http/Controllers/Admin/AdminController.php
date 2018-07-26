<?php
namespace App\Http\Controllers\Admin;
use \App\Http\Controllers\Common\AdminBaseController;


/***
 * 账号设置
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends AdminBaseController
{

    protected $admin_business;
    public function __construct(AdminBusiness $admin_business)
    {
        parent::__construct();
        $this->admin_business = $admin_business;
    }


    /***
     * 后台账号
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index(){
        return view('admin.admin.index');
    }


    /**
     * 修改密码
     */
    public function setPass()
    {
        $userInfo = session('adminInfo');
        if ($this->request->method() == "GET") {
            $user = $userInfo;
            return view('admin.admin.setpass', compact('user'));

        } else {
            $this->request->validate(
                [
                    'password' => 'required|min:6|max:12|confirmed',
                ], [
                    'password.min' => '密码最小为6为字符',
                    'password.max' => '密码最大为12为字符',
                    'password.confirmed' => '两次输入密码不一致',
                ]
            );

            //密码
            if (!preg_match_all("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$$/", $this->request->input('password'), $array)) {
                return redirect()->route('set-pass')->with('msg', '密码格式错误,请输入6-12位字母+数字(区分大小写)');
            }
            $where['uuid'] = $userInfo->uuid;
            $where['id'] = $userInfo['id'];
            $data['password'] = optimizedSaltPwd($this->request->input('password'), config('configure.salt'));
            $data['token'] = create_uuid();
            $res = $this->admin_business->setPass($data, $where);
            if ($res) {
                return redirect()->route('set-pass')->with('msg', '修改成功');
            } else {
                return redirect()->route('set-pass')->with('msg', '修改失败');
            }
        }
    }

}