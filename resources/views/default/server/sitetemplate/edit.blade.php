@extends('server.layout.content')
@section('title','修改模板')
@section('css')
    <style>
        .centerAdd{
            width: 800px;
            text-align: center;
            margin-top: 50px;
        }
    </style>
@stop
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>修改模板</legend>
        </fieldset>
        <form class="layui-form" id="layui-form" method="post" action="{{route('site-template.update',$data->uuid)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
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
                        <div class="layui-input-inline" style="width:25%;">
                            <input type="text"  name="tag[]" value="{{$row->name}}" class="layui-input" placeholder="请输入标签" datatype="*1-2" nullmsg="请输入标签" errormsg="标签2个字内">
                        </div>
                        <div class="layui-input-inline btn" style="width:25%;">
                            <button  type="button" class="layui-btn layui-btn-primary up" onclick="upRow(this)">上移</button>
                            <button  type="button" class="layui-btn layui-btn-primary dow" onclick="dowRow(this)">下移</button>
                            <button  type="button" class="layui-btn layui-btn-primary rem" onclick="removeRow(this)">删除</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="centerAdd">
                <button class="layui-btn" type="button" id="btn_submit">立即提交</button>
            </div>
        </form>
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
    @if( count($errors) > 0 )
        @foreach ($errors->all() as $K=>$error)
            <input type="hidden" id="error" value="{{$error}}">
        @endforeach
    @endif
@stop
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/site/site-template.js')}}"></script>
@stop