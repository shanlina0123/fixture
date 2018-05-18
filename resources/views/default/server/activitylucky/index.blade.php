@extends('server.layout.content')
@section("title")活动管理@endsection
@section('content')
    <div class="main">
        <!--新增和筛选部分-->
        <div class="addBtnWrap">
            <a  class="layui-btn addBtn" url="{{route('lucky-create')}}">新建抽奖</a>
            <div class="topSort layui-inline">
                <form class="layui-form " action="">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">活动名称</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">活动状态</label>
                        <div class="layui-input-inline">
                            <select name="modules" lay-verify="required" lay-search="">
                                <option value="">全部</option>
                                <option value="1">上线</option>
                                <option value="2">下线</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">门店</label>
                        <div class="layui-input-inline">
                            <select name="modules" lay-verify="required" lay-search="" id="storeid">
                                <option value="">全部</option>
                                @if($list['storeList']!=null) @foreach($list['storeList'] as $k=>$item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach  @endif
                            </select>
                        </div>
                    </div>
                    <button type="button" class="layui-btn searchBtn">查询</button>
                </form>
            </div>
        </div>
        <h1 class="pageTitle">活动列表</h1>
        <!--列表数据部分-->
        <form class="layui-form">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>活动编号</th>
                    <th>活动名称</th>
                    <th>活动门店</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>上线/下线</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($list['luckyList']!=null) @foreach($list['luckyList'] as $index=>$item)
                <tr id="{{$item->id}}">
                    <td>{{$index+1}}</td>
                    <td>{{$item->title}}</td>
                    <td>@if($item->luckyToStore){{$item->luckyToStore->title}}@endif</td>
                    <td>{{$item->startdate}}</td>
                    <td>{{$item->enddate}}</td>
                    <td id="rowIsOnline" isonline="{{$item->isonline}}">
                        @if($item->isonline==1)
                            <input type="checkbox"    name="isonline" lay-skin="switch" lay-text="ON|OFF" checked="checked" lay-filter="rowIsOnline" url="{{route('lucky-setting','id')}}">
                        @else
                            <input type="checkbox"    name="isonline" lay-skin="switch" lay-text="ON|OFF" lay-filter="rowIsOnline" url="{{route('lucky-setting','id')}}">
                        @endif
                    </td>
                    <td>
                        <div class="layui-btn-group">
                            @if($item->isonline==1)
                                <button type="button" class="layui-btn spreadBtn">推广</button>
                                <a type="button" class="layui-btn seeBtneditBtn" url="{{route('lucky-update',"id")}}">查看</a>
                            @else
                                <a type="button" class="layui-btn editBtn" url="{{route('lucky-update',"id")}}">编辑</a>
                                <button type="button" class="layui-btn deleteBtn"  url="{{route('lucky-delete','id')}}">删除</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach @endif
            </table>
        </form>

        <div class="pageWrap">@if($list['luckyList']!=null){{ $list['luckyList']->links() }} @endif</div>
    </div>
@endsection
@section('other')
    <!--推广弹窗-->
    <div class="downPop" style="display: none">
        <div class="popwarp">
            <p class="activename"></p>
            <div class="prizemsg" id="extensionStoreName"></div>
            <p class="erweimanotice">扫描下方二维码参与抽奖</p>
            <div class="prizepart">
                <div class="prizeinner clearfix">
                    <div class="priceitem fl"><img id="extensionPrize1" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize2" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize3" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize4" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize5" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize6"  src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize7" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize8" src="" class="itemimg"></div>
                    <div class="priceitem fl"><img id="extensionPrize9" src="" class="itemimg"></div>
                </div>
            </div>
            <img id="companyLogo" src="" class="poplog">
        </div>
        <img src="{{pix_asset('server/images/download.png')}}" class="downImg" title="点击下载图片">
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/activitylucky/lucky.js')}}"></script>
@endsection