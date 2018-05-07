@extends('server.layout.content')
@section('title','模板管理')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <blockquote class="layui-elem-quote news_search">
    <div class="layui-inline">
        <a class="layui-btn layui-btn-mini" data-url="{{route('site-template.create')}}">添加模板</a>
    </div>
    </blockquote>
    <div class="layui-fluid" id="LAY-component-layer-special-demo">
        <div class="layui-row layui-col-space15">
            @foreach( $data as $row )
            <div class="layui-col-md12" style="border-bottom: 1px solid #c2c2c2">
                <div class="layui-card">
                    <div class="layui-card-header">{{$row->name}} @if( $row->isdefault == 1 ) (默认) @endif</div>
                    <div class="layui-card-body">
                        <div class="layui-btn-container layadmin-layer-demo">
                            @foreach( $row->stageTemplateToTemplateTag as $trow )
                                <button data-method="setTop" class="layui-btn layui-btn-primary">{{$trow->name}}</button>
                            @endforeach
                        </div>
                        <div class="layui-row">
                            <div style="float: right">
                                @if( $data->default == 1 )
                                    <a class="layui-btn layui-btn-mini edit-btn" data-type="1" data-url="{{route('site-template.edit',$row->uuid)}}">编辑</a>
                                @else
                                    <a class="layui-btn layui-btn-mini default-btn" data-url="{{route('site-template-default',$row->uuid)}}">设为默认</a>
                                    <a class="layui-btn layui-btn-mini edit-btn" data-type="0" data-url="{{route('site-template.edit',$row->uuid)}}">编辑</a>
                                    <a class="layui-btn layui-btn-mini del-btn"  data-url="{{route('site-template.destroy',$row->uuid)}}">删除</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@stop
@section('js')
    <script src="{{asset('js/server/site-template.js')}}"></script>
@stop
