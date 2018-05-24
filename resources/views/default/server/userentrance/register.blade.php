<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>注册</title>
    <link rel="icon" href="{{pix_asset('server/images/icon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--css-->
    <link rel="stylesheet" href="{{pix_asset('server/css/common.css')}}">
    <link rel="stylesheet" href="{{pix_asset('server/plugins/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{pix_asset('server/css/base.css')}}">
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
    <script type="text/javascript" src="{{pix_asset('server/plugins/jquery/jquery-2.1.4.min.js',false)}}"></script>
    <style>
        body {
            background-color: #193c6d;
            filter: progid: DXImageTransform.Microsoft.gradient(gradientType=1, startColorstr='#003073', endColorstr='#029797');
            background-image: url(//img.alicdn.com/tps/TB1d.u8MXXXXXXuXFXXXXXXXXXX-1900-790.jpg);
            background-size: 100%;
            background-image: -webkit-gradient(linear, 0 0, 100% 100%, color-stop(0, #003073), color-stop(100%, #029797));
            background-image: -webkit-linear-gradient(135deg, #003073, #029797);
            background-image: -moz-linear-gradient(45deg, #003073, #029797);
            background-image: -ms-linear-gradient(45deg, #003073 0, #029797 100%);
            background-image: -o-linear-gradient(45deg, #003073, #029797);
            background-image: linear-gradient(135deg, #003073, #029797);
            text-align: center;
            margin: 0px;
            overflow: hidden;
        }
    </style>
</head>
<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="wrap">
    <div class="loginBg">
        <div class="loginWrap">
            <div class="loginInner">
                <img src="{{pix_asset('server/images/logo.png')}}" class="loginLogo">
                <div class="errorWrap">
                    <div class="loginError">
                        <span>{{session('msg')}}</span>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <span>{{$error}}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
                <form class="form layui-form" method="post" action="{{route('register')}}">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <input type="number" class="layui-input" placeholder="手机号"  id="phone" name="phone" datatype="m"  nullmsg="请输入手机号码" errormsg="手机号码有误" autocomplete="off">
                    </div>
                    <div class="layui-form-item clearfix">
                        <input type="text" name="code" lay-verify="title" autocomplete="off" placeholder="短信验证码" class="layui-input codeInput fl">
                        <button type="button" class="layui-btn msgUncode fr" data-url="{{route('sms-code')}}" data-type="1" >发送验证码</button>
                    </div>
                    <div class="layui-form-item">
                        <input type="password" class="layui-input" name="password" datatype="*6-12" placeholder="请输入6-12位字母+数字(区分大小写)" nullmsg="请输入密码" errormsg="密码范围在6~12位之间"  autocomplete="off">
                    </div>
                    <div class="layui-form-item">
                        <input type="password" class="layui-input" name="password_confirmation" datatype="*" placeholder="确认密码" recheck="password" nullmsg="请输入密码" errormsg="您两次输入的账号密码不一致" autocomplete="off">
                    </div>
                    <div class="registDeel">
                        <input type="checkbox" lay-skin="primary" datatype="*" errormsg="请选择"  name="agree">
                        <a href="javascript:;">用户注册协议</a>
                    </div>
                    <div class="layui-form-item loginBtn">
                        <button type="button" class="layui-btn loginButton" id="btn_submit">立即注册</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/register/register.js')}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/jquery/three.min.js')}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/jquery/css3.js')}}"></script>
</body>
</html>