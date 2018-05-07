<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="网站关键词">
    <meta name="Description" content="网站介绍">
    <link rel="stylesheet" href="{{asset('css/userentrance/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/userentrance/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('css/userentrance/reg.css')}}">
</head>
<body>
<div id="ajax-hook"></div>
<div class="wrap">
    <div class="wpn">
        <div class="form-data pos">
            <a href=""><img src="/images/logo.png" class="head-logo"></a>
            @if( count($errors) > 0 )
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form" method="post" action="{{route('register')}}">
                {{csrf_field()}}
                <p class="p-input pos">
                    <label for="tel">手机号</label>
                    <input type="number" name="phone" datatype="m"  nullmsg="请输入手机号码" errormsg="手机号码有误" autocomplete="off">
                    <span class="tel-warn tel-err hide Validform_checktip"><em></em><i class="icon-warn"></i><span></span></span>
                </p>
                <p class="p-input pos" id="sendcode">
                    <label for="veri-code">输入验证码</label>
                    <input type="number" name="code" id="veri-code">
                    <a href="javascript:;" class="send">发送验证码</a>
                    <span class="time hide"><em>120</em>s</span>
                    <span class="error"><em></em><i class="icon-warn" style="margin-left: 5px"></i><span></span></span>
                </p>
                <p class="p-input pos" id="pwd">
                    <label for="passport">输入密码</label>
                    <input type="password" name="password" datatype="*6-15"  nullmsg="请输入密码" errormsg="密码范围在6~15位之间"  autocomplete="off">
                    <span class="tel-warn pwd-err hide Validform_checktip"><em></em><i class="icon-warn" style="margin-left: 5px"></i><span></span></span>
                </p>
                <p class="p-input pos" id="confirmpwd">
                    <label for="passport2">确认密码</label>
                    <input type="password" name="password_confirmation" datatype="*" recheck="password" nullmsg="请输入密码" errormsg="您两次输入的账号密码不一致" autocomplete="off">
                    <span class="tel-warn confirmpwd-err hide Validform_checktip"><em></em><i class="icon-warn" style="margin-left: 5px"></i><span></span></span>
                </p>
            <div class="reg_checkboxline pos p-input">
                <span class="z"><i class="icon-ok-sign boxcol" nullmsg="请同意!"></i></span>
                <input type="hidden" name="agree" datatype="*" value="1" nullmsg="请选择" errormsg="请选择">
                <span class="tel-warn confirmpwd-err hide Validform_checktip"><em></em><i class="icon-warn" style="margin-left: 5px"></i><span></span></span>
                <p>我已阅读并接受 <a href="#" target="_brack">《XXXX协议说明》</a></p>
            </div>
            <button class="lang-btn" id="btn_submit">注册</button>
            </form>
            <div class="bottom-info">已有账号，<a href="{{route('login')}}">马上登录</a></div>
            <p class="right">Powered by © 2018</p>
        </div>
    </div>
</div>
<script src="{{asset('js/userentrance/jquery.js')}}"></script>
<script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
<script src="{{asset('js/userentrance/register.js')}}"></script>
</body>
</html>