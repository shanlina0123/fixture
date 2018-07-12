/**
 * 页面鼠标样式
 */
layui.use(['element', 'layer',], function () {
    var element = layui.element,
    layer = layui.layer;
});

/**
 * 解决ajax CSRF
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * 获取数据ajax-get请求
 * @author laixm
 */
$.getJSON = function (url, data, callback) {
    $.ajax({
        url: url,
        type: "get",
        contentType: "application/json",
        dataType: "json",
        timeout: 10000,
        data: data,
        success: function (data) {
            //console.log(data);
            callback(data);
        }
    });
};




//获取当前url属性的实际url
var getAttrUrl = function (obj, key) {
    var that = $(obj);
    var key = key ? key : "uuid";
    //tr的数据
    var tr = that.parents("tr");
    var keyValue = $(tr).attr(key);
    //编辑url
    var url = that.attr("url").replace(key, keyValue);
    that.attr("url", url);
    return url;
}


//获取当前Form属性的实际url
var setAttrFormUrl = function (obj, form, key, action,muilteaction) {
    var that = $(obj);
    var key = key ? key : "uuid";
    var action = action ? action : "action";
    var muilteaction=muilteaction?muilteaction:action;
    //tr的数据
    var tr = $(that).parents("tr");
    var keyValue = $(tr).attr(key);
    //编辑url
    var url = form.attr(muilteaction).replace(key, keyValue);
    form.attr(action, url);
}


//获取当前Form属性的实际url
var setFormUrl = function (form, key) {
    var key = key ? key : "uuid";
    //tr的数据
    var keyValue = form.attr(key);
    //编辑url
    var url = form.attr("action").replace(key, keyValue);
    form.attr("action", url);
}

//设置将auto的actiont值重置后给action
var setAutoToFormUrl = function (form, key) {
    var key = key ? key : "uuid";
    //tr的数据
    var keyValue = form.attr(key);
    //编辑url
    var url = form.attr("autoActioin").replace(key, keyValue);
    form.attr("action", url);
}

/**
 * 分享弹窗
 */
$(".sharewrap").click(function() {
    layer.open({
        type: 1,
        closeBtn: 1,
        title: false, //不显示标题
        shadeClose: true,
        area:['auto','auto'],
        content: $('.sharepop'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
    });
});


//取消操作
$(".channelBtn").click(function(){
    layer.closeAll();
});

//点击菜单
$('.nav-menu').click(function () {
    $('#iframeMain').attr('src', $(this).attr("url"));
});

//iframe的title赋值给父类
window.parent.$("title").html($("title").html());

//F5
$("body").bind("keydown",function(event) {
    if (event.keyCode == 116) {
        event.preventDefault(); //阻止默认刷新
        $("#iframeMain").attr("src", window.frames["iframeMain"].src);

    }
});