@extends('server.layout.content')
@section('title','添加模板')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <form class="layui-form" id="layui-form" method="post" action="{{route('site-template.update',$data->uuid)}}">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <input type="hidden" id="type" name="type" value="{{$type}}">
        <div class="layui-form-item">
            <label class="layui-form-label">模板名称</label>
            <div class="layui-input-inline" style="width:25%;">
                <input type="text"  name="name"  value="{{$data->name}}" class="layui-input" placeholder="请输入模板名称" datatype="*2-10"  nullmsg="请输入模板名称" errormsg="模板名称为2-10位字符">
            </div>
        </div>
        <div id="tagList">
            @foreach( $data->stageTemplateToTemplateTag as $k=>$row )
            <div class="layui-form-item">
                <label class="layui-form-label">阶段标签</label>
                <div class="layui-input-block">
                    <div class="layui-input-inline" style="width:25%;">
                        <input type="text"  name="tag[]" value="{{$row->name}}" class="layui-input" placeholder="请输入标签" datatype="*1-2" nullmsg="请输入标签" errormsg="标签2个字内">
                    </div>
                    <div class="layui-input-inline btn" style="width:25%;">
                        <button  type="button" class="layui-btn layui-btn-primary up" onclick="upRow(this)">上移</button>
                        <button  type="button" class="layui-btn layui-btn-primary dow" onclick="dowRow(this)">下移</button>
                        <button  type="button" class="layui-btn layui-btn-primary rem" onclick="removeRow(this)">删除</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <button class="layui-btn" type="button" id="addRow">增加</button>
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
    <script src="{{asset('js/server/site-template.js')}}"></script>
@stop
