var upload, $;
layui.use(['form', 'layer', 'jquery', 'laydate', 'upload'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        laydate = layui.laydate,
        $ = layui.jquery;


    //列表错误信息
    var error = $("#errorMsg").attr("content");
    if (error) {
        layer.msg(error, {
            icon: 2
        });
    }
});


