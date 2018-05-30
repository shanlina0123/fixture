@extends('server.layout.content')
@section("title")访问受限@endsection
@section('content')
    <div class="errorwrap">
        <img src="{{pix_asset('server/images/quanxian.png')}}">
        <a href="{{route('index')}}" class="backindex">返回首页</a>
    </div>
@endsection