layui.use(['element','layer','form'], function() {
    var element = layui.element;
    var layer = layui.layer;
    if( $("#registerMsg").val() )
    {
        layer.alert($("#registerMsg").val(),{icon: 1,title:'注册提示信息'});
    }
});



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$("form").keyup(function(event){
    if(event.keyCode ==13){
        var tosubid=$(this).attr("tosubid")
        $("#btn_submit"+tosubid).trigger("click");
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
        $me.text("重新获取");
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