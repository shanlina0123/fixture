/**
 * 页面鼠标样式
 */
layui.use(['element'], function() {
    var element = layui.element;
});

/**
 * 解决ajax CSRF
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
