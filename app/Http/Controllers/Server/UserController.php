<?php

namespace App\Http\Controllers\Server;

use App\Http\Business\Common\WxAuthorize;
use App\Http\Business\Server\UserBusiness;
use App\Http\Business\Server\WxTempletBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\User\User;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends ServerBaseController
{
    protected $request;
    protected $user;

    public function __construct(UserBusiness $user, Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * 用户信息
     */
    public function userInfo()
    {
        $userInfo = $this->userInfo;
        if ($this->request->method() == "GET") {
            $user = User::where(['companyid' => $userInfo->companyid, 'id' => $userInfo->id])->first();
            //小程序审核通过放可微信绑定
            $sourcecode = SmallProgram::where("companyid", $user->companyid)->value("sourcecode");
            $user->sourcecode = $sourcecode;
            return view('server.user.info', compact('user'));
        } else {
            $this->request->validate(
                [
                    'phone' => 'bail|regex:/^1[34578][0-9]{9}$/',
                    'code' => 'bail|numeric',//类型
                ], [
                    'phone.regex' => '手机号码不正确',
                    'code.numeric' => '验证码不正确',
                ]
            );

            $phone = $this->request->input('phone');
            $oldPhone = $userInfo->phone;
            if ($phone == $oldPhone) {
                return redirect()->route('user-info')->with('msg', '手机号无变化');
            }
            if (config('configure.is_sms') == true) {
                $code = $this->request->input('code');
                $code_cache = Cache::get('tel_' . $phone);
                if ($code != $code_cache) {
                    return redirect()->route('user-info')->with('msg', '验证码不正确');
                }
            }

            $data['phone'] = $phone;
            $data['token'] = create_uuid();
            $where['uuid'] = $userInfo->uuid;
            $where['companyid'] = $userInfo->companyid;
            $where['id'] = $userInfo['id'];
            $res = $this->user->setPhone($data, $where);
            if ($res) {
                Cache::forget('tel_' . $phone);
                $userInfo->phone = $phone;
                $userInfo->token = $data['token'];
                session('userInfo',$userInfo);
                Cache::put('userToken' . $userInfo['id'], ['token' => $data['token'], 'type' => 2], config('session.lifetime'));
                return redirect()->route('user-info')->with('msg', $oldPhone ? '修改成功' : "绑定成功");
            } else {
                return redirect()->route('user-info')->with('msg', $oldPhone ? '修改成功' : "绑定成功");
            }
        }
    }

    /**
     * 修改密码
     */
    public function setPass()
    {
        $userInfo = session('userInfo');
        if ($this->request->method() == "GET") {
            $user = $userInfo;
            return view('server.user.setpass', compact('user'));

        } else {
            $this->request->validate(
                [
                    'password' => 'required|min:6|max:12|confirmed',
                    /*'code'=>'bail|numeric',//类型*/
                ], [
                    'password.min' => '密码最小为6为字符',
                    'password.max' => '密码最大为12为字符',
                    'password.confirmed' => '两次输入密码不一致',
                    /*'code.numeric'=>'验证码不正确',*/
                ]
            );

            //密码
            if (!preg_match_all("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$$/", $this->request->input('password'), $array)) {
                return redirect()->route('set-pass')->with('msg', '密码格式错误,请输入6-12位字母+数字(区分大小写)');
            }

            $phone = $this->request->input('phone');
            /*if( config('configure.is_sms') == true ) {
                $code = $this->request->input('code');
                $code_cache = Cache::get('tel_' . $phone);
                if ($code != $code_cache) {
                    return redirect()->route('set-pass')->with('msg', '验证码不正确');
                }
            }*/
            $where['uuid'] = $userInfo->uuid;
            $where['companyid'] = $userInfo->companyid;
            $where['id'] = $userInfo['id'];
            $data['password'] = optimizedSaltPwd($this->request->input('password'), config('configure.salt'));
            $data['token'] = create_uuid();
            $res = $this->user->setPass($data, $where);
            if ($res) {
                Cache::forget('tel_' . $phone);
                $userInfo->token = $data['token'];
                session('userInfo',$userInfo);
                Cache::put('userToken' . $userInfo['id'], ['token' => $data['token'], 'type' => 2], config('session.lifetime'));
                return redirect()->route('set-pass')->with('msg', '修改成功');
            } else {
                return redirect()->route('set-pass')->with('msg', '修改失败');
            }
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 小程序授权页面
     */
    public function userAuthorize()
    {
        $userInfo = $this->userInfo;
        //1单独部署
        if (config('wxtype.type') == 1) {
            if ($this->request->method() == "GET") {
                $res = SmallProgram::where(['companyid' => $userInfo->companyid])->first();
                return view('server.user.authorize', compact('res'));

            } else {
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->request->input('authorizer_appid') . '&secret=' . $this->request->input('authorizer_appid_secret');
                $data = getCurl($url, 0);
                if ($data) {
                    $data = json_decode($data, true);
                    if (array_has($data, 'access_token')) {
                        $temple = new WxTempletBusiness;
                        $res = SmallProgram::where(['companyid' => $userInfo->companyid])->first();
                        if ($res) {
                            $res->authorizer_appid = $this->request->input('authorizer_appid');
                            $res->authorizer_appid_secret = $this->request->input('authorizer_appid_secret');
                            if ($res->save()) {
                                Cache::put('access_token' . $userInfo->companyid, $data['access_token'], $data['expires_in'] / 60);
                                //添加模板
                                //$temple->addTemplet($userInfo->companyid);
                                return redirect()->route('user-authorize')->with('msg', '小程序授权成功');
                            }
                        } else {
                            $obj = new SmallProgram();
                            $obj->companyid = $userInfo->companyid;
                            $obj->authorizer_appid = $this->request->input('authorizer_appid');
                            $obj->authorizer_appid_secret = $this->request->input('authorizer_appid_secret');
                            if ($obj->save()) {
                                Cache::put('access_token' . $userInfo->companyid, $data['access_token'], $data['expires_in'] / 60);
                                //添加模板
                                //$temple->addTemplet($userInfo->companyid);
                                return redirect()->route('user-authorize')->with('msg', '小程序授权成功');
                            }
                        }
                        return redirect()->route('user-authorize')->with('msg', '小程序授权失败');

                    } else {
                        return redirect()->route('user-authorize')->with('msg', '小程序授权失败请检查AppID和密钥是否正确');
                    }
                } else {
                    return redirect()->route('user-authorize')->with('msg', '小程序授权失败请检查AppID和密钥是否正确');
                }
            }
        } else {
            $data = $this->user->getAuthorizeStatus($userInfo);
            return view('server.user.userauthorize', compact('data'));
        }
    }


    /***
     * 获取微信登录授权二维码
     */
    public function wxcode()
    {
        //获取小程序二维码
        $uid = $this->userInfo->id;
        $companyid = $this->userInfo->companyid;
        $url = "wx-code/allow/u={$uid}&c={$companyid}&t=2/600";
        $list["wxappcode"] = url($url);
        responseData(\StatusCode::SUCCESS, "", $list);
    }

    /****
     *扫二维码后检测是否绑定微信
     */
    public function checkOpenid()
    {
        $userInfo = $this->userInfo;
        $openid = User::where("id", $userInfo->id)->value("wechatopenid");
        if ($openid) {
            Cache::put('userToken' . $userInfo->id, ['token' => create_uuid(), 'type' => 1], config('session.lifetime'));
            return 'success';
        }
        return 'fail';
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 微信公众号授权页面
     */
    public function userMpAuthorize()
    {
        $userInfo = $this->userInfo;
        //1单独部署
        if (config('wxtype.type') == 1) {
            if ($this->request->method() == "GET") {
                $res = SmallProgram::where(['companyid' => $userInfo->companyid])->first();
                return view('server.user.authorize', compact('res'));

            } else {
                $res = SmallProgram::where(['companyid' => $userInfo->companyid])->first();
                if ($res) {
                    $res->union_wechat_mp_appid = $this->request->input('union_wechat_mp_appid');
                    $res->union_wechat_mp_appsecret = $this->request->input('union_wechat_mp_appsecret');
                    $res->template_id = $this->request->input('template_id');
                    if ($res->save()) {
                        return redirect()->route('user-authorize')->with('msg', '微信公众号授权成功');
                    }
                } else {
                    $obj = new SmallProgram();
                    $obj->companyid = $userInfo->companyid;
                    $obj->union_wechat_mp_appid = $this->request->input('union_wechat_mp_appid');
                    $obj->union_wechat_mp_appsecret = $this->request->input('union_wechat_mp_appsecret');
                    $res->template_id = $this->request->input('template_id');
                    if ($obj->save()) {
                        return redirect()->route('user-authorize')->with('msg', '微信公众号授权成功');
                    }
                }
            }
        } else {
            $data = $this->user->getAuthorizeStatus($userInfo);
            return view('server.user.userauthorize', compact('data'));
        }
    }
}