@extends('server.layout.content')
@section("title")敬请期待@endsection
@section('content')
    <div class="errorwrap">
        <img src="{{pix_asset('server/images/coming.png')}}">
        <a href="{{route('index')}}" class="backindex">返回首页</a>
    </div>
@endsection