@extends('server.layout.content')
@section('title','填写资料')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
@endsection
@section('content')
<div class="main" style="margin-bottom: 100px;">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>填写资料</legend>
    </fieldset>
    <div class="fullForm">
        <div class="fullFormInner">
        <form class="layui-form"  action="{{route('company-setting')}}" method="post">
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
            <input type="hidden" id="companyLogoName" value="" name="logo"  >
            <input type="hidden" id="covermapName" value="" name="covermap">
            <input type="hidden" id="delcompanyLogoName" value="" name="dellogo"  >
            <input type="hidden" id="delcovermapName" value="" name="delcovermap">
            <div class="layui-form-item">
                <label class="layui-form-label">详细地址</label>
                <div class="layui-input-block">
                    <input type="text" name="addr" datatype="*2-150" nullmsg="请输入详细地址" errormsg="详细地址2-150字符" value="{{$data?$data->addr:''}}" class="layui-input" maxlength="150"  placeholder="请输入详细地址">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公司介绍</label>
                <div class="layui-input-block">
                    <textarea name="resume" maxlength="300" placeholder="请输入站点描述" class="layui-textarea linksDesc">{{$data?$data->resume:''}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">公司电话</label>
                <div class="layui-input-block">
                    <input type="text" name="phone" datatype="*8-30" nullmsg="请输入公司电话" errormsg="公司电话输入有误" value="{{$data?$data->phone:''}}" class="layui-input" maxlength="30" placeholder="请输入公司电话">
                </div>
            </div>
            <div class="layui-form-item" id="companyLogo">
                <label class="layui-form-label">公司Logo</label>
                <div class="layui-upload-drag" id="test10" style="float: left">
                    <i class="layui-icon"></i>
                    <p>请上传150px*150px的图片,最大{{config("configure.maxImgSize")}}</p>
                </div>
                @if( $data && $data->logo )  <div  id="companyLogoImg" class="uploadImg layui-inline fl">
                    <span><img src="{{pix_asset('server/images/close.png')}}" data-clear="delcompanyLogoName" data-clear-src="{{$data?$data->logo:''}}" onclick="delTempImg(this,'up')"></span>
                    <img  id="companySrc" width="230" height="132" src="{{getImgUrl($data?$data->logo:'')}}" class="layui-upload-img">
                </div> @endif
            </div>
            <div class="layui-form-item" id="covermap">
                <label class="layui-form-label">首页封面</label>
                <div class="layui-upload-drag" id="test11" style="float: left">
                    <i class="layui-icon"></i>
                    <p>请上传750px*250px的图片,最大{{config("configure.maxImgSize")}}</p>
                </div>
                @if( $data && $data->covermap )  <div  id="covermapImg" class="uploadImg layui-inline fl">
                    <span><img src="{{pix_asset('server/images/close.png')}}" data-clear="delcovermapName"  data-clear-src="{{$data?$data->covermap:''}}" onclick="delTempImg(this,'up')"></span>
                    <img  id="covermapSrc" width="230" height="132" src="{{getImgUrl($data?$data->covermap:'')}}" class="layui-upload-img"> </div> @endif
            </div>
            <div class="submitButWrap">
                <button type="button" class="layui-btn" id="btn_submit">立即提交</button>
            </div>
            <input type="hidden" name="returnUrl" value="{{session('returnUrl')}}">
        </form>
            <input type="hidden" id="msg" value="{{session('msg')}}">
            <input type="hidden" id="errormsg" value="{{session('errormsg')}}">
        </div>
    </div>
    <input type="hidden" id="sessionTmp" data-companyid="{{session("userInfo")->companyid}}" data-isadmin="{{session("userInfo")->isadmin}}"  data-phone="{{session("userInfo")->phone}}" />
</div>
@stop
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/company/setting.js')}}"></script>
@stop
