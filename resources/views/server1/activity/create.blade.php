@extends('server.layout.content')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input newsName" lay-verify="required" placeholder="请输入活动标题">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">摘要</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容摘要" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">详情</label>
            <div class="layui-input-block">
                <textarea class="layui-textarea" name="content" lay-verify="content" id="news_content"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="radio" name="sex" value="1" title="公开">
                <input type="radio" name="sex" value="0" title="隐藏（仅公司成员可见）" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上传封面</label>
            <div class="layui-upload-drag" id="test10" style="float:left;">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处（活动封面：建议上传效果图）</p>
            </div>
            <div class="layui-inline" style="margin-left:50px;">
                <img width="258" height="135" id="src">
            </div>
            <input type="hidden" name="photo" id="photo">
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="addNews">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>

    </form>
@endsection
@section('js')
    <script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
    <script src="{{asset('js/server/activity/index.js')}}"></script>
@stop
