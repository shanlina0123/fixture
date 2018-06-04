var layer;
layui.use(['layer','form'], function() {
    layer = layui.layer;
    var form = layui.form;
    /**
     * 页面提示
     */
    var msg = $("#msg").val();
    if( msg )
    {
        layer.msg($("#msg").val());
    }
    var error = $("#error").val();
    if( error )
    {
        layer.msg($("#error").val());
    }
    //更换手机弹窗
    $(".changePhone").click(function() {
        layer.open({
            type: 1,
            title: '更换手机号码',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['600px', '400px'],
            content: $(".popWrap")
        })
    });
   //60秒倒计时
    $(".msgUncode").click(function() {
        $me = $(this);
        $me.attr("disabled", true);
        var ret = /^1[34578][0-9]{9}$/;
        var phone = $("#phone").val();
        if(!ret.test(phone))
        {
            layer.msg('手机号码有误');
            $("#phone").removeAttr("readonly");
            $me.removeAttr("disabled");
        }else
        {
            var url = $me.data('url');
            var type = $me.data('type');
            $.ajax({
                url:url,
                type:"PUT",
                data:{phone:phone,type:type},
                dataType:"json",
                success: function( data )
                {
                    if( data.status != 1 )
                    {
                        $me.removeAttr("disabled");
                        layer.msg(data.messages);
                    }else
                    {
                        time();
                        $("#phone").attr("readonly", true);
                        $("#phone").addClass('layui-disabled');
                    }
                }
            });
        }

    });

});

/**
 * 倒计时
 * @type {number}
 */
var wait = 10;
function time()
{
    if (wait == 0)
    {
        $me.removeAttr("disabled");
        $("#phone").attr("readonly", false);
        $me.text("获取短信验证码");
        $me.css({
            "background": "#009688",
            "border-color": "#009688"
        });
        wait = 10;
    }else
    {
        $me.attr("disabled", true);
        $me.text("重新发送(" + wait + ")");
        $me.css({
            "background": "#ccc",
            "border-color": "#ccc"
        });
        wait--;
        setTimeout(function(){time()}, 1000)
    }
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