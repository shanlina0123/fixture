layui.use(['form', 'layer', 'jquery'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        $ = layui.jquery;

    //列表错误信息
    var error=$("#errorMsg").attr("content");
    if(error!="")
    {
        layer.msg(error, {
            icon: 2
        });
        $(".roleAuthListDiv").hide();
    }else{
        $(".roleAuthListDiv").show();
    }


    //全选全不选功能
    layuiForm.on('checkbox(allChoose)', function(data) {
        var childCheck = $(data.elem).parents(".allPower").siblings(".subPower").find("input");
        childCheck.each(function(index, item) {
            item.checked = data.elem.checked;
        });
        layuiForm.render('checkbox');
    });

   //选择视野
    layuiForm.on('radio(isLookCheck)', function(data) {
        var islook=$(data.elem).val();
        var FuncCheck=$(data.elem).parents("li").find(".functionidSubmit");
        FuncCheck.each(function(index, item) {
            $(item).attr("tolook",islook);
        });
        layuiForm.render('radio');
    });

    //提交勾选权限
    $(".ajaxSubmit").click(function () {
        var postData=getPostData();
        $.ajaxSubmit($("form"),{"funcislook":postData},function(data){
            if(data.status===1){
                layer.msg(data.messages,{icon: 1,time: 1000});
            }else{
                layer.msg(data.messages, {icon: 2,time: 1000});
            }
        });
    });


    //整理勾选提交的数据
    var getPostData=function () {
        var postData=[];
        var strJson;
        var obj=$(".functionidSubmit");
        for(var i=0;i<obj.length;i++)
        {
            var funcid=$(obj[i]),islook=$(obj[i]).attr("tolook")*1;
            if(funcid.is(":checked")==true&&funcid.val())
            {
               var strJson={funcid:funcid.val(),islook:islook};
               postData.push(strJson);
            }
        }
        return postData;
    }




});