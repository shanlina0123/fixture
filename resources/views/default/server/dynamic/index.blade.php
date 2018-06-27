@extends('server.layout.content')
@section('title','动态管理')
@section('css')
@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>动态列表</legend>
        </fieldset>
        <!--列表数据部分-->
        <form class="layui-form">
            <table class="layui-table">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th>内容</th>
                    <th width="5%">阶段</th>
                    <th width="10%">创建日期</th>
                    <th width="10%">操作</th>
                </tr>
                </thead>
                @foreach( $data as $k=>$row )
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{str_limit($row->content,100)}}</td>
                        <td>{{$row->sitestagename}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>
                            <div class="layui-btn-group">
                                <a class="layui-btn" href="{{route('dynamic-edit',$row->uuid)}}">编辑</a>
                                <button type="button" class="layui-btn deleteBtn" onclick="delDynamic(this)" data-url="{{route('dynamic-destroy',$row->uuid)}}">删除</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
        <div class="pageWrap">{{$data->appends($id)->links()}}</div>
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/plugins/html2canvas/0.4.1/html2canvas.js')}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/site/site.js')}}"></script>
@endsection