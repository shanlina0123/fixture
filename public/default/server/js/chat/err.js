layui.use(['jquery', 'layer'], function () {
    var $ = layui.jquery,
        layer = layui.layer;
    //列表错误信息
    var error = $("#errorMsg").attr("content");
    if (error) {
        layer.msg(error, {
            icon: 2
        });
    }

})
;