@extends('server.layout.content')
@section('title','抽奖客户')
@section('content')
    <div class="main">
        <div class="addBtnWrap">
            <div class="topSort layui-inline">
                <form class="layui-form"  method="get" action="{{route('lucky-client')}}">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">客户电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="k" value="{{$where['k']}}" placeholder="请输入电话或姓名" class="layui-input search_input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">是否中奖</label>
                        <div class="layui-input-inline">
                            <select name="iswin" lay-verify="required" lay-search="">
                                <option value=""   @if( '' == $where['iswin'])  selected @endif>全部</option>
                                <option value="1"  @if( 1 == $where['iswin'])  selected @endif>是</option>
                                <option value="2"  @if( 2 == $where['iswin'])  selected @endif>否</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">客户状态</label>
                        <div class="layui-input-inline">
                            <select name="status">
                                <option value="">选择状态</option>
                                @foreach( $status as $rs )
                                    <option value="{{$rs->id}}" @if( $rs->id == $where['status'])  selected @endif >{{$rs->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button class="layui-btn searchBtn">查询</button>
                </form>
            </div>
        </div>
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
                <th>操作</th>
            </tr>
            </thead>

            @foreach( $data as $k=>$row )
                <tr>
                    <td>{{$k+1}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->phone}}</td>
                    <td>{{$row->content}}</td>
                    <td>{{$row->clientToStatus?$row->clientToStatus->name:''}}</td>
                    <td>{{$row->clientToLuckyNum->chancenum}}</td>
                    <td>{{$row->clientToLuckyNum->chancenum-$row->clientToLuckyNum->chanceusenum}}</td>
                    <td>{{$row->clientToLuckyNum->iswin?'是':'否'}} </td>
                    <td>
                        <a class="layui-btn layui-btn-sm" href="{{route('lucky-client-log',$row->uuid)}}">查看</a>
                        <a class="layui-btn layui-btn-sm update-btn" data-form="{{route('client.update',$row->uuid)}}" data-url="{{route('client.edit',$row->uuid)}}">跟进</a>
                        <a class="layui-btn layui-btn-sm" data-url="{{route('client.destroy',$row->uuid)}}" onclick="del(this)">删除</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="pageWrap">{{$data->appends($where)->links()}}</div>
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
@endsection
@section('other')
<!--客户跟进弹窗-->
<div class="clientPop">
    <form class="layui-form" id="layui-form" method="post" action="">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div class="layui-form-item">
            <label class="layui-form-label">客户状态</label>
            <div class="layui-input-block">
                <select name="followstatusid" datatype="*" errormsg="请选择">
                    @foreach( $status as $rs )
                        <option value="{{$rs->id}}">{{$rs->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">跟进内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" name="followcontent" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="describe"><button type="button" id="btn_submit" class="layui-btn ">立即提交</button></div>
    </form>
    <div id="list">

    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/client/client.js')}}"></script>
@endsection