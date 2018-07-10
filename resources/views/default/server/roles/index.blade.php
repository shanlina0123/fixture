@extends('server.layout.content')
@section("title")角色管理@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>角色列表</legend>
        </fieldset>
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <!--新增和筛选部分-->
        <div class="addBtnWrap">
            <button type="button" class="layui-btn addBtn">新增角色</button>
        </div>
        <!--列表数据部分-->
        <form class="layui-form" action="{{route('roles-index')}}" method="get" id="listForm">
            <table class="layui-table" id="listTable">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>角色名称</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($list!=null) @foreach($list as $index=>$item)
                    <tr class="listRow" uuid="{{$item->uuid}}" roleid="{{$item->id}}">
                        <td>{{$index+1}}</td>
                        <td id="rowName">{{$item->name}}</td>
                        <td id="rowStatus" status="{{$item->status}}">
                        @if($item->isdefault==1)
                            默认
                        @else
                            @if($item->status==1)
                               <input type="checkbox"  name="status" lay-skin="switch" lay-text="ON|OFF" checked="checked" lay-filter="rowStatus" url="{{route('roles-setting','uuid')}}">
                            @else
                               <input type="checkbox" name="status" lay-skin="switch" lay-text="ON|OFF" lay-filter="rowStatus" url="{{route('roles-setting','uuid')}}">
                            @endif
                        @endif
                       </td>
                        <td>
                            @if($item->isdefault==1)
                                默认
                             @else
                                <div class="layui-btn-group">
                                    <a type="button" class="layui-btn editBtn">编辑</a>
                                    <a class="layui-btn authBtn" url="{{route('roles-auth','roleid')}}" >权限设置</a>
                                    <a type="button" class="layui-btn deleteBtn" url="{{route('roles-delete','uuid')}}">删除</a>
                                </div>
                             @endif
                        </td>
                    </tr>
                   @endforeach @endif
            </table>
        </form>
        <div class="pageWrap">@if($list!=null){{ $list->links() }} @endif</div>
    </div>
@endsection
@section('other')
    <!--新增角色弹窗-->
    <div class="addWrap popWrap">
        <form class="layui-form"  id="addForm"  action="{{route('roles-store')}}" method="post" >
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="name">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit" id="add-btn">立即提交</button>
                <button type="button" class="layui-btn  channelBtn" >取消</button>
            </div>
        </form>
    </div>
    <!--编辑角色弹窗-->
    <div class="editWrap popWrap">
        <form class="layui-form" id="editForm"  action="{{route('roles-update','uuid')}}" method="put">
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="" id="name">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit" id="edit-btn">立即提交</button>
                <button type="button" class="layui-btn  channelBtn" >取消</button>
            </div>
        </form>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/roles/roles.js')}}"></script>
@endsection