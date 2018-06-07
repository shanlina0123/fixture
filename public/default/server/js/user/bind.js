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

    //二维码弹窗

    if(!$("form").attr("iswx") || !$("form").attr("phone"))
    {
        $(".otherShow").show();
        layer.open({
            type: 1,
            title: '绑定微信',
            closeBtn: 0,
            shadeClose: true,
            area: ['360px'],
            content: $(".erweimapop")
        })
    }else{
        if($("form").attr("phone")){
            $(".otherShow").hide();
            $("#phone").prop("readonly","readonly");
            $("#phone").removeClass("readonly").addClass("readonly");
            layer.open({
                type: 1,
                title: '绑定微信',
                closeBtn: 1,
                shadeClose: false,
                area: ['360px'],
                content: $(".erweimapop")
            })
        }
    }

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
var wait = 60;

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
        wait = 60;
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