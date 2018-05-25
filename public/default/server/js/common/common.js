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


//正整数
$("input[type=number]").keyup(function () {
    $(this).val($(this).val().replace(/[^1-9]/g, ''));
}).bind("paste", function () {  //CTR+V事件处理
    $(this).val($(this).val().replace(/[^1-9]/g, ''));
}).css("ime-mode", "disabled"); //CSS设置输入法不可用


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
var setAttrFormUrl = function (obj, form, key, action) {
    var that = $(obj);
    var key = key ? key : "uuid";
    var action = action ? action : "action"
    //tr的数据
    var tr = $(that).parents("tr");
    var keyValue = $(tr).attr(key);
    //编辑url
    var url = form.attr(action).replace(key, keyValue);
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
