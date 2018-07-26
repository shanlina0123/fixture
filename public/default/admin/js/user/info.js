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


}

