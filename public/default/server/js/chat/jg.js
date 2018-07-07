//开启debug
JIM = new JMessage({
    debug: true
});
//异常断线监听
JIM.onDisconnect(function () {
    //console.log("【disconnect】");
});
//初始化极光
init();

///////////////////////////////////极光操作区域//////////////////////////////////

//追加显示
function appendToDashboard(text) {
    console.log('isConnect:' + text);
}

//初始化
function init() {
    JIM.init({
        "appkey": $("#appkey").val(),
        "random_str": $("#random_str").val(),
        "signature": $("#signature").val(),
        "timestamp": $("#timestamp").val(),
        "flag": $("#flag").val(),

    }).onSuccess(function (data) {
        //登录极光
        if (isLogin() == false) {
            login();
        }
        appendToDashboard('初始化 success' + JSON.stringify(data));
    }).onFail(function (data) {
        appendToDashboard('初始化 error: ' + JSON.stringify(data));
    });
}

//获取连接状态
function isConnect() {
    appendToDashboard('isConnect : ' + JIM.isConnect());
    return JIM.isConnect();
}

//获取初始化状态
function isInit() {
    appendToDashboard('isInit : ' + JIM.isInit());
    return JIM.isInit();
}

//获取登录状态
function isLogin() {
    appendToDashboard('isLogin : ' + JIM.isLogin());
    return JIM.isLogin();
}

//登录
function login() {
    JIM.login({
        'username': $("#username").val(),
        'password': $("#password").val()
    }).onSuccess(function (data) {
        appendToDashboard('登录 sucess:' + JSON.stringify(data));
        JIM.onMsgReceive(function (data) {
            data = JSON.stringify(data);
            appendToDashboard('msg_receive:' + JSON.stringify(data));
            $("title").html("云易装 - 您有新消息");
            getReceiveMessageList(JSON.parse(data));

        });

        JIM.onEventNotification(function (data) {
            appendToDashboard('event_receive: ' + JSON.stringify(data));
            alert("onEventNotification")
        });

        JIM.onSyncConversation(function (data) { //离线消息同步监听
            appendToDashboard('event_receive离线消息: ' + JSON.stringify(data));
            $("title").html("云易装 - 您有离线消息");
            getSyncMessageList(JSON.parse(data));
        });

        JIM.onUserInfUpdate(function (data) {
            appendToDashboard('onUserInfUpdate : ' + JSON.stringify(data));
            alert("onUserInfUpdate");
        });

        JIM.onSyncEvent(function (data) {
            appendToDashboard('onSyncEvent : ' + JSON.stringify(data));
            alert("onSyncEvent");
        });

        JIM.onMsgReceiptChange(function (data) {
            appendToDashboard('onMsgReceiptChange : ' + JSON.stringify(data));
            alert("onMsgReceiptChange");
        });

        JIM.onSyncMsgReceipt(function (data) {
            appendToDashboard('onSyncMsgReceipt : ' + JSON.stringify(data));
            alert("onSyncMsgReceipt");
        });

        JIM.onMutiUnreadMsgUpdate(function (data) {
            appendToDashboard('onConversationUpdate : ' + JSON.stringify(data));
            alert("onMutiUnreadMsgUpdate");
        });

        JIM.onTransMsgRec(function (data) {
            appendToDashboard('onTransMsgRec : ' + JSON.stringify(data));
            alert("onTransMsgRec");
        });

        JIM.onRoomMsg(function (data) {
            appendToDashboard('onRoomMsg  : ' + JSON.stringify(data));
            alert("onRoomMsg");
        });
    }).onFail(function (data) {
        appendToDashboard('error: ' + JSON.stringify(data));
    }).onTimeout(function (data) {
        appendToDashboard('timeout: ' + JSON.stringify(data));
    });
}

//获取会话列表
function getConversation() {
    JIM.getConversation().onSuccess(function (data) {
        appendToDashboard('success: ' + JSON.stringify(data));
    }).onFail(function (data) {
        appendToDashboard('error: ' + JSON.stringify(data));
    });
}

//发送单聊消息
function sendSingleMsg(target_username,content,reply,that) {
    JIM.sendSingleMsg({
        'target_username': target_username,
        'content':content,
        'need_receipt': true,
        'extras':{faceimg:$("header img").attr("src")}
    }).onSuccess(function (data, msg) {
        appendToDashboard('发消息 success data: ' + JSON.stringify(data));
        appendToDashboard('发消息 success msg: ' + JSON.stringify(msg));
        //是否重复发送
        if(reply)
        {
             $(that).remove();
        }else{
            //显示发送的消息
            showSendMessage(content,true);
            //滚动
            $(".m-message").scrollTop($(".m-message")[0].scrollHeight);
        }

    }).onFail(function (data) {
        appendToDashboard('发消息 error: ' + JSON.stringify(data));

        //是否重复发送
        if(reply)
        {
            $(that).hide();
            $(that).show();
        }else{
            //显示发送的消息
            showSendMessage(content,false);

            //滚动
            $(".m-message").scrollTop($(".m-message")[0].scrollHeight);
        }

    });
}

//显示已发送到消息
function showSendMessage(content,flag)
{
    var userImg=$("header img").attr("src");
    var err="";
    if(!flag)
    {
        //消息未发送成功提示
        var textheight = $(".m-message li:last").find(".text").height()/20;
        err= "<img src='"+$("#sendfail-img").val()+"' width='20' height='20' class='undsendimage' onclick='undsendimage(this)'  style='margin-top:"+(-textheight) + "px;margin-right: 4px;"+"'>";
    }
    //显示发送的消息
    $(".m-message ul").append(" <" +
        "li class = 'clearfix' >" +
        "<p class = 'time' > " +
        "<span> "+clientCurrentTime()+" " +
        "</span></p >" +
        "<div class = 'self' >" +
        "<img class = 'avatar' width = '30' height = '30'src ='" + userImg + "'>" + err+
        "<div class = 'text' >" + content +
        " </div> </div> </li>");
    //清空输入框
    $(".insearwrap textarea").val("");
}

//重新发送
function undsendimage(obj){
    var div=$(obj).parent(".self");
    var target_username=$("#username").val();
    var textareatext=$(".text",div).html();
    sendSingleMsg(target_username,textareatext,true,obj);
}


//获取消息列表回调(新消息)
function getReceiveMessageList(data)
{
    if (data.messages.length>0) {
        var htmlData = "";
        if (data.messages.length > 0) {
            $.each(data.messages, function (i, n) {
                var faceimg=n.content.msg_body.extras.faceimg;
                var classposition=""
                if(typeof(n.content.msg_body.extras)!="undefined")
                {
                    faceimg=n.content.msg_body.extras.faceimg;
                }
                htmlData += '<li class=\"clearfix\">\r\n' +
                    '<p class=\"time\"><span>' + timestampToTime(n.ctime_ms) + '</span></p>\r\n' +
                    '<div class=\"' + classposition + '\">\r\n' +
                    '<img class=\"avatar\" width=\"30\" height=\"30\" src=\"' + faceimg + '\">\r\n' +
                    '<div class=\"text\">'+n.content.msg_body.text,
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
        $("#m-message-ul").append(htmlData);
        //滚动
        $(".m-message").scrollTop($(".m-message")[0].scrollHeight);

    } else {
        var htmlData = "";
        $("#m-message-ul").html(htmlData);
    }
}



//获取消息列表回调(离线消息)
function getSyncMessageList(data)
{
    if (data.msgs.length>0) {
        var htmlData = "";
        if (data.msgs.length > 0) {
            $.each(data.msgs, function (i, n) {
                var faceimg=n.content.msg_body.extras.faceimg;
                var classposition=""
                if(typeof(n.content.msg_body.extras)!="undefined")
                {
                    faceimg=n.content.msg_body.extras.faceimg;
                }
                htmlData += '<li class=\"clearfix\">\r\n' +
                    '<p class=\"time\"><span>' + timestampToTime(n.ctime_ms) + '</span></p>\r\n' +
                    '<div class=\"' + classposition + '\">\r\n' +
                    '<img class=\"avatar\" width=\"30\" height=\"30\" src=\"' + faceimg + '\">\r\n' +
                    '<div class=\"text\">'+n.content.msg_body.text,
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
        $("#m-message-ul").append(htmlData);
        //滚动
        $(".m-message").scrollTop($(".m-message")[0].scrollHeight);

    } else {
        var htmlData = "";
        $("#m-message-ul").html(htmlData);
    }
}