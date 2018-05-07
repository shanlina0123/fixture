$(window).one("resize",function(){
    $(".update-btn").click(function(){
        var url = $(this).data('url');
        var index = layui.layer.open({
            title : "编辑",
            type : 2,
            content: url,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
    })
}).resize();

/**
 * 页面提示
 */
var msg = $("#msg").val();
if( msg )
{
    layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
}


/**
 * 删除
 * @param index
 */
function  del(index)
{
    var url = $(index).data('url');
    layer.confirm('您确认要删除吗？', {
        icon: 3, title:'删除',
        btn: ['确认','取消'] //按钮
    }, function(){
        $.post(url,{_method:'DELETE'},function ( msg ) {
            if( msg == 'success' )
            {
                layer.msg('删除成功。。。',{icon:1},function () {
                    location.href = location;
                });
            }else
            {
                layer.msg('删除失败。。。', {icon: 5, time: 2000, shift: 6});
            }
        })
    });
}