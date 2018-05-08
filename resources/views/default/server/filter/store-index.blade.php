@extends('server.layout.content')

<link rel="stylesheet" href="{{pix_asset('server/css/normalize.css')}}">
<link rel="stylesheet" href="{{pix_asset('server/css/common.css')}}">
@yield('css')
<link rel="stylesheet" href="{{pix_asset('server/css/base.css')}}">
<link rel="stylesheet" href="{{pix_asset('server/css/style.css')}}">
<script src="{{pix_asset('server/js/common/modernizr-2.6.2.min.js')}}"></script>

@section('content')

    <div class="layui-body">
            <div class="main">
                <div class="addBtnWrap">
                    <button type="button" class="layui-btn addBtn">新增门店</button>
                    <div class="topSort layui-inline">
                        <form class="layui-form " action="">
                            <label class="layui-form-label" style="font-size: 14px;">门店筛选</label>
                            <div class="layui-input-inline">
                                <select name="modules" lay-verify="required" lay-search="">
                                <option value="">全部</option>
                                <option value="1">高新店</option>
                                <option value="2">曲江店</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="layui-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>门店</th>
                            <th>省</th>
                            <th>市</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>1</td>
                        <td>西安未央店</td>
                        <td>陕西</td>
                        <td>西安</td>
                        <td>
                            <div class="layui-btn-group">
                                <button type="button" class="layui-btn editBtn">编辑</button>
                                <button type="button" class="layui-btn deleteBtn">删除</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>西安高新店</td>
                        <td>陕西</td>
                        <td>西安</td>
                        <td>
                            <div class="layui-btn-group">
                                <button type="button" class="layui-btn editBtn">编辑</button>
                                <button type="button" class="layui-btn deleteBtn">删除</button>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="pageWrap">这里是分页</div>
            </div>
        </div>
    </div>
    <!--新增门店弹窗-->
    <div class="addWrap popWrap">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">省</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="">
                        <option value="">全部</option>
                        <option value="1">有效</option>
                        <option value="2">无效</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">市</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="">
                        <option value="">全部</option>
                        <option value="1">有效</option>
                        <option value="2">无效</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <input type="text" name="uphone" lay-verify="title" autocomplete="off" placeholder="门店名称" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn loginButton">立即提交</button>
            </div>
        </form>
    </div>
    <!--编辑门店弹窗-->
    <div class="editWrap popWrap">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">省</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="">
                        <option value="">陕西省</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">市</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="">
                        <option value="">西安市</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <input type="text" name="uphone" lay-verify="title" autocomplete="off" placeholder="门店名称" value="高新店" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn loginButton">立即提交</button>
            </div>
        </form>
    </div>
</body>
@endsection
@section('js')
<script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/common/common.js')}}"></script>

<script>
    layui.use(['form', 'layer', 'jquery'], function() {
        var form = layui.form,
            layer = layui.layer,
            $ = layui.jquery;
        //删除门店
        $(".deleteBtn").click(function() {
            var me = $(this);
            layer.confirm('确定要删除吗？', {
                btn: ['确定', '取消']
            }, function() {
                me.parents("tr").remove();
                layer.msg('删除成功', {
                    icon: 1
                });
            });
        });
        //新增门店弹窗
        $(".addBtn").click(function() {
            layer.open({
                type: 1,
                title: '新增门店',
                shadeClose: true,
                scrollbar: false,
                skin: 'layui-layer-rim',
                area: ['600px', '400px'],
                content: $(".addWrap")
            })
        });
        //编辑门店弹窗
        $(".editBtn").click(function() {
            layer.open({
                type: 1,
                title: '编辑门店',
                shadeClose: true,
                scrollbar: false,
                skin: 'layui-layer-rim',
                area: ['600px', '400px'],
                content: $(".editWrap")
            })
        });
    });
</script>
@stop
