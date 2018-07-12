@extends('server.layout.content')
@section("title")VIP升级@endsection
@section('content')
<div class="main" style="margin-bottom: 200px;">
    <fieldset class="layui-elem-field layui-field-title">
        @if($data["tipname"])
            <legend>{{$data["tipname"]}}</legend>
        @else
           <legend>您已成为{{$data["name"]}}会员</legend>
        @endif
    </fieldset>
    <ul class="levelul clearfix">
        <li>
            <p class="toptext">免费版</p>
            <button class="levelbtn">@if($data['id']==1) 当前版本  @elseif($data['id']==2) 已升级 @endif</button>
            <div class="lipswrap">
                @foreach($data['list'] as $k=>$item)
                <div class="lip clearfix">
                    <p class="fl">{{$item['content']}}@if($item['type']=='max') :{{$item['text']}}@endif</p>
                    <i class="fr">
                        @if($item['type']=='has'&&$item['value']==0)
                            <img src="{{pix_asset('server/images/levelno.png')}}">
                        @elseif(($item['type']=='has'&&$item['value']==1) || $item['type']=='max' || $item['type']=='allow')
                            <img src="{{pix_asset('server/images/levelyes.png')}}">
                        @endif
                    </i>
                </div>
                @endforeach
            </div>
        </li>
        <li>
            <p class="toptext level2">标准版</p>
            @if($data["tipname"])
                <button class="levelbtn level2btn">已申请,系统受理中...</button>
            @else
                <button class="levelbtn level2btn @if($data['id']==1) addBtn @endif" url="{{route('vip-store')}}">@if($data['id']==1) 升级标准版 @elseif($data['id']==2) 当前版本 @endif</button>
            @endif
            <div class="lipswrap">
                @foreach($data['list'] as $k=>$item)
                    <div class="lip clearfix">
                        <p class="fl">{{$item['content']}}@if($item['type']=='max') :{{$item['viptext']}}@endif</p>
                        <i class="fr">
                            @if($item['type']=='has'&&$item['vipvalue']==0)
                                <img src="{{pix_asset('server/images/levelno.png')}}">
                            @elseif(($item['type']=='has'&&$item['vipvalue']==1) || $item['type']=='max' || $item['type']=='allow')
                                <img src="{{pix_asset('server/images/levelyes.png')}}">
                            @endif
                        </i>
                    </div>
                @endforeach
            </div>
        </li>
        <li>
            <p class="toptext level3">定制版</p>
            <a href="{{config('configure.link_website')}}" target="blank" class="levelbtn level3btn">了解定制版</a>
            <div class="lipswrap">
                <div class="level3inner clearfix">
                    <div class="fl level3left">业务咨询</div>
                    <div class="fl level3right">
                        <p>02989379272</p>
                        <span>(周一至周六09:00-18:00)</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <!--错误 -->
    <input type="hidden" id="msg" value="{{session('msg')}}">
</div>
@endsection
@section('other')
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/vip/vip.js')}}"></script>
@endsection