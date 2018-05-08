@extends('server.layout.content')
@section('title','工地管理')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <form class="layui-form" id="layui-form" method="post" action="{{route('site-renew',$data->uuid)}}">
        {{csrf_field()}}
        <div class="layui-form-item">
            <label class="layui-form-label">工地名称</label>
            <div class="layui-input-block">
                <input type="text"   value="{{$data->name}}" class="layui-input" disabled="disabled">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">阶段</label>
            <div class="layui-input-block">
                @foreach( $data->tage as $row )
                    <input type="radio" name="stagetagid" @if($row->id == $data->stageid ) checked="checked" @endif datatype="*" nullmsg="请选择阶段" value="{{$row->id}}" title="{{$row->name}}" >
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea name="content" maxlength="255" datatype="*1-300" nullmsg="请填写内容" errormsg="内容为1-300个字符" placeholder="说点什么" class="layui-textarea linksDesc"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上传图片</label>
            <div class="layui-upload-drag" id="test10">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处</p>
            </div>
            <div class="layui-inline" >
                <img width="258" height="135" id="src">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-block">
                <input type="text"   value="{{$data->time}}" class="layui-input" disabled="disabled">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" id="btn_submit">立即提交</button>
            </div>
        </div>
    </form>
    <input type="hidden" id="msg" value="{{session('msg')}}">
    @if( count($errors) > 0 )
        @foreach ($errors->all() as $K=>$error)
            <input type="hidden" id="error" value="{{$error}}">
        @endforeach
    @endif
@stop
@section('js')
    <script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
    <script src="{{asset('js/server/site.js')}}"></script>
@stop
