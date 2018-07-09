layui.use(['form', 'layer', 'jquery'], function() {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
    //立即升级
    $(".addBtn").click(function() {
        var that=this;
        var url=$(that).attr("url");
        $.getJSON(url,"",function(data){
           if(data.status==1)
           {
               $(".centerBtnWrap").hide();
               $(".notice").html(data.messages);
               layer.open({
                   type: 1,
                   content: '<div style="padding: 10px; font-size:14px; ">'+data.messages+'</div>',
                   btn: '我知道了',
                   btnAlign: 'c',
                   shade: 0,
                   yes: function() {
                       layer.closeAll();
                   }
               });
           }else{
               layer.msg(data.messages);
           }
        })

    })
    if( $("#msg").val() )
    {
        layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
    }
});