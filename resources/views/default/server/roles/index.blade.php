@extends('server.layout.content')
@section("title")角色管理@endsection
@section('content')
    <div class="main">
        <!--新增和筛选部分-->
        <div class="addBtnWrap">
            <button type="button" class="layui-btn addBtn">新增角色</button>
        </div>
        <!--列表数据部分-->
        <form class="layui-form">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>角色名称</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                @foreach($list as $index=>$item)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$item->name}}</td>
                        <td><input type="checkbox" name="status" lay-skin="switch" lay-text="ON|OFF" ></td>
                        <td>
                            @if($item->isdeafult==1)
                                默认
                             @else
                                <div class="layui-btn-group">
                                    <button type="button" class="layui-btn editBtn">编辑</button>
                                    <a href="editRole.html" class="layui-btn">权限设置</a>
                                    <button type="button" class="layui-btn deleteBtn">删除</button>
                                </div>
                             @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
        <div class="pageWrap">{{ $list->links() }}</div>
    </div>
@endsection
@section('other')
    <!--新增门店弹窗-->
    <div class="addWrap popWrap">
        <form class="layui-form" action="{{route('roles-store')}}" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="name">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit">立即提交</button>
            </div>
        </form>
    </div>
    <!--编辑门店弹窗-->
    <div class="editWrap popWrap" action="{{route('roles-update')}}" method="put">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">角色名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="门店管理员">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit">立即提交</button>
            </div>
        </form>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/roles/roles.js')}}"></script>
@endsection