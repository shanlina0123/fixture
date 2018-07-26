var upload, $;
layui.use(['form', 'layer', 'jquery', 'laydate', 'upload'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        laydate = layui.laydate,
        $ = layui.jquery;
    upload = layui.upload;


    //列表错误信息
    var error = $("#errorMsg").attr("content");
    if (error) {
        layer.msg(error, {
            icon: 2
        });
    }


    //开始日期
    laydate.render({
        elem: '#startdate'
        , type: 'datetime'
    });
    //结束日期
    laydate.render({
        elem: '#enddate'
        , type: 'datetime'
    })

    //单选按钮控制后面num框的显示
    layuiForm.on('radio(filterNum)', function (data) {
        var that = data.elem;
        var parent = $(that).parents(".radioFilterNumber");
        var radioValue = $(that).val();
        $("[type=number]", parent).val("");
        if (radioValue * 1 == 1) {
            $("[type=number]", parent).parent().removeClass("hidden");
        } else {
            $("[type=number]", parent).parent().removeClass("hidden").addClass("hidden");
        }
    });


    /**
     * 基本设置-上传
     */
    upload.render({
        elem: '.tab1Upload',
        exts: "jpg|png|jpeg",
        url: '/upload-temp-img',
        accept: 'images',
        acceptMime: 'image/*',
        before: function (obj) {
            layer.msg('图片上传中...', {icon: 16, shade: 0.01, time: 0})
        }
        , done: function (res) {
            layer.closeAll(); //关闭loading
            if (res.code == 1) {
                var parent = this.item.parents(".baseUrl")
                layer.closeAll();
                $('.showUrl', parent).html("");
                $(".showUrl", parent).append("<img class='showImg' src='" + res.data.src + "'/>");
                $(".hiddenUrl", parent).val(res.data.name);
            } else {
                layer.msg(res.msg, {icon: 2, time: 2000});
            }
        },
        error: function (index, upload) {
            layer.closeAll(); //关闭loading
            layer.msg(res.msg, {icon: 2, time: 2000});
        }
    });

    //保存（新增、修改）
    $(".ajaxSubmit").click(function () {
        var form = $(this).parents("form");
        var id = $(form).attr("id");
        //提交表单
        if (id) setAutoToFormUrl(form, "id");
        else setFormUrl(form, "id");
        var postData = getPostData(this, form);

        //表单验证
        if (checkForm(id)) {
            $(this).attr("disabled", "disabled");
            $.ajaxSubmit(form, postData, doStoreOrUpdate);
        }

    });

    //新增、修改Ajax结果处理
    var doStoreOrUpdate = function (data) {
        var form = $("form");
        form.attr("id", data.data.id);
        $(".ajaxSubmit", form).removeAttr("disabled");
        if (data.status === 1) {
            layer.msg(data.messages, {icon: 1, time: 500}, function () {
                window.location.href = data.data.listurl;
            });
        } else {
            layer.msg(data.messages, {icon: 2, time: 2000});
        }
    }

});

//删除奖项页面元素
function deleteItem(index) {

    layer.confirm('确定要删除吗？', {
        btn: ['确定', '取消']
    }, function () {
        var id = $(index).parents("tr").attr("id");
        if (id) {
            $.deleteJSON($(index).attr("url"), null, function (data) {
                $(index).parents("tr").remove();
                layer.msg('删除成功', {icon: 1});
            });
        } else {
            $(index).parents("tr").remove();
        }
    });
}


//添加修改的post
var getPostData = function (obj, form) {
    return {
        "id": $(form).attr("id"),
        "storeid": $("[name=storeid]", form).val(),
        "title": $("[name=title]", form).val(),
        "resume": $("[name=resume]", form).val(),
        "startdate": $("[name=startdate]", form).val(),
        "enddate": $("[name=enddate]", form).val(),
        "bgurl": $("[name=bgurl]", form).val(),
        "mainurl": $("[name=mainurl]", form).val(),
        "isonline": $("[name=isonline]:checked", form).val(),
    };
}




//表单验证
var checkForm = function (id) {
    if (id == "") {
        layer.msg("请求错误", {icon: 2});
        return false;
    }

    if ($("#storeid").val() == "") {
        layer.msg("门店不能为空", {icon: 2});
        return false;
    }
    if ($("#title").val() == "") {
        layer.msg("标题不能为空", {icon: 2});
        return false;
    }

    if ($("#resume").val() == "") {
        layer.msg("活动简介不能为空", {icon: 2});
        return false;
    }
    if ($("#startdate").val() == "") {
        layer.msg("开始时间不能为空", {icon: 2});
        return false;
    }
    if ($("#enddate").val() == "") {
        layer.msg("结束时间不能为空", {icon: 2});
        return false;
    }
    if ($("#startdate").val() >= $("#enddate").val()) {
        layer.msg("开始时间不能大于等于结束时间", {icon: 2});
        return false;
    }
    if ($("[name=bgurl]").val()=="") {
        layer.msg("封面图不能为空", {icon: 2});
        return false;
    }

    return true;
}

//正整数
$("input[type=number]").keyup(function () {
    $(this).val($(this).val().replace(/[^0-9]*$/, ''));
    if ($(this).val() == 0) {
        $(this).val($(this).val().replace(0, ''));
    }
}).bind("paste", function () {  //CTR+V事件处理
    $(this).val($(this).val().replace(/[^0-9]*$/, ''));
    if ($(this).val() == 0) {
        $(this).val($(this).val().replace(0, ''));
    }
}).css("ime-mode", "disabled"); //CSS设置输入法不可用
