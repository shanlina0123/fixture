layui.use(['form', 'layer', 'jquery'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        $ = layui.jquery;


    //列表错误信息
    var error = $("#errorMsg").attr("content");
    if (error) {
        layer.msg(error, {
            icon: 2
        });
    }

    //进入添加页面
    $(".addBtn").click(function () {
        window.location.href = $(this).attr("url");
    });
    //进入添加页面
    $(".addBtn").click(function () {
        var that = this;
        window.location.href = getAttrUrl(that, "id");
    });
    //进入编辑页面
    $(".editBtn").click(function () {
        var that = this;
        var rowIsOnline = $("#rowIsOnline", $(that).parents("tr")).attr("isonline");
        if (rowIsOnline == 0) {
            window.location.href = $(that).attr("url");
        } else {
            layer.msg("活动已上线，下线后可进行编辑", {icon: 2, time: 1000})
        }
    });
    //进入查看页面
    $(".seeBtn").click(function () {
        var that = this;
        window.location.href = $(that).attr("url");
    });

    //上线/下线
    layuiForm.on('switch(rowIsOnline)', function (data) {
        var that = data.elem;
        var dt=data;
        var msg="确定该操作？"
        if(that.value==0){
            //之前是0，现在是点击了上线
            msg="上线后不可再编辑，是否确定此操作？";
        }else if(that.value==1){
            //之前是1，现在是点击了下线
            msg="下线后任何终端不能使用该活动，是否确定此操作？";
        }
        layer.confirm(msg, {
            btn: ['确定', '取消']
        }, function () {
            layer.closeAll();
            setting(that);
        },function(){
            if(that.value==1)
            {
                $(that).val(that.value);
                $(that).removeAttr("checked").attr("checked");
                $(that).siblings(".layui-unselect").removeClass("layui-form-onswitch").addClass("layui-form-onswitch");
                $(that).siblings(".layui-unselect").find("em").html("ON");
            }else{
                $(that).val(that.value);
                $(that).removeAttr("checked");
                $(that).siblings(".layui-unselect").removeClass("layui-form-onswitch");
            }

            layuiForm.render('radio');
        });
    });

    //执行上线/下线
    var  setting=function(that){
        var url = getAttrUrl(that, "id");
        var parent=$(that).parents("tr");
        $.putJSON(url, null, function (data) {
            if (data.status == 1) {
                $(that).val(data.data.isonline);
                $("#rowIsOnline", parent).attr("isonline", data.data.isonline);
                if (data.data.isonline == 0) {
                    $(".editBtn", parent).show();
                    $(".deleteBtn", parent).show();
                    $(".seeBtn", parent).hide();
                } else {
                    $(".editBtn", parent).hide();
                    $(".deleteBtn", parent).hide();
                    $(".seeBtn", parent).show();
                }
                layuiForm.render('radio');
            }
        });
    }
    //删除活动
    $(".deleteBtn").click(function () {
        var me = $(this);
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function () {
            $.deleteJSON(me.attr("url"),null,function(data){
                me.parents("tr").remove();
                layer.msg('删除成功', {icon: 1});
            });
        });
    });



});