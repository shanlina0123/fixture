layui.use('form', function () {
    var form = layui.form,
        $ = layui.jquery;

    //添加一行数据
    $(".addBtn").click(function () {
        var form=$("#addAndEditAndDeleteForm");
        var index=!$("tr:last",form).attr("index")?0:$("tr:last",form).attr("index");
        var tsble = $(".popSettingTable");
        var addTr = $("<tr id='0' index='"+(index*1+1)+"'>" +
            "<td>"+(index*1+1)+"</td>" +
            "<td><input type='text' class='layui-input' name='name' id='name'></td>" +
            "<td><div class='settingBtns' style='display: none'><button type='button' class='layui-btn layui-btn-sm popEditBtn' onclick='edit(this)'>" +
            "编辑</button><button type='button' class='layui-btn layui-btn-sm popDelateBtn' onclick='deleteItem(this)'>删除</button></div>" +
            "<div class='settingBtn'><button type='button' class='layui-btn layui-btn-sm popSaveBtn' onclick='save(this)'>保存</button>"+
            "<button type='button' class='layui-btn layui-btn-sm popDelateBtn' onclick='removeItem(this)'>删除</button>"
            +"</div></td>" +
            "</tr>");
        addTr.appendTo(tsble);
    });
});
    //编辑信息方法
    var edit = function (index) {
        $(index).parents("td").siblings().children(".layui-input").removeAttr("readOnly").removeClass("readonly");
        $(index).parents(".settingBtns").hide().siblings(".settingBtn").show();
    }
    //执行- 保存（新增、修改）
    var save = function (index) {
        var form = $(index).parents("form");
        var tr = $(index).parents("tr");
        setAttrFormUrl(index,form,"id");
        //参数
        var id = tr.attr("id");
        var name = $("#name", tr).val();
        var cateid = form.attr("cateid");
        //表单验证
        if (checkForm(name, cateid)) {
            $.putJSON(form.attr("action"),{name:name,cateid:cateid},function(data){
                doStoreOrUpdate(data,index);
            })
        }
    }
    //删除信息
    var deleteItem = function (index) {
        var form = $(index).parents("form");
        var tr = $(index).parents("tr");
        var cateid = form.attr("cateid");
        setAttrFormUrl(index,form,"id","deleteAction");
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function () {
            $.deleteJSON(form.attr("deleteAction"),{cateid:cateid},function(data){
                dodelete(data,index);
            });

        });
    }


    //新增、修改Ajax结果处理
    var doStoreOrUpdate = function (data,index) {
        if (data.status === 1) {
            $(index).parents("tr").attr("id",data.data.dataid)
            $(index).parents("td").siblings().children(".layui-input").attr('readonly', 'readonly').removeClass("readonly").addClass("readonly");
            $(index).parents(".settingBtn").hide().siblings(".settingBtns").show();
        } else {
            layer.msg(data.messages, {icon: 2, time: 1000});
        }
    }

    //删除Ajax结果处理
    var dodelete = function (data,index) {
        if (data.status === 1) {
            $(index).parents("tr").remove();
            layer.msg('删除成功', { icon: 1});
        } else {
            layer.msg(data.messages, {icon: 2, time: 1000});
        }
    }

    //移除行
    var removeItem=function(index)
    {
        $(index).parents("tr").remove();
    }

    //表单验证
    var checkForm = function (name, cateid) {
        if (cateid == "") {
            layer.tips("请求错误", '#edit-btn', {
                tips: [2, '#ff0000'],
                time: 1000
            });
            return false;
        }
        if (name == "") {
            layer.tips("名称不能为空", '#name', {
                tips: [2, '#ff0000'],
                time: 1000
            });
            return false;
        }
        return true;
    }

