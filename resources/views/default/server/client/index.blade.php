@extends('server.layout.content')
@section('title','预约客户')
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>预约客户</legend>
        </fieldset>
        <div class="addBtnWrap">
            <div class="topSort layui-inline">
                <form class="layui-form"  method="get" action="{{route('client.index')}}">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">客户电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="k" value="{{$where['k']}}" placeholder="请输入电话或姓名" class="layui-input search_input">
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
                <th>客户来源</th>
                <th>状态</th>
                <th>预约时间</th>
                <th>操作</th>
            </tr>
            </thead>

            @foreach( $data as $k=>$row )
                <tr>
                    <td>{{$k+1}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->phone}}</td>
                    <td>{{$row->clientToSource?$row->clientToSource->name:''}}</td>
                    <td>{{$row->clientToStatus?$row->clientToStatus->name:''}}</td>
                    <td>{{$row->created_at}}</td>
                    <td>
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
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/client/client.js')}}"></script>
@endsection