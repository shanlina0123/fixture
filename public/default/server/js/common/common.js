/**
 * 页面鼠标样式
 */
layui.use(['element'], function () {
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

/**
 * 提交json数据的post请求
 * @author laixm
 */
$.postJSON = function (url, data, callback) {
    $.ajax({
        url: url,
        type: "post",
        contentType: "application/json",
        dataType: "json",
        data: JSON.stringify(data),
        timeout: 60000,
        success: function (msg) {
            callback(msg);
        },
        error: function (xhr, textstatus, thrown) {

        }
    });
};

/**
 * 修改数据的ajax-put请求
 * @author laixm
 */
$.putJSON = function (url, data, callback) {
    $.ajax({
        url: url,
        type: "put",
        contentType: "application/json",
        dataType: "json",
        data: data ? JSON.stringify(data) : "",
        timeout: 20000,
        success: function (msg) {
            callback(msg);
        },
        error: function (xhr, textstatus, thrown) {

        }
    });
};
/**
 * 删除数据的ajax-delete请求
 * @author laixm
 */
$.deleteJSON = function (url, dataPara, callback) {
    var dataParam = isString(dataPara) ? dataPara : JSON.stringify(dataPara);
    $.ajax({
        url: url,
        type: "delete",
        data: dataParam,
        contentType: "application/json",
        dataType: "json",
        success: function (msg) {
            callback(msg);
        },
        error: function (xhr, textstatus, thrown) {

        }
    });
};

//将form转为AJAX提交
$.ajaxSubmit = function (frm, dataPara, callback) {
    var url = $(frm).attr("action");
    var dataParam = isString(dataPara) ? dataPara : JSON.stringify(dataPara);
    $.ajax({
        url: $(frm).attr("action"),
        type: $(frm).attr("method"),
        data: dataParam,
        dataType: "json",
        contentType: "application/json",
        success: function (data) {
            callback(data);
        },
        error: function (xhr, textstatus, thrown) {
            layer.msg("系统错误", {icon: 2, time: 1000});
        }
    });
}




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

//判断对象是否是字符串
function isString(obj) {
    return Object.prototype.toString.call(obj) === "[object String]";
}

/**
 * 渲染菜单展开
 */
if( $(".layui-nav-tree").find(".layui-this").length )
{
    var parentLi = $(".layui-nav-tree").find(".layui-this").parents('.layui-nav-item');
    if( parentLi.length )
    {
        parentLi.addClass('layui-nav-itemed');
    }
}

// 验证重复元素，有重复返回true；否则返回false
function checkArrRepeat(a)
{
    return /(\x0f[^\x0f]+)\x0f[\s\S]*\1/.test("\x0f"+a.join("\x0f\x0f") +"\x0f");
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