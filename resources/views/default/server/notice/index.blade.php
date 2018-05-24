@extends('server.layout.content')
@section("title")通知管理@endsection
@section('content')
    <div class="main">
        <h1 class="pageTitle">通知列表</h1>
        <table class="layui-table">
            <tr>
                <th>ID</th>
                <th>微信昵称</th>
                <th>类型</th>
                <th>来源</th>
                <th>创建时间</th>
            </tr>
            @if($list!=null) @foreach($list as $index=>$item)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$item->nickname}}</td>
                <td>{{$item->typename}}</td>
                <td>{{$item->sitename}}{{$item->activityname}}</td>
                <td>{{$item->created_at}}</td>
            </tr>
            @endforeach @endif
        </table>
        <div class="pageWrap">@if($list!=null){{ $list->links() }} @endif</div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/notice/notice.js')}}"></script>
@endsection