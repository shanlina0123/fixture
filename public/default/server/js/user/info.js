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


    //初始化
    if(!$("form").attr("phone"))
    {
        if($(".userInfoPop").length>0)
        {
            layer.open({
                type: 1,
                title:"绑定手机",
                closeBtn: 1,
                shadeClose: true,
                scrollbar: false,
                skin: 'layui-layer-rim',
                area: ['600px', '400px'],
                content: $(".userInfoPop")
            })
        }

   }

    //更换手机弹窗
    $(".changePhone").click(function() {
        layer.open({
            type: 1,
            title: $(this).attr("title"),
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['600px', '400px'],
            content: $(".userInfoPop")
        })
    });
    //修改昵称
    $(".changeNickname").click(function(){
        layer.open({
            type: 1,
            title: '修改姓名',
            closeBtn: 1,
            shadeClose: false,
            area: ['600px', '350px'],
            content: $(".userNicknamePop")
        })
    })

    //二维码弹窗
    $(".binwx").click(function(){
        var url=$(this).attr("url");
        var checkUrl = $(this).attr('data-check');
        $.getJSON(url,null,function(data){
            if(data.status==1)
            {
                $(".erweima").html("<img src='"+data.data.wxappcode+"' style='width:100%'>");
                checkOpenid(checkUrl);
            }else
            {
                $(".erweima").html("<div class='erweimatext'>"+data.messages+"</div>");
            }

        })
        layer.open({
            type: 1,
            title: '绑定微信',
            closeBtn: 1,
            shadeClose: false,
            area: ['360px'],
            content: $(".erweimapop")
        })
    })

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
                        Countdown();
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

function Countdown()
{
    if (wait == 0)
    {
        $me.removeAttr("disabled");
        $("#phone").attr("readonly", false);
        $me.text("重新获取");
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
        setTimeout(function(){Countdown()}, 1000)
    }
}


/**
 * 电话号码提交表单验证
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

/**
 * 昵称修改表单验证
 */
$("#layui-nickname-form").Validform({
    btnSubmit: '#btn_nickname_submit',
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

/**
 * 检测openid
 */
var num=0;
function checkOpenid(url)
{
    var i = setInterval(function()
    {
        num++;
        $.get(url,function(data){
            if( data == 'success' )
            {
                clearInterval(i);
                window.location = location;
            }
        });
        if ( num > 90 )
        {
            clearInterval(i);
        }
    }, 3000);

}

