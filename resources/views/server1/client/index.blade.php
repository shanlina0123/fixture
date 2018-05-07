@extends('server.layout.content')
@section('title','工地管理')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <blockquote class="layui-elem-quote news_search">
        <form class="layui-form" id="layui-form" method="get" action="{{route('client.index')}}">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" name="k" value="{{$where['k']}}" placeholder="请输入电话或姓名" class="layui-input search_input">
            </div>
        </div>
        <div class="layui-input-inline">
            <select name="status">
                <option value="">选择状态</option>
                @foreach( $status as $rs )
                    <option value="{{$rs->id}}" @if( $rs->id == $where['status'])  selected @endif >{{$rs->name}}</option>
                @endforeach
            </select>
        </div>
        <button class="layui-btn search_btn">查询</button>
        </form>
    </blockquote>
    <div class="layui-form news_list">
        <table class="layui-table">
            <colgroup>
                <col>
                <col>
                <col>
                <col>
                <col>
                <col>
            </colgroup>
            <thead>
            <tr>
                <th>客户姓名</th>
                <th>客户来源</th>
                <th>联系电话</th>
                <th>添加时间</th>
                <th>客户状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="news_content">
            @foreach( $data as $row )
                <tr>
                    <td>{{$row->name}}</td>
                    <td>{{$row->clientToSource?$row->clientToSource->name:''}}</td>
                    <td>{{$row->phone}}</td>
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->clientToStatus?$row->clientToStatus->name:''}}</td>
                    <td>
                        <a class="layui-btn layui-btn-sm update-btn" data-url="{{route('client.edit',$row->uuid)}}">更新</a>
                        <a class="layui-btn layui-btn-sm" data-url="{{route('client.destroy',$row->uuid)}}" onclick="del(this)">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="page">
        {{$data->appends($where)->links()}}
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
@stop
@section('js')
    <script src="{{asset('js/server/client.js')}}"></script>
@stop
