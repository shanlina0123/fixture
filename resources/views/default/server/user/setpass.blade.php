@extends('server.layout.content')
@section('title','项目管理')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>修改密码</legend>
        </fieldset>
        <div class="changepWrap">
            <form class="layui-form changeForm" id="layui-form"  action="{{route('set-pass')}}" method="post">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <input type="text" name="phone" id="phone" datatype="m" value="{{$user->phone}}"  readonly nullmsg="请输入手机号码" errormsg="手机号码不正确"  autocomplete="off" placeholder="手机号" class="layui-input layui-disabled">
                </div>
                <div class="layui-form-item clearfix">
                    <input type="text" name="code" lay-verify="title" datatype="n4-4" nullmsg="请输入验证码" errormsg="验证码不正确" autocomplete="off" placeholder="短信验证码" class="layui-input codeInput fl">
                    <button type="button" class="layui-btn msgUncode fr" data-url="{{route('sms-code')}}" data-type="3">发送验证码</button>
                </div>
                <div class="layui-form-item">
                    <input type="password" name="password"  name="password" datatype="*6-12" placeholder="请输入6-12位字母+数字(区分大小写)" nullmsg="请输入密码" errormsg="密码范围在6~12位之间"  autocomplete="off" placeholder="新密码" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <input type="password" name="password_confirmation" datatype="*" placeholder="确认密码" recheck="password"  nullmsg="请输入密码" errormsg="您两次输入的账号密码不一致"autocomplete="off" placeholder="确认密码" class="layui-input">
                </div>
                <div class="layui-form-item loginBtn">
                    <button class="layui-btn loginButton" type="button" id="btn_submit">立即提交</button>
                </div>
            </form>
        </div>
    </div>
@endsection
<input type="hidden" id="msg" value="{{session('msg')}}">
@if( count($errors) > 0 )
    @foreach ($errors->all() as $K=>$error)
        <input type="hidden" id="error" value="{{$error}}">
    @endforeach
@endif
@section('js')
<script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/user/info.js')}}"></script>
@endsection