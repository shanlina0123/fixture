@extends('server.layout.content')
@section('title','客户列表')
@section('content')
    <div class="main">
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
                    <button type="button" class="layui-btn searchBtn">查询</button>
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
                        <a class="layui-btn layui-btn-sm update-btn" data-url="{{route('client.edit',$row->uuid)}}">跟进</a>
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
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">客户状态</label>
            <div class="layui-input-block">
                <select name="modules" lay-verify="required" lay-search="">
                    <option value="">选择状态</option>
                    @foreach( $status as $rs )
                        <option value="{{$rs->id}}" @if( $rs->id == $where['status'])  selected @endif >{{$rs->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">跟进内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="describe"><button type="button" class="layui-btn ">立即提交</button></div>
    </form>
    <h2 class="logText">跟进日志</h2>
    <ul class="logUl">
        <li>
            <div>客户状态：<span>无效</span></div>
            <p class="backMsg">客户说她已经买过了。</p>
            <div class="clearfix">
                <span class="fl">跟进人：张三</span>
                <span class="fr">跟进时间：2017-12-12</span>
            </div>
        </li>
        <li>
            <div>客户状态：<span>无效</span></div>
            <p class="backMsg">客户说她已经买过了。</p>
            <div class="clearfix">
                <span class="fl">跟进人：张三</span>
                <span class="fr">跟进时间：2017-12-12</span>
            </div>
        </li>
    </ul>
</div>
@section('js')
    <script src="{{pix_asset('server/js/client/client.js')}}"></script>
@endsection