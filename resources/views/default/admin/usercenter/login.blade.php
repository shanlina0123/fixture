<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户登录</title>
    <link rel="icon" href="{{pix_asset('admin/images/icon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--css-->
    <link rel="stylesheet" href="{{pix_asset('admin/css/common.css')}}">
    <link rel="stylesheet" href="{{pix_asset('admin/plugins/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{pix_asset('admin/css/base.css')}}">
    <link rel="stylesheet" href="{{pix_asset('admin/css/login.css')}}">
    <script type="text/javascript" src="{{pix_asset('admin/plugins/jquery/jquery-2.1.4.min.js',false)}}"></script>
    <style>
        body {
            background-color: #193c6d;
            filter: progid:DXImageTransform.Microsoft.gradient(gradientType=1, startColorstr='#003073', endColorstr='#029797');
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
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<div class="loginBg">
    <div class="loginWrap">
        <div class="loginInner">
            <div class="errorWrap" style="display: @if(session('msg')) block @else none @endif; ">
                <div class="loginError">
                    <span>{{session('msg')}}</span>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <span>{{$error}}</span>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="topLogo">
                <img src="{{pix_asset('admin/images/logoblue.png')}}" class="loginLogo fl">
                <span class="fl systemName">后台管理系统</span>
            </div>
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <div class="layui-tab-content loginContent">
                    <!--账号密码登录-->
                    <div class="layui-tab-item layui-show">
                        <form class="form1 layui-form" method="post" action="{{route('login')}}" tosubid="1">
                            {{csrf_field()}}
                            <div class="layui-form-item">
                                <input type="text" class="layui-input" name="username" value="{{old('username')}}"
                                       datatype="*3-20" placeholder="账号/手机号" nullmsg="请输入手机号码或者用户名"
                                       errormsg="手机号码或者用户名不正确" autocomplete="off">
                            </div>
                            <div class="layui-form-item">
                                <input type="password" name="password" class="layui-input" datatype="*6-12"
                                       placeholder="密码" nullmsg="请输入密码" errormsg="密码范围在6~12位之间" autocomplete="off"
                                       autocomplete="new-password" value="{{old('password')}}">
                            </div>
                            <!--账号密码登录-->
                            <div class="layui-tab-item layui-show">
                                <div class="layui-form-item loginBtn">
                                    <button class="layui-btn loginButton" type="button" id="btn_submit1">登录</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{pix_asset('admin/plugins/layui/layui.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('admin/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('admin/js/login/login.js')}}"></script>
</body>
</html>