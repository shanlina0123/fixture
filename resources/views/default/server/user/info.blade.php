@extends('server.layout.content')
@section('title','项目管理')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>个人资料</legend>
        </fieldset>
        <div class="fullForm userMessageForm">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$user->nickname}}" class="layui-input" readonly>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">账号</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$user->username}}" class="layui-input" readonly>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>
                    <div class="layui-input-block clearfix">
                        <input type="text" value="{{$user->phone}}" class="layui-input messagePhone fl" readonly>
                        <a href="javascript:;" class="changePhone fl">更换手机</a>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$user->status?'正常':'禁用'}}" class="layui-input" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<!--更换手机弹窗-->
<div class="popWrap" style="display: none">
    <form class="layui-form"  id="layui-form" action="{{route('user-info')}}" method="post" >
        {{csrf_field()}}
        <div class="layui-form-item">
            <input type="text" name="phone" value="" id="phone" datatype="m" nullmsg="请输入手机号码" errormsg="手机号码不正确" autocomplete="off" placeholder="手机号" class="layui-input">
        </div>
        <div class="layui-form-item clearfix">
            <input type="text" name="code" autocomplete="off" datatype="n4-4" nullmsg="请输入验证码" errormsg="验证码不正确" placeholder="短信验证码" class="layui-input codeInput fl">
            <button type="button" class="layui-btn msgUncode fr" data-url="{{route('sms-code')}}" data-type="2">发送验证码</button>
        </div>
        <div class="layui-form-item loginBtn">
            <button type="button" class="layui-btn loginButton" id="btn_submit">立即提交</button>
        </div>
    </form>
</div>
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