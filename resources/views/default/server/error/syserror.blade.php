@extends('server.layout.content')
@section("title")系统错误@endsection
@section('content')
    <div class="errorwrap">
        <img src="{{pix_asset('server/images/error.png')}}">
        <a href="{{route('index')}}" class="backindex">返回首页</a>
    </div>
@endsection