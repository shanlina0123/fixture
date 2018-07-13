@extends('server.layout.content')
@section('title','跟进项目')
@section('css')
    <style>
        .layui-upload-img {
            width: 120px;
            height: 120px;
        }
        .ImgWrap {
            position: relative;
            margin-left: 10px;
        }

        .ImgWrap span img {
            position: absolute;
            right: 3px;
            top: 3px;
            cursor: pointer;
        }
        video{
            width: 202px!important;
        }
    </style>
@stop
@section('content')
<div class="main">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>更新项目</legend>
    </fieldset>
    <div class="fullForm">
        <form class="layui-form" id="layui-form" method="post" action="{{route('site-renew',$data->uuid)}}">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">选择阶段</label>
                <div class="layui-input-block">
                    @foreach( $data->tage as $row )
                        <input type="radio" name="stagetagid" lay-filter="radio"  data-name="{{$row->name}}" @if($row->id == $data->stageid ) checked="checked" @endif datatype="*" nullmsg="请选择阶段" value="{{$row->id}}" title="{{$row->name}}" >
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <textarea name="content" maxlength="255" datatype="*1-300" nullmsg="请填写内容" errormsg="内容为1-300个字符" placeholder="说点什么" class="layui-textarea"></textarea>
                </div>
            </div>
            <input type="hidden" name="title" value="{{$data->name}}">
            <div class="layui-form-item">
                <label class="layui-form-label">上传图片</label>
                <div class="layui-input-block layui-upload">
                    <button type="button" class="layui-btn" id="updateVideo"><i class="layui-icon"></i>上传视频(最多1个)</button>
                    <button type="button" class="layui-btn" id="updateImg"><i class="layui-icon"></i>上传图片(最多9张)</button>
                    <span class="imgnotice">请上传图片240px*240px,视频mp4格式,单文件最大{{config("configure.maxImgSize")}}</span>
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览图：
                        <div class="layui-upload-list clearfix" id="update_img"></div>
                    </blockquote>
                </div>
            </div>
            {{--<div class="layui-form-item">
                <label class="layui-form-label">上传VR图</label>
                <div class="layui-input-block layui-upload">
                    <button type="button" class="layui-btn" id="updateVR"><i class="layui-icon"></i>上传VR图</button>
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览图：
                        <div class="layui-upload-list" id="update_VR"></div>
                    </blockquote>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上传视频</label>
                <div class="layui-input-block layui-upload">
                    <button type="button" class="layui-btn" id="updateVideo"><i class="layui-icon"></i>上传视频</button>
                </div>
            </div>--}}
            <div class="submitButWrap">
                <button type="button" class="layui-btn"  id="btn_submit">立即提交</button>
            </div>
            <input type="hidden" id="img" name="img">
            @foreach( $data->tage as $row )
                @if($row->id == $data->stageid )
                 <input type="hidden" name="sitestagename" value="{{$row->name}}" id="sitestagename">
                @endif
            @endforeach
        </form>
    </div>
</div>
<input type="hidden" id="msg" value="{{session('msg')}}">
@if( count($errors) > 0 )
    @foreach ($errors->all() as $K=>$error)
        <input type="hidden" id="error" value="{{$error}}">
    @endforeach
@endif
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script src="{{pix_asset('server/js/site/site.js')}}"></script>
@endsection
