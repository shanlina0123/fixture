@extends('server.layout.content')
@section('title','绑定手机')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>绑定手机号</legend>
        </fieldset>
        <div class="fullForm">
            <div class="fullFormInner">
                <form class="layui-form"  id="layui-form" action="{{route('user-bind')}}" method="post" phone="{{$user["phone"]}}" iswx="{{$user["wechatopenid"]?1:0}}">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <input type="text" name="phone"  value="{{$user["phone"]}}" id="phone" datatype="m" nullmsg="请输入手机号码" errormsg="手机号码不正确" autocomplete="off" placeholder="手机号" class="layui-input">
                    </div>
                    <div class="layui-form-item clearfix otherShow" style="display: none">
                        <input type="text" name="code" autocomplete="off" datatype="n4-4" nullmsg="请输入验证码" errormsg="验证码不正确" placeholder="短信验证码" class="layui-input codeInput fl">
                        <button type="button" class="layui-btn msgUncode fr" data-url="{{route('sms-code')}}" data-type="2">发送验证码</button>
                    </div>
                    <div class="layui-form-item loginBtn otherShow" style="display: none">
                        <button type="button" class="layui-btn loginButton" id="btn_submit">立即提交</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('other')
    <!--二维码弹窗-->
    <div class="erweimapop" style="display: none;">
        <div class="erweima"></div>
        <p class="poptext">扫描二维码认证您的身份</p>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/user/bind.js')}}"></script>
@endsection