@extends('server.layout.content')
@section('title','客户列表')
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>抽奖明细</legend>
        </fieldset>
        <!--列表数据部分-->
        <table class="layui-table">
            <thead>
            <tr>
                <th>编号</th>
                <th>客户姓名</th>
                <th>电话</th>
                <th>活动标题</th>
                <th>状态</th>
                <th>总抽奖次数</th>
                <th>剩余抽奖次数</th>
                <th>是否中奖</th>
            </tr>
            </thead>
            <tr>
                <td>1</td>
                <td>{{$row->name}}</td>
                <td>{{$row->phone}}</td>
                <td>{{$row->content}}</td>
                <td>{{$row->clientToStatus?$row->clientToStatus->name:''}}</td>
                <td>{{$row->clientToLuckyNum->chancenum}}</td>
                <td>{{$row->clientToLuckyNum->chancenum-$row->clientToLuckyNum->chanceusenum}}</td>
                <td>{{$row->clientToLuckyNum->iswin?'是':'否'}} </td>
            </tr>
        </table>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>抽奖记录</legend>
        </fieldset>
        <table class="layui-table">
            <thead>
            <tr>
                <th>抽奖时间</th>
                <th>中奖内容</th>
            </tr>
            </thead>
            @foreach( $row->clientToLuckyRecord as $row )
            <tr>
                <td>{{$row->created_at}}</td>
                <td>{{$row->prizename}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
@endsection

@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/client/client.js')}}"></script>
@endsection