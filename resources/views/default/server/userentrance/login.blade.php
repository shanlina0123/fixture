<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户登录</title>
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
            background-image: url(/default/server/images/TB1d.u8MXXXXXXuXFXXXXXXXXXX-1900-790.jpg);
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
<div class="loginBg">
    <div class="loginWrap">
        <div class="loginInner">
            <img src="{{pix_asset('server/images/topLogo.png')}}" class="loginLogo">
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <ul class="layui-tab-title">
                    <li class="layui-this">密码登录</li>
                    <li>手机号登录</li>
                </ul>
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
                <div class="layui-tab-content loginContent">
                    <!--账号密码登录-->
                    <div class="layui-tab-item layui-show">
                            <form class="form1 layui-form" method="post" action="{{route('login')}}">
                                {{csrf_field()}}
                            <div class="layui-form-item">
                                <input type="text" class="layui-input" name="username" datatype="*3-20"  nullmsg="请输入手机号码或者用户名" errormsg="手机号码或者用户名不正确" autocomplete="off">
                            </div>
                            <div class="layui-form-item">
                                <input type="hidden" name="logintype" value="1"/>
                                <input type="password" name="password"  class="layui-input" datatype="*6-12"  nullmsg="请输入密码" errormsg="密码范围在6~12位之间"  autocomplete="off" autocomplete="new-password">
                            </div>
                            <div class="layui-form-item">
                                <input type="checkbox" lay-skin="primary" title="记住密码" checked="">
                            </div>
                            <div class="layui-form-item loginBtn">
                                <button class="layui-btn loginButton" type="button" id="btn_submit1">登录</button>
                            </div>
                            <div class="layui-form-item loginLink clearfix">
                                <a href="{{route('recover-pass')}}" class="fl">忘记密码？</a>
                                <a href="{{route('register')}}" class="fr">还没有账号？快去注册吧 >></a>
                            </div>
                        </form>
                    </div>
                    <!--手机号码登录-->
                    <div class="layui-tab-item">
                        <form class="layui-form form2" action="{{route('login')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="logintype" value="2"/>
                            <div class="layui-form-item">
                                <input type="text" name="username" id="phone" datatype="m"  nullmsg="请输入手机号码" errormsg="手机号码不正确"  placeholder="手机号" class="layui-input">
                            </div>
                            <div class="layui-form-item clearfix">
                                <input type="text" name="code" placeholder="短信验证码" datatype="n4-4" nullmsg="请输入验证码" errormsg="验证码不正确" class="layui-input codeInput fl">
                                <button type="button" type="button" class="layui-btn msgUncode fr" data-url="{{route('sms-code')}}" data-type="4" >发送验证码</button>
                            </div>
                            <div class="layui-form-item loginBtn">
                                <button class="layui-btn loginButton" type="button" id="btn_submit2">登录</button>
                            </div>
                            <div class="layui-form-item loginLink clearfix">
                                <a href="{{route('recover-pass')}}" class="fl">忘记密码？</a>
                                <a href="{{route('register')}}" class="fr">还没有账号？快去注册吧 >></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/login/login.js')}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/jquery/three.min.js')}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/jquery/css3.js')}}"></script>
</body>
</html>