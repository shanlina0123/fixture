layui.use(['form', 'layer', 'jquery'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
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
                    $(".spreadBtn", parent).hide();
                    $(".seeBtn", parent).hide();
                } else {
                    $(".editBtn", parent).hide();
                    $(".deleteBtn", parent).hide();
                    $(".spreadBtn", parent).show();
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
    //推广
    $(".spreadBtn").click(function () {
        var that=this;
        var url=$(that).attr("url");
        $.getJSON(url,null,doExtension);
    })


    //生成图
    $("#createExtension").click(function(){
         //绘图
          createPng();
    })

    //推广h5
    var doExtension=function (data) {
        var parent=$("#extensionContent");
        if(data.status===1){
            //其他页面元素
            var tourl=data.data.uploads+"/"+"default/lucky/prizewarpbg.png";
            var toitemurl=data.data.uploads+"/"+"default/lucky/prizebg.png";
            $("#prizewapbg",parent).css("background","url("+tourl+") center center / 100% no-repeat");
            $(".priceitem",parent).find("img").attr("src",toitemurl);
            //奖项
            $.each(data.data.prizeList,function(i,n){
                n["picture"]? $("#extensionPrize"+n["levelid"],parent).attr("src",n["picture"]):"";
            })
            //标题
            $("#sharetitle",parent).html(data.data.lukData.sharetitle);
            //门店
            $("#storename",parent).html(data.data.lukData.storename);
            //活动背景bgurl
            $("#bgurl",parent).css("background","url("+data.data.lukData.bgurl+") center top no-repeat");
            //公司logo
            if(data.data.logo)
            {
                $("#companyLogo",parent).attr("src",data.data.logo);
                $("#companyLogo",parent).show();
            }

            //二维码
            if(data.data.wxappcode)
            {
                $("#wxappcode",parent).attr("src",data.data.wxappcode);
                $("#wxappcode",parent).show();
            }
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                content: $("#extensionContent")
            })
        }else{
            layer.msg(data.messages, {icon: 2,time: 2000});
        }
    }


   var createPng=function(){
        var parent=$("#canvasContent");
       html2canvas($(".h5Content"), {
           onrendered: function(canvas) {
               //把截取到的图片替换到a标签的路径下载
               $("#downloadExtension").attr('href',canvas.toDataURL());
               //下载下来的图片名字
               $("#downloadExtension").attr('download',$("#sharetitle",parent).html()) ;
               $("#extensionContent").hide();
               parent.html(canvas);
               layer.open({
                   type: 1,
                   title: false,
                   closeBtn: 0,
                   shadeClose: true,
                   content: $("#extensionCanvas")
               })

           }
           //可以带上宽高截取你所需要的部分内容
           //     ,
           //     width: 300,
           //     height: 300
       });
   }


});