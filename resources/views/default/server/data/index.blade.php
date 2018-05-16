@extends('server.layout.content')
@section("title")属性管理@endsection
@section('content')
    <div class="main">
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <h1 class="pageTitle">系统属性列表</h1>
            <table class="layui-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>属性</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($list!=null) @foreach($list as $index=>$item)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$item->name}}</td>
                    <td><a  href="{{route('data-edit',$item->id)}}" class="layui-btn layui-btn-sm editBtn" >查看编辑</a></td>
                </tr>
                @endforeach @endif
            </table>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/data/data.js')}}"></script>
@endsection