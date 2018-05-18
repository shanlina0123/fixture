layui.use(['form', 'layer', 'jquery'], function() {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
    //进入添加页面
    $(".addBtn").click(function () {
       window.location.href=$(this).attr("url");
    });
    //进入添加页面
    $(".addBtn").click(function () {
        var that=this;
        window.location.href=getAttrUrl(that,"id");
    });
    //进入查看页面
    $(".editBtn").click(function () {
        var that=this;
        var rowStatus=$("#rowStatus", $(that).parents("tr")).attr("status");
        if(rowStatus==1)
        {
            window.location.href=getAttrUrl(that,"id");
        }else{
            layer.msg("角色已禁用，不能进行权限设置",{icon:2,time: 1000})
        }
    });
    //进入编辑页面
    $(".editBtn").click(function () {
        var that=this;
        var rowIsOnline=$("#rowIsOnline", $(that).parents("tr")).attr("isonline");
        if(rowIsOnline==1)
        {
            window.location.href=getAttrUrl(that,"id");
        }else{
            layer.msg("活动已上线，下线后可进行编辑",{icon:2,time: 1000})
        }
    });
    //进入查看页面
    $(".seeBtn").click(function () {
        var that=this;
        window.location.href=getAttrUrl(that,"id");
    });

    //删除活动
    $(".deleteBtn").click(function() {
        var me = $(this);
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function() {
            me.parents("tr").remove();
            layer.msg('删除成功', {
                icon: 1
            });
        });
    });
    //推广
    $(".spreadBtn").click(function() {
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            content: $(".downPop")
        })
    })
});