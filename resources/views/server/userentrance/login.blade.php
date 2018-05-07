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
<div>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<div id="ajax-hook"></div>
<div class="wrap">
    <div class="wpn">
        <div class="form-data pos">
            <a href=""><img src="/images/logo.png" class="head-logo"></a>
            <div class="change-login">
                <p class="account_number on">账号登录</p>
                <p class="message">短信登录</p>
            </div>
            <form class="form1" method="post" action="{{route('login')}}">
                {{csrf_field()}}
                <div class="form">
                    <p class="p-input pos">
                        <span class="tel-warn num-err"><em>账号或密码错误，请重新输入</em><i class="icon-warn"></i></span>
                    </p>
                    <p class="p-input pos">
                        <label for="num">手机号</label>
                        <input type="text" name="username" datatype="m"  nullmsg="请输入手机号码" errormsg="手机号码有误" autocomplete="off">
                        <span class="tel-warn tel-err hide Validform_checktip"><em></em><i class="icon-warn"></i><span></span></span>
                    </p>
                    <p class="p-input pos">
                        <label for="pass">请输入密码</label>
                        <input type="hidden" name="logintype" value="1"/>
                        <input type="password" name="password"  datatype="*6-15"  nullmsg="请输入密码" errormsg="密码范围在6~15位之间"  autocomplete="off" autocomplete="new-password">
                        <span class="tel-warn tel-err hide Validform_checktip"><em></em><i class="icon-warn"></i><span></span></span>
                    </p>
                </div>
                <button class="lang-btn log-btn" id="btn_submit1">登录</button>
            </form>
            <form class="form2 hide" method="post" action="{{route('login')}}">
                <div class="form">
                    <p class="p-input pos">
                        <label for="num2">手机号</label>
                        <input type="number" name="username" datatype="m"  nullmsg="请输入手机号码" errormsg="手机号码有误" autocomplete="off">
                        <span class="tel-warn num2-err hide"><em>账号或密码错误</em><i class="icon-warn"></i></span>
                    </p>
                    <p class="p-input pos">
                        <label for="veri-code">输入验证码</label>
                        <input type="number" id="veri-code">
                        <a href="javascript:;" class="send">发送验证码</a>
                        <span class="time hide"><em>120</em>s</span>
                        <span class="tel-warn error hide">验证码错误</span>
                    </p>
                </div>
                <button class="lang-btn off log-btn" id="btn_submit2">登录</button>
            </form>
            <div class="r-forget cl">
                <a href="{{route('register')}}" class="z">账号注册</a>
                <a href="./getpass.html" class="y">忘记密码</a>
            </div>
            <p class="right">Powered by © 2018</p>
        </div>
    </div>
</div>
<script src="{{asset('js/userentrance/jquery.js')}}"></script>
<script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
<script src="{{asset('js/userentrance/login.js')}}"></script>
</body>
</html>