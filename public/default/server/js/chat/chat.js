layui.use(['jquery', 'layer'], function () {
    var $ = layui.jquery,
        layer = layui.layer;
    document.oncontextmenu = function (e) {
        e.preventDefault();
    };

    //模糊搜索
    $(".m-card .search").bind("input propertychange",
        function () {
            var queryStr = $.trim($(this).val());
            if (queryStr === '') {
                $(".m-list ul li").show();
            } else {
                $(".m-list ul li").hide().find(".name").filter(":contains('" + queryStr + "')").parent("li").show();
            }
        });
    //聊天列表操作
    $(".m-list li").mousedown(function (e) {
        if (3 == e.which) {
            //右键
            $(this).find(".deleteli").css("display", "block");
            $(this).siblings().find(".deleteli").css("display", "none");
            var xx = e.pageX - $(this).offset().left;
            var yy = e.pageY - $(this).offset().top;
            $(this).find(".deleteli").css("top", yy).css("left", xx);
        } else if (1 == e.which && (!$(e.target).is(".deleteli"))) {
            $(".unread",this).remove();
            //左键
            $(this).addClass("active").siblings().removeClass("active");
            $(".main").removeClass("nomsg");
            $(".hasmeg").removeClass("hide");
            $(".mainuser span").text($(this).find(".name").text());
            $(this).find(".deleteli").css("display", "none");
            $(this).addClass("active").siblings().find(".deleteli").css("display", "none");
            //数据请求
            var url = $("#chat-message").val()
            var jguser = $(this).attr("jguser");
            var that=this;
            $.postJSON(url, {jguser: jguser},getMessageList);
        }
    })


    //获取消息列表回调
    function getMessageList(data)
    {
            if (data.status == 1) {
                var htmlData = "";
                if (data.data.count > 0) {
                    $.each(data.data.messages, function (i, n) {
                        var faceimg=$("#default-faceimg").val();
                        var classposition=""
                        if(typeof(n.msg_body.extras)!="undefined")
                        {
                            faceimg=n.msg_body.extras.faceimg;
                        }
                        if(n.from_id == $("#username").val())
                        {
                            classposition="self";
                        }
                        htmlData += '<li class=\"clearfix\">\r\n' +
                            '<p class=\"time\"><span>' + timestampToTime(n.create_time) + '</span></p>\r\n' +
                            '<div class=\"' + classposition + '\">\r\n' +
                            '<img class=\"avatar\" width=\"30\" height=\"30\" src=\"' + faceimg + '\">\r\n' +
                            '<div class=\"text\">'+n.msg_body.text,
                        '<!-- <div class=\"textright hide\">\r\n' +
                        '<a href=\"javascript:;\">复制</a>\r\n' +
                        '<a href=\"javascript:;\">撤回</a>\r\n' +
                        '<a href=\"javascript:;\">删除</a>\r\n' +
                        '</div> -->\r\n' +
                        '</div>\r\n' +
                        '</div>\r\n' +
                        '</li>\r\n';
                    });
                } else {
                    htmlData = '<li class=\"clearfix\"></li>';
                }
                $("#m-message-ul").html(htmlData);
                //滚动
                $(".m-message").scrollTop($(".m-message")[0].scrollHeight);

            } else {
                var htmlData = "";
                $("#m-message-ul").html(htmlData);
            }
        }



    //发送消息
    $(".sendbtnwrap button").click(function () {
        var textareatext = $(".insearwrap textarea").val();
        var target_username=$(".active",$(".m-list")).attr("jguser");
        if (textareatext == "") {
            $(this).siblings(".notice").removeClass("hide").delay(3000).hide(300);
        } else {
            sendSingleMsg(target_username,textareatext,false,"");
        }
    })
    //回车发消息
    $("body").keyup(function (e) {

        var textareatext = $(".insearwrap textarea").val();
        var target_username=$(".active",$(".m-list")).attr("jguser");
        if (e.shiftKey == 1 && e.keyCode == 13) {
            if (e.keyCode == 13) {
                textareatext += "\r\n";
                //console.log(textareatext);
            }
            e.preventDefault();
        } else if (e.keyCode == 13) {
            $(".insearwrap textarea").blur();
            sendSingleMsg(target_username,textareatext,false,"");

        }

    })



    // //删除左侧用户
    // $(".deleteli").click(function () {
    //     $(this).parent("li").remove();
    // })
    // 底部输入域的颜色变化
    // $(".insearwrap textarea").focus(function () {
    //     $(this).addClass("whitebg");
    //     $(".bottom").addClass("whitebg");
    // })
    // $(".insearwrap textarea").blur(function () {
    //     $(this).removeClass("whitebg");
    //     $(".bottom").removeClass("whitebg");
    // })
    // 对已发送的消息操作
    // $(".m-message .text").mousedown(function (e) {
    //     if (3 == e.which) {
    //         $(this).find(".textright").removeClass("hide");
    //     } else if (1 == e.which && (!$(e.target).is(".textright a"))) {
    //         $(this).find(".textright").addClass("hide");
    //     }
    // })

})
;