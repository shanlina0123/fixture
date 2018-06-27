@extends('server.layout.content')
@section('title','项目管理')
@section('css')
@endsection
@section('content')
    <div class="main">
        <!--项目描述-->
        <div class="projectWrap">
            当前项目数：<span>{{$data->total()}}</span>/<span>2</span>
            <a href="{{route('vip-index')}}">升级为无限项目>></a>
        </div>
        <!--新增和筛选部分-->
        <div class="addBtnWrap">
            <a href="{{route('site.create')}}" class="layui-btn addBtn">新建项目</a>
            <div class="topSort layui-inline">
                <form class="layui-form " action="{{Request::url()}}" method="get">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">项目名称</label>
                        <div class="layui-input-inline">
                            <input name="name" type="text" class="layui-input" value="{{$where['name']}}">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">门店</label>
                        <div class="layui-input-inline">
                            <select name="storeid">
                                <option value="">全部</option>
                                @foreach( $data->store as $storeRow )
                                    <option value="{{$storeRow->id}}"
                                            @if( $where['storeid'] == $storeRow->id) selected @endif >{{$storeRow->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">公开</label>
                        <div class="layui-input-inline">
                            <select name="isopen">
                                <option value="" @if( $where['isopen'] == "") selected @endif>全部</option>
                                <option value="1" @if( $where['isopen'] == '1' ) selected @endif>是</option>
                                <option value="0" @if( $where['isopen'] == '0' ) selected @endif>否</option>
                            </select>
                        </div>
                    </div>
                    <button class="layui-btn searchBtn">查询</button>
                </form>
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>项目列表</legend>
        </fieldset>
        <!--列表数据部分-->
        <form class="layui-form">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>项目封面图</th>
                    <th>项目名称</th>
                    <th>阶段</th>
                    <th>门店</th>
                    <th>创建日期</th>
                    <th>最后更新时间</th>
                    <th>是否公开</th>
                    <th>操作</th>
                </tr>
                </thead>
                @foreach( $data as $k=>$row )
                    <tr id="{{$row->id}}" storename="{{$row->siteToCompany?$row->siteToCompany->fullname:''}}"
                        sitename="{{$row->name}}" {{--codeimg="{{$row->codeimg}}"--}}>
                        <td>{{$k+1}}</td>
                        <td><img src="{{getImgUrl($row->explodedossurl)}}"></td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->siteToCommpanyTag?$row->siteToCommpanyTag->name:''}}</td>
                        <td>{{$row->siteToStore?$row->siteToStore->name:''}}</td>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->updated_at}}</td>
                        <td><input type="checkbox" name="show" data-url="{{route('site-isopen')}}" value="{{$row->id}}"
                                   @if( $row->isfinish == 1) disabled @else @if($row->isopen == 1) checked
                                   @endif  lay-filter="isOpen" @endif lay-skin="switch" lay-text="是|否"></td>
                        <td>
                            <div class="layui-btn-group">
                                <button type="button" class="layui-btn publicBtn"
                                        @if($row->isopen==0)style="display: none;"
                                        @endif   url="{{route('site-extension',$row->id)}}">推广
                                </button>
                                <a class="layui-btn" href="{{route('site-renew',$row->uuid)}}"@if($row->isfinish==1)style="display: none;"@endif>更新</a>
                                <a class="layui-btn" href="{{route('dynamic-index',base64_encode($row->id))}}"@if($row->isfinish==1)style="display: none;"@endif>项目动态</a>
                                <a class="layui-btn" href="{{route('site.edit',$row->uuid)}}" @if($row->isfinish==1)style="display: none;"@endif>编辑</a>
                                <button type="button" class="layui-btn deleteBtn" onclick="del(this)" data-url="{{route('site.destroy',$row->uuid)}}">删除</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
        <div class="pageWrap">{{$data->appends($where)->links()}}</div>
    </div>
@endsection
@section('other')
    <!--推广弹窗-->
    <div class="publicpop" style="display: none" id="extensionContent">
        <div class="publicImgWrap">
         {{--   <div class="companyname" id="storename" sitename=""></div>--}}
            <div class="erweimaImg"><img id="wxappcode" src="" width="250" height="250" onerror="src='/default/server/images/falie.png'"></div>
        </div>
       {{-- <div class="publicImgWrap canvasContent" style="display: none" toid=""></div>--}}
        <div class="downWrap">
          {{--  <img src="{{pix_asset('server/images/cutscreen.png')}}" class="downImg" title="截屏生成图片" id="createExtension">--}}
            <a href="javascript:;" rel="external nofollow" id="downloadExtension">
                <img src="{{pix_asset('server/images/download.png')}}" class="downImg" title="点击下载图片">
            </a>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/plugins/html2canvas/0.4.1/html2canvas.js')}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/site/site.js')}}"></script>
@endsection
