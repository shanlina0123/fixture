@extends('server.layout.content')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <form class="layui-form" style="width:80%;" action="{{route('company-setting')}}" method="post">
        {{csrf_field()}}
        <div class="layui-form-item">
            <label class="layui-form-label">公司名称</label>
            <div class="layui-input-block">
                <input type="text" name="name"  datatype="*2-64" value="{{$data?$data->name:''}}" class="layui-input" nullmsg="请输入公司全称" errormsg="公司全称长度2-64字" maxlength="64" placeholder="请输入公司全称">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司简称</label>
            <div class="layui-input-block">
                <input type="text" name="fullname"  datatype="*2-10" value="{{$data?$data->fullname:''}}" class="layui-input" nullmsg="请输入公司简称" errormsg="公司简称长度1-10字" maxlength="10" placeholder="请输入公司简称">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">AppID</label>
            <div class="layui-input-block">
                <input type="text" name="clientappid" value="{{$data?$data->clientappid:''}}"class="layui-input"  datatype="*10-100" maxlength="100" nullmsg="请输入AppID" errormsg="AppID不合法" placeholder="请输入小程序AppID(小程序ID)">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择区域</label>
            <div class="layui-input-inline">
                <select name="provinceid"  id="province" lay-filter="province" data-province="{{$data?$data->provinceid:''}}" datatype="*" nullmsg="请选择省">
                    <option value="">请选择省</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="cityid" id="city" lay-filter="city"  data-cityid="{{$data?$data->cityid:''}}" datatype="*" nullmsg="请选择市">
                    <option value="">请选择市</option>
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="coucntryid"  id="area" lay-filter="area" data-coucntryid="{{$data?$data->coucntryid:''}}" datatype="*" nullmsg="请选择县/区">
                    <option value="">请选择县/区</option>
                </select>
            </div>
        </div>
        <input type="hidden" id="fulladdr" name="fulladdr" value="{{$data?$data->fulladdr:''}}" >
        <input type="hidden" id="logo" value="" name="logo" value="" >
        <div class="layui-form-item">
            <label class="layui-form-label">详细地址</label>
            <div class="layui-input-block">
                <input type="text" name="addr" datatype="*2-150" nullmsg="请输入详细地址" errormsg="详细地址2-150字符" value="{{$data?$data->addr:''}}" class="layui-input" maxlength="150"  placeholder="请输入详细地址">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上传Login</label>
            <div class="layui-upload-drag" id="test10">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处</p>
            </div>
            <div class="layui-inline" >
                <img width="258" height="135" id="src" src="{{getImgUrl($data?$data->logo:'')}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
                <input type="text" name="contacts" datatype="*2-10" nullmsg="请输入真实姓名" errormsg="真实姓名2-10字符" value="{{$data?$data->contacts:''}}" class="layui-input" maxlength="10" placeholder="请输入真实姓名">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司介绍</label>
            <div class="layui-input-block">
                <textarea name="resume" maxlength="255" placeholder="请输入站点描述" class="layui-textarea linksDesc">{{$data?$data->resume:''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" id="btn_submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
        <input type="hidden" name="returnUrl" value="{{session('returnUrl')}}">
    </form>
    <input type="hidden" id="msg" value="{{session('msg')}}">
@stop
@section('js')
<script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
<script src="{{asset('js/server/setting.js')}}"></script>
@stop
