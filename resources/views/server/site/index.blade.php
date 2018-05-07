@extends('server.layout.content')
@section('title','工地管理')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <div class="layui-col-sm3">
                <div class="grid-demo layui-text">当前工地数：{{$data->total()}}/</div>
            </div>
            <div class="layui-col-sm7">
                <a  data-url="{{route('site.create')}}">升级无限工地</a>
            </div>
            <div class="layui-col-sm2">
                <a class="layui-btn add-btn" data-url="{{route('site.create')}}">创建工地</a>
            </div>
        </div>
    </div>
    <div class="layui-form news_list">
        <table class="layui-table">
            <colgroup>
                <col width="8%">
                <col width="8%">
                <col width="4%">
                <col width="9%">
                <col width="9%">
                <col width="9%">
                <col width="9%">
                <col>
                <col width="5%">
                <col width="5%">
                <col width="5%">
                <col width="15%">
            </colgroup>
            <thead>
            <tr>
                <th>图片</th>
                <th>门店</th>
                <th>阶段</th>
                <th>工地名称</th>
                <th>楼盘名称</th>
                <th>门牌号</th>
                <th>户型面积</th>
                <th>地址</th>
                <th>浏览</th>
                <th>关注</th>
                <th>展示</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody class="news_content">
            @foreach( $data as $row )
            <tr>
                <td><img src="{{getImgUrl($row->explodedossurl)}}"></td>
                <td>{{$row->siteToStore?$row->siteToStore->name:''}}</td>
                @if( $row->isdefaulttemplate == 1 )
                    <td>{{$row->siteToDataTag?$row->siteToDataTag->name:''}}</td>
                @else
                    <td>{{$row->siteToCommpanyTag?$row->siteToCommpanyTag->name:''}}</td>
                @endif
                <td>{{$row->name}}</td>
                <td>{{$row->housename}}</td>
                <td>{{$row->doornumber}}</td>
                <td>{{$row->acreage}}</td>
                <td>{{$row->addr}}</td>
                <td></td>
                <td></td>
                <td><input type="checkbox" name="show"  @if($row->isopen == 1) checked @endif lay-skin="switch" lay-text="是|否" lay-filter="isShow"></td>
                <td>
                    <a class="layui-btn layui-btn-sm update-btn" data-url="{{route('site-renew',$row->uuid)}}">更新</a>
                    <a class="layui-btn layui-btn-sm edit-btn" data-url="{{route('site.edit',$row->uuid)}}">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" onclick="del(this)" data-url="{{route('site.destroy',$row->uuid)}}">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="page">
        {{$data->links()}}
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
@stop
@section('js')
<script src="{{asset('js/server/site.js')}}"></script>
@stop
