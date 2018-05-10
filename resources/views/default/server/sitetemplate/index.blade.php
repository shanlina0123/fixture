@extends('server.layout.content')
@section('title','模板管理')
@section('content')
<div class="main">
    <div class="addBtnWrap">
        <a class="layui-btn layui-btn-mini" href="{{route('site-template.create')}}">添加模板</a>
    </div>
    <form class="layui-form">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>系统模板</legend>
    </fieldset>
    <table class="layui-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>模板名称</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach( $data->default as $row )
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
                <td>
                    <div class="layui-btn-group">
                        <button type="button" class="layui-btn editBtn">设为默认</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>自定义模板</legend>
    </fieldset>

    <table class="layui-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>模板名称</th>
            <th>模板阶段</th>
            <th>设为默认</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach( $data->definition as $row )
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->name}}</td>
                <td>
                    @foreach( $row->stageTemplateToTemplateTag as $dk=>$trow )
                        {{$trow->name}}
                        @if( count($row->stageTemplateToTemplateTag)-1 != $dk ) -> @endif
                    @endforeach
                </td>
                <td>
                    <input type="checkbox" lay-skin="switch" @if( $row->isdefault == 1 ) checked @endif  lay-text="是|否" disabled>
                </td>
                <td>
                    <div class="layui-btn-group">
                        @if( $row->isdefault == 1 )
                            <a class="layui-btn layui-btn-danger layui-btn-mini">设为默认</a>
                        @else
                            <a class="layui-btn layui-btn-mini default-btn" data-url="{{route('site-template-default',$row->uuid)}}">设为默认</a>
                        @endif
                        <a class="layui-btn layui-btn-mini edit-btn" href="{{route('site-template.edit',$row->uuid)}}">编辑</a>
                        <a class="layui-btn layui-btn-mini del-btn"  data-url="{{route('site-template.destroy',$row->uuid)}}">删除</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    </form>
</div>
<input type="hidden" id="msg" value="{{session('msg')}}">
@endsection
@section('js')
    <script src="{{pix_asset('server/js/site/site-template.js')}}"></script>
@endsection