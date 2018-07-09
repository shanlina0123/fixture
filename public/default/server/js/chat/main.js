layui.use(['jquery', 'layer'], function () {
    var $ = layui.jquery,
        layer = layui.layer;

    /**
     * 解决ajax CSRF
     */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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





});

//时间戳转日期
function timestampToTime(timestamp) {
    var date = new Date(timestamp);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    var h, m = "";
    //Y = date.getFullYear() + '-';
    //M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    //D = date.getDate() + ' ';
    h = date.getHours() + ':';
    m = date.getMinutes();
    // s = date.getSeconds();
    return h + m;
}

//获取系统当前时间
function clientCurrentTime() {
    var d = new Date(), str = '';
    str += d.getHours() + ':';
    str += d.getMinutes();
    return str;
}

