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

layui.use(['form'], function() {
        form = layui.form;
    //60秒倒计时
    $(".msgUncode").click(function() {
        $me = $(this);
        time()
    });

})

//60秒倒计时
var wait = 60;
function time() {
    if (wait == 0) {
        $me.removeAttr("disabled");
        $me.text("获取短信验证码");
        $me.css({
            "background": "#19aa4b",
            "border-color": "#19aa4b"
        });
        wait = 60;
    } else {
        $me.attr("disabled", true);
        $me.text("重新发送(" + wait + ")");
        $me.css({
            "background": "#ccc",
            "border-color": "#ccc"
        });
        wait--;
        setTimeout(function() {
                time()
            },
            1000)
    }
};