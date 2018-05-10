
var layer;
layui.use(['form', 'layer'], function() {
    var form = layui.form;
    layer = layui.layer;
    /**
     * 页面提示
     */
    var msg = $("#msg").val();
    if( msg )
    {
        layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
    }
});

/**
 * 跟进弹窗
 */
$(".update-btn").click(function() {
    layer.open({
        type: 1,
        title: '跟进客户',
        shadeClose: true,
        scrollbar: false,
        skin: 'layui-layer-rim',
        area: ['650px', '500px'],
        content: $(".clientPop")
    })
});

/**
 * 删除
 * @param index
 */
function  del(index)
{
    var url = $(index).data('url');
    var that = $(index);
    layer.confirm('您确认要删除吗？', {
        icon: 3, title:'删除',
        btn: ['确认','取消'] //按钮
    }, function(){
        $.post(url,{_method:'DELETE'},function ( msg ) {
            if( msg == 'success' )
            {
                that.parents('tr').remove();
                layer.msg('删除成功。。。',{icon:1});
            }else
            {
                layer.msg('删除失败。。。', {icon: 5, time: 2000, shift: 6});
            }
        })
    });
}