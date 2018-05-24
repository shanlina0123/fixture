layui.use(['form', 'layer', 'jquery'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        $ = layui.jquery;

    //列表错误信息
    var error=$("#errorMsg").attr("content");
    if(error!="")
    {
        layer.msg(error, {
            icon: 2
        });
    }

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
        var that=this;
        //页面赋值
        var form=$("#editForm");
        setAttrFormUrl(that,form);
        $("#name",form).val($("#rowName", $(that).parents("tr")).html());
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

    //新增、修改
    $(".ajaxSubmit").click(function () {
        var form = $(this).parents("form");
        var name = $("#name", form).val();
        //表单验证
        if(checkForm(name,1))
        {
            $.ajaxSubmit(form,{name: name},doStoreOrUpdate);
        }
    });

    //新增、修改Ajax结果处理
    var doStoreOrUpdate=function (data) {
        if(data.status===1){
            window.location.href=$("#listForm").attr("action");
           layer.closeAll();
           layer.msg(data.messages,{icon: 1,time: 1000});
        }else{
            layer.msg(data.messages, {icon: 2,time: 1000});
        }
    }

    //删除门店
    $(".deleteBtn").click(function () {
        var that=this;
        var url=getAttrUrl(that);
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function () {
            $.deleteJSON(url,"",function(data){
                if(data.status===1){
                    $(that).parents("tr").remove();
                    layer.msg(data.messages,{icon: 1,time: 1000});
                }else{
                    layer.msg(data.messages, {icon: 2,time: 1000});
                }
            });
        });
    });

   //锁定
    layuiForm.on('switch(rowStatus)', function (data) {
        var that=this;
        var url=getAttrUrl(that);
        $.putJSON(url,null,function(data){
            if(data.status==1)
            {
                $("#rowStatus", $(that).parents("tr")).attr("status",data.data.status);
              layuiForm.render('checkbox');
            }
        });
    });

    //进入权限页面
    $(".authBtn").click(function () {
        var that=this;
        var rowStatus=$("#rowStatus", $(that).parents("tr")).attr("status");
        if(rowStatus==1)
        {
            window.location.href=getAttrUrl(that,"roleid");
        }else{
            layer.msg("角色已禁用，不能进行权限设置",{icon:2,time: 1000})
        }
    });


    //表单验证
    var checkForm = function (name,uuid) {
        if(uuid=="")
        {
            layer.msg("请求错误", {icon: 2,time:800});
            return false;
        }
        if (name == "") {
            layer.msg("名称不能为空", {icon: 2,time:800});
            return false;
        }
        return true;
    }


});