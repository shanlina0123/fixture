layui.use(['form', 'layer', 'jquery'], function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
    //删除门店
    $(".deleteBtn").click(function () {
        var me = $(this);
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function () {
            me.parents("tr").remove();
            layer.msg('删除成功', {
                icon: 1
            });
        });
    });
    //新增角色弹窗
    $(".addBtn").click(function () {
        layer.open({
            type: 1,
            title: '新增角色',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['600px', '300px'],
            content: $(".addWrap")
        })
    });
    //编辑角色弹窗
    $(".editBtn").click(function () {
        layer.open({
            type: 1,
            title: '编辑角色',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['600px', '300px'],
            content: $(".editWrap")
        })
    });

    //执行-新增/修改角色
    $(".ajaxSubmit").click(function () {
        var form = $(this).parents("form");
        var name = $("#name", form).val();
        //表单验证
        var check = checkForm(form);
        if (check) {
            //提交
            ajaxSubmit(form, {name: name});
        }
    });


    //表单验证
    var checkForm = function (name) {
        if (name == "") {
            layer.tips($(n).attr("errorMsg"), '#name', {
                tips: [2, '#ff0000'],
                time: 1000
            });
            return false;
        }
        return true;
    }


});