layui.use(['element','layer'], function() {
   var element = layui.element;
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".form1").Validform({
    btnSubmit:'#btn_submit1',
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if(  o.type !=2 )
            {
                var objtip = o.obj.parents(".layui-tab").find('.loginError');
                cssctl(objtip, o.type);
                objtip.text(msg);
            }else
            {
                var objtip = o.obj.parents(".layui-tab").find('.loginError');
                cssctl(objtip, o.type);
                objtip.text('');
            }
        }
    }
});

$(".form2").Validform({
    btnSubmit:'#btn_submit2',
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if( o.type != 2 )
            {
                var objtip = o.obj.parents('.p-input').find(".Validform_checktip");
                objtip.removeClass('hide');
                objtip.addClass('show');
                cssctl(objtip, o.type);
                objtip.find('span').text(msg);
            }else
            {
                var objtip = o.obj.parents('.p-input').find(".Validform_checktip");
                objtip.removeClass('show');
                objtip.addClass('hide');
            }
        }
    }
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
        $me.text("获取短信验证码");
        $me.css({
            "background": "#19aa4b",
            "border-color": "#19aa4b"
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
    var ret = /^1[34578][0-9]{9}$/;
    var phone = $("#phone").val();
    if(!ret.test(phone))
    {
        layer.msg('手机号码有误');
        return;
    }
    time()
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
                $me.text("获取短信验证码");
                $me.css({
                    "background": "#19aa4b",
                    "border-color": "#19aa4b"
                });
                wait = 0;
                layer.msg(data.messages);
            }else
            {
                $("#phone").attr("readonly", true);
                $("#phone").addClass('layui-disabled');
            }
        }
    });
});

