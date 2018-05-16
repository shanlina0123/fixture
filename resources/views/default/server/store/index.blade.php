@extends('server.layout.content')
@section("title")门店管理@endsection
@section('content')
    <div class="main">
        <div class="addBtnWrap">
            <button type="button" class="layui-btn addBtn">新增门店</button>
            <div class="topSort layui-inline">
                <form class="layui-form"  action="{{route('store-search-index')}}" method="post" id="searchForm" >
                    <label class="layui-form-label" style="font-size: 14px;">门店筛选</label>
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input" id="name">
                    </div>
                    <button type="button" class="layui-btn searchBtn">查询</button>
                </form>
            </div>
        </div>
        <!--列表数据部分-->
        <form class="layui-form" action="{{route('store-index')}}" method="get" id="listForm">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>门店</th>
                    <th>省</th>
                    <th>市</th>
                    <th>地址</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($list['storeList']!=null) @foreach($list['storeList'] as $index=>$item)
                    <tr  class="listRow" uuid="{{$item->uuid}}" cityid="{{$item->cityid}}" provinceid="{{$item->provinceid}}" >
                        <td>{{$index+1}}</td>
                        <td id="name">{{$item->name}}</td>
                        <td>@if($item->StoreToProvince!=null){{$item->StoreToProvince->name}} @endif</td>
                        <td>@if($item->StoreToCity!=null){{$item->StoreToCity->name}} @endif</td>
                        <td id="addr" >{{$item->addr}}</td>
                        <td>
                            @if($item->isdefault==1)
                                默认
                            @else
                                <div class="layui-btn-group">
                                    <div class="layui-btn-group">
                                        <button type="button" class="layui-btn editBtn">编辑</button>
                                        <button type="button" class="layui-btn deleteBtn" url="{{route('store-delete','uuid')}}">删除</button>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach @endif
            </table>
        </form>
        <div class="pageWrap">@if($list['storeList']!=null){{ $list['storeList']->links() }} @endif</div>
    </div>
@endsection
@section('other')
    <!--新增门店弹窗-->
    <div class="addWrap popWrap">
        <form class="layui-form"  id="addForm"  action="{{route('store-store')}}" method="post" provinceid="{{$list["loginData"]['provinceid']}}" cityid="{{$list["loginData"]['cityid']}}">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">省</label>
                <div class="layui-input-inline">
                    <select lay-filter="changeProvince"  name="modules" lay-verify="required" lay-search="" id="provinceid" jsonData="{{$list['cityListJson']}}">
                        @if($list['provinceList']!=null)
                            <option value="0">请选择</option>
                            @foreach($list['provinceList'] as $k=>$item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                           @endforeach
                        @else
                            <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">市</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="" id="cityid" >
                        @if($list['cityList']!=null)
                            <option value="0">请选择</option>
                            @foreach($list['cityList'][$list['loginData']["provinceid"]] as $k=>$item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        @else
                            <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="title" autocomplete="off" placeholder="门店名称" class="layui-input" id="name">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="title" autocomplete="off" placeholder="地址" class="layui-input" id="addr">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit">立即提交</button>
            </div>
        </form>
    </div>
    <!--编辑门店弹窗-->
    <div class="editWrap popWrap">
        <form class="layui-form"  id="editForm"  action="{{route('store-update','uuid')}}" method="put">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">省</label>
                <div class="layui-input-inline">
                    <select lay-filter="changeProvince"  name="modules" lay-verify="required" lay-search="" id="provinceid" jsonData="{{$list['cityListJson']}}">
                        @if($list['provinceList']!=null)
                            <option value="0">请选择</option>
                            @foreach($list['provinceList'] as $k=>$item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        @else
                            <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">市</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="" id="cityid" >
                        <option value="0">请选择</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="title" autocomplete="off" placeholder="门店名称" class="layui-input" id="name">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="title" autocomplete="off" placeholder="地址" class="layui-input" id="addr">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit">立即提交</button>
            </div>
        </form>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/store/store.js')}}"></script>
@endsection