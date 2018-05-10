@extends('server.layout.content')
@yield('css')
<link rel="stylesheet" href="{{pix_asset('server/css/common.css')}}">

<link rel="stylesheet" href="{{pix_asset('server/css/base.css')}}">
<link rel="stylesheet" href="{{pix_asset('server/css/style.css')}}">

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
                    @foreach($datas as $k=>$v)
                    <tr>
                        <td>{{$v->id}}</td>
                        <td>{{$v->name}}</td>
                        <td><?php foreach($v->shi as $kk=>$vv){foreach($vv->sheng as $kkk=>$vvv){echo $vvv->name;}} ?></td>
                        <td><?php foreach($v->shi as $kk=>$vv){echo $vv->name;} ?></td>
                        <td>
                            <div class="layui-btn-group">
                                <button type="button" id ='{{$v->id}}' class="layui-btn editBtn">编辑</button>
                                <button type="button" id ='{{$v->id}}' class="layui-btn deleteBtn">删除</button>
                            </div>
                        </td>
                    </tr>
                   @endforeach
                </table>
                <div class="pageWrap">{{ $datas->links() }}</div>
            </div>
        </div>
    </div>
    <!--新增门店弹窗-->
    <div class="addWrap popWrap">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">省</label>
                <div class="layui-input-inline">
                    <select name="sheng" lay-verify="required" lay-search="">
                      @foreach($sheng as $k=>$v)
                         <option value="{{$v->name}}">{{$v->name}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">市</label>
                <div class="layui-input-inline">
                    <select name="shi" lay-verify="required" lay-search="">
                      @foreach($city as $k=>$v)
                         <option value="{{$v->name}}">{{$v->name}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <input type="text" name="uname" lay-verify="title" autocomplete="off" placeholder="门店名称" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="address" lay-verify="title" autocomplete="off" placeholder="地址名称" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" id ='but' class="layui-btn loginButton">立即提交</button>
            </div>
        </form>
    </div>
    <!--编辑门店弹窗-->
    <div class="editWrap popWrap">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">省</label>
                <div class="layui-input-inline">
                    <select name="sheng" lay-verify="required" lay-search="">
                        @foreach($sheng as $k=>$v)
                         <option value="{{$v->name}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">市</label>
                <div class="layui-input-inline">
                    <select name="shi" lay-verify="required" lay-search="">
                        @foreach($city as $k=>$v)
                         <option value="{{$v->name}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <input type="text" name="uname" lay-verify="title" autocomplete="off" placeholder="门店名称" value="高新店" class="layui-input" id="bname">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">地址</label>
                <div class="layui-input-inline">
                    <input type="text" name="address" lay-verify="title" autocomplete="off" placeholder="地址名称" value="高新店" class="layui-input" id="baddress">
                </div>
            </div>
            <input type="hidden" name="bid" value="" id="bid">
            <div class="layui-form-item popSubmitBtn">
                <button type="button" id="bianji" class="layui-btn loginButton">立即提交</button>
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
            var id = $(this).attr("id");
            layer.confirm('确定要删除吗？', {
                btn: ['确定', '取消']
            }, function() {

                $.ajax({
                                url:'storedel',
                                type:'GET',
                                data:{
                                    "nameid":id
                                },
                                success:function(data){
                                    console.log(data);
                                     me.parents("tr").remove();
                                    layer.msg('删除成功', {
                                        icon: 1
                                    });

                                }
                            })
                
               
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
            var id = $(this).attr("id");
            
                      $.ajax({
                                url:'storeedit',
                                type:'GET',
                                data:{
                                    "nameid":id
                                },
                                success:function(data){
                                    
                                    var datas = JSON.parse(data);
                                    var datass = eval(datas);
                                    console.log(datass);
                                    $("#bname").val(datass.name);
                                    $("#baddress").val(datass.addr);
                                    $("#bid").val(datass.id);
                                }
                            })
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


        //添加门店
        $("#but").click(function(){
                  $.ajax({
                        type: 'get',
                        url: 'storeadd',
                        data: $("form").serialize(),
                        success: function(data) {
                            console.log(data);
                            if (data == 1){
                                alert('添加成功');
                                layer.closeAll();
                            };
                        }
                    });
        });

        //编辑门店
        $("#bianji").click(function(){
            var id = $(this).attr("id");
            $.ajax({
                        type: 'get',
                        url: 'storeedits',
                        data: $("form").serialize(),
                        success: function(data) {
                            console.log(data);
                            if (data == 1){
                                alert('添加成功');
                                layer.closeAll();
                            };
                        }
                    });

        });
    });
</script>
@stop
