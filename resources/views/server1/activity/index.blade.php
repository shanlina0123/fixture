@extends('server.layout.content')
@section('content')
    <blockquote class="layui-elem-quote news_search">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" value="" placeholder="请输入关键字" class="layui-input search_input">
            </div>
            <a class="layui-btn search_btn">查询</a>
        </div>
        <div class="layui-inline"  >
            <a class="layui-btn layui-btn-normal newsAdd_btn" data-url="{{route('activity.create')}}">创建</a>
        </div>
        <div class="layui-inline" >
            <a class="layui-btn recommend" style="background-color:#5FB878" data-url="{{route('activity.edit',1)}}">编辑</a>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-danger batchDel" data-url="{{route('activity.edit',"1")}}">批量删除</a>
        </div>
        <div class="layui-inline"  >
            <a class="layui-btn audit_btn" data-url="{{route('activity.show',1)}}">预览</a>
        </div>
        <div class="layui-inline">
            <div class="layui-form-mid layui-word-aux">本页面刷新后除新添加的活动外所有操作无效，关闭页面所有数据重置</div>
        </div>
    </blockquote>
    <div class="layui-form news_list">
        <table class="layui-table">
            <colgroup>
                <col width="50">
                <col width="10%">
                <col>
                <col width="10%">
                <col width="10%">
                <col width="20%">
            </colgroup>
            <thead>
            <tr>
                <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
                <th style="text-align:left;">活动封面</th>
                <th>标题</th>
                <th>参与方式</th>
                <th>是否公开</th>
                <th>发布时间</th>
            </tr>
            </thead>
            @foreach ($responseData as $k=>$data)
                <tr id="{{$data->uuid}}" >
                    <td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose" value="{{$data->uuid}}">
                    </td>
                    <td><a class="img" title="活动封面" style="width:5px;height:5px;">{!!image($data->showurl)!!}</a></td>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->participatory->name }}</td>
                    <td><input type="checkbox" name="show"  @if($data->isopen == 1) checked @endif lay-skin="switch" lay-text="是|否" lay-filter="isShow" data-open-value="{{$data->isopen}}"  data-url="{{route('activity-setting')}}"></td>
                    <td>{{ $data->created_at }}</td>
                </tr>

            @endforeach

        </table>
    </div>
    <div id="page">
        {{$responseData->links()}}
    </div>
@endsection
@section('js')
    <script src="{{asset('js/server/activity/index.js')}}"></script>
@endsection
