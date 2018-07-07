@extends('server.layout.content')
@section("title")VIP升级@endsection
@section('content')
<div class="main">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>VIP升级</legend>
    </fieldset>
    @if($data["tipname"])
        <h1 class="notice">{{$data["tipname"]}}</h1>
    @else
        <h1 class="notice">您当前使用的是<span style="color: #1E9FFF">{{$data["name"]}}</span>@if($data['id']==1) 开放更多功能请购买<span style="color: #1E9FFF">标准版</span>@endif</h1>
        <div class="centerBtnWrap"><button type="button" class="layui-btn addBtn" url="{{route('vip-store')}}">立即升级</button></div>
    @endif
    <p class="describe">云易装平台版本功能明</p>
    <table class="layui-table">
        <thead>
        <tr>
            <th>功能</th>
            <th>免费版</th>
            <th>标准版</th>
            <th>定制版</th>
        </tr>
        </thead>
        <tr>
            <td></td>
            <td>基础功能</td>
            <td></td>
            <td></td>
        </tr>
        @foreach($data['list'] as $k=>$item)
            <tr>
                <td>{{$item['content']}}</td>
                <td>@if($item['text']=='无') <i class="layui-icon">&#x1006;</i>@elseif($item['text']=='有')<i class="layui-icon">&#xe605;</i>@else{{$item['text']}} @endif</td>
                <td>@if($item['viptext']=='无') <i class="layui-icon">&#x1006;</i>@elseif($item['viptext']=='有')<i class="layui-icon">&#xe605;</i>@else{{$item['viptext']}} @endif</td>
                <td>@if($k==0)请拨打电话{!! config("configure.sys.site_phone") !!}我们会尽快联系您@endif</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
@section('other')
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/vip/vip.js')}}"></script>
@endsection