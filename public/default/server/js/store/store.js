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

    //搜索
    $(".searchBtn").click(function () {
        var that = this;
        var form = $("#searchForm");
        var name = $("#name", form).val();
        $.postJSON($(form).attr("action"), {name: name}, function (data) {
            if (data.status === 1) {
                window.location.href = $("#listForm").attr("action");
            } else {
                layer.msg(data.messages, {icon: 2, time: 1000});
            }
        });

    });

    //选择省,显示市
    layuiForm.on('select(changeProvince)', function (data) {
        var form = $(data.elem).parents("form");
        var provinceid = $(data.elem).val();
        setCityList($(data.elem), form);
    });

    //新增用户弹窗
    $(".addBtn").click(function () {
        var that = this;
        //页面赋值
        var form = $("#addForm");
        $("#provinceid", form).val(form.attr("provinceid"));
        $("#cityid", form).val(form.attr("cityid"));
        layuiForm.render("select");
        layer.open({
            type: 1,
            title: '新增门店',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['650px', '600px'],
            content: $(".addWrap")
        })
    });

    //编辑弹窗
    $(".editBtn").click(function () {
        var that = this;
        //页面赋值
        var form = $("#editForm");
        setAttrFormUrl(that, form);
        $("#name", form).val($("#name", $(that).parents("tr")).html());
        $("#addr", form).val($("#addr", $(that).parents("tr")).html());
        $("#provinceid", form).val($(that).parents("tr").attr("provinceid"));
        setCityList($("#provinceid",form), form);
        $("#cityid", form).val($(that).parents("tr").attr("cityid"));
        layuiForm.render("select");
        //弹出层
        layer.open({
            type: 1,
            title: '编辑门店',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['650px', '650px'],
            content: $(".editWrap")
        })
    });

    //新增、修改
    $(".ajaxSubmit").click(function () {
        var form = $(this).parents("form");
        var name = $("#name", form).val();
        var addr = $("#addr", form).val();
        var cityid = $("#cityid", form).val() * 1;
        var provinceid = $("#provinceid", form).val() * 1;
        //表单验证
        if (checkForm(name, cityid)) {
            $.ajaxSubmit(form, {cityid: cityid, provinceid: provinceid, name: name, addr: addr}, doStoreOrUpdate);
        }
    });

    //新增、修改Ajax结果处理
    var doStoreOrUpdate = function (data) {
        if (data.status === 1) {
            window.location.href = $("#listForm").attr("action");
            layer.closeAll();
            layer.msg(data.messages, {icon: 1, time: 1000});
        } else {
            layer.msg(data.messages, {icon: 2, time: 1000});
        }
    }

    //删除门店
    $(".deleteBtn").click(function () {
        var that = this;
        var url = getAttrUrl(that);
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function () {
            $.deleteJSON(url, function (data) {
                if (data.status === 1) {
                    $(that).parents("tr").remove();
                    layer.msg(data.messages, {icon: 1, time: 1000});
                } else {
                    layer.msg(data.messages, {icon: 2, time: 1000});
                }
            });
        });
    });

    //根据省切换市
    var setCityList = function (obj, form) {
        var provinceid = obj.val();
        var jsonData = $.parseJSON(obj.attr("jsonData"));
        var cityList = jsonData[provinceid];
        if (cityList) {
            var appendHtml = "<option value='0'>请选择</option>";
            $.each(cityList, function (i, n) {
                appendHtml += "<option value='" + n["id"] + "'>" + n["name"] + "</option>";
            });
            $("#cityid", form).html(appendHtml)
        }
        layuiForm.render('select');
    }


    //表单验证
    var checkForm = function (name, cityid) {
        if (name == "") {
            layer.tips("名称不能为空", '#name', {
                tips: [2, '#ff0000'],
                time: 1000
            });
            return false;
        }
        if (cityid == "") {
            layer.tips("城市不能为空", '#name', {
                tips: [2, '#ff0000'],
                time: 1000
            });
            return false;
        }
        return true;
    }


});