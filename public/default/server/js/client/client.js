
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
    $("#list").empty();
    var url = $(this).data('url');
    var form = $(this).data('form');
    $("#layui-form").attr('action', form);
    $.get(url,function ( data ) {
        //console.log( data.data );
        if( data.status == 1 )
        {
            var str = '<h2 class="logText">跟进日志</h2> <ul class="logUl">';
            var follow = data.data.client_to_client_follow;
            for( var i=0; i<follow.length; i++ )
            {
                var status ='';
                if( follow[i].client_follow_to_status )
                {
                    status = follow[i].client_follow_to_status.name;
                }
                str+='<li><div>客户状态：<span>'+status+'</span></div><p class="backMsg">'+follow[i].remarks+'</p><div class="clearfix"><span class="fl">跟进人：'+(follow[i].follow_username?follow[i].follow_username:"")+'</span><span class="fr">跟进时间：'+follow[i].created_at+'</span></div></li>'
            }
            str+='</ul>';
            $("#list").append(str);
        }

    },'json');
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
                layer.msg('删除成功',{icon:1});
            }else
            {
                layer.msg('删除失败', {icon: 5, time: 2000, shift: 6});
            }
        })
    });
}


/**
 * 表单验证
 */
$("#layui-form").Validform({
    btnSubmit: '#btn_submit',
    tiptype: 1,
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl) {
        if (!o.obj.is("form")) {
            if (o.type != 2)
            {
                layer.msg(msg, {icon: 5, time: 2000, shift: 6});
            }
        }
    }
});