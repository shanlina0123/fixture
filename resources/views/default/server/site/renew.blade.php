@extends('server.layout.content')
@section('title','更新')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
    <style>
        .layui-upload-img {
            width: 92px;
            height: 92px;
            margin: 0 10px 10px 0;
        }
    </style>
@stop
@section('content')
<div class="main">
    <h1 class="pageTitle">更新项目</h1>
    <div class="fullForm">
        <form class="layui-form" id="layui-form" method="post" action="{{route('site-renew',$data->uuid)}}">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">选择阶段</label>
                <div class="layui-input-block">
                    @foreach( $data->tage as $row )
                        <input type="radio" name="stagetagid" @if($row->id == $data->stageid ) checked="checked" @endif datatype="*" nullmsg="请选择阶段" value="{{$row->id}}" title="{{$row->name}}" >
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <textarea name="content" maxlength="255" datatype="*1-300" nullmsg="请填写内容" errormsg="内容为1-300个字符" placeholder="说点什么" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上传图片</label>
                <div class="layui-input-block layui-upload">
                    <button type="button" class="layui-btn" id="updateImg"><i class="layui-icon"></i>上传图片</button>
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览图：
                        <div class="layui-upload-list" id="update_img"></div>
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
        </form>
        <a href="../users/userCenter.html" class="levelNotice">购买专业版，升级更多直播方式>>></a>
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
