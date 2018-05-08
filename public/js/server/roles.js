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
    //新增角色弹窗
    $(".addBtn").click(function() {
        layer.open({
            type: 1,
            title: '新增角色',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['600px', '300px'],
            content: $(".addWrap")
        })
    });
    //编辑角色弹窗
    $(".editBtn").click(function() {
        layer.open({
            type: 1,
            title: '编辑角色',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['600px', '300px'],
            content: $(".editWrap")
        })
    });
});