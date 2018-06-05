$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("form").keyup(function(event){
    if(event.keyCode ==13){
        $("#btn_submit").trigger("click");
    }
});
$(".form").Validform({
    btnSubmit:'#btn_submit',
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if(  o.type !=2 )
            {
                var objtip = o.obj.parents(".loginInner").find('.loginError');
                cssctl(objtip, o.type);
                objtip.text(msg);
            }else
            {
                var objtip = o.obj.parents(".loginInner").find('.loginError');
                cssctl(objtip, o.type);
                objtip.text('');
            }
        }
    }
});
var layer;
layui.use(['form','layer'], function() {
        form = layui.form;
        layer = layui.layer;
    //注册协议
    $(".registDeel > a").click(function() {
        layer.open({
            type: 1,
            title: '用户注册协议',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['700px', '600px'],
            content: $(".deal")
        })
    });
    //关闭注册协议
    $(".btnWrap button").click(function() {
        $("input[name=agree]").prop("checked",true);
        form.render('checkbox');
        layer.closeAll();
    })
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

//60秒倒计时
$(".msgUncode").click(function() {
    $me = $(this);
    $me.attr("disabled", true);
    var ret = /^1[34578][0-9]{9}$/;
    var phone = $("#phone").val();
    if(!ret.test(phone))
    {
        layer.msg('手机号码有误');
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