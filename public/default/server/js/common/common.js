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

//将form转为AJAX提交
function ajaxSubmit(frm,dataPara) {
    var url=$(frm).attr("action");
    $.ajax({
        url:$(frm).attr("action"),
        type:$(frm).attr("method"),
        data: dataPara,
        dataType:"json",
        success: function(data){
            if(data.status===1){
                layer.closeAll();
                layer.msg(data.messages,{icon: 1,time: 1000});
            }else if(data==='0'){
                layer.msg(data.messages, {icon: 2,time: 1000});
            }else{
                layer.msg("请求错误", {icon: 5,time: 1000});
            }
        }
    });
}
