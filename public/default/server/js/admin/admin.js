layui.use(['form', 'layer', 'jquery'], function () {
    var layuiForm = layui.form,
        layer = layui.layer,
        $ = layui.jquery;

    //列表错误信息
    var error=$("#errorMsg").attr("content");
    if(error)
    {
        layer.msg(error, {
            icon: 2
        });
    }

    //新增用户弹窗
    $(".addBtn").click(function() {
        layer.open({
            type: 1,
            title: '新增用户',
            shadeClose: true,
            scrollbar: false,
            skin: 'layui-layer-rim',
            area: ['650px', '650px'],
            content: $(".addWrap")
        })
    });

    //编辑用户弹窗
    $(".editBtn").click(function () {
        var that=this;
        //页面赋值
        var form=$("#editForm");
        setAttrFormUrl(that,form);
        $("#nickname",form).val($("#rowNickName", $(that).parents("tr")).html());
        $("#username",form).val($("#rowUserName", $(that).parents("tr")).html());
        $("#roleid",form).val($(that).parents("tr").attr("roleid"));
        $("#storeid",form).val($(that).parents("tr").attr("storeid"));
        layuiForm.render("select");
        //锁定
        $('[name=status]',form).each(function(i,item){
            if($(item).val()==$("#rowStatus", $(that).parents("tr")).attr("status")*1) {
                $(item).prop('checked', true);
            }
            layuiForm.render("radio");
        });
       //弹出层
        layer.open({
            type: 1,
            title: '编辑用户',
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
    var nickname = $("#nickname", form).val();
    var username = $("#username", form).val();
    var password = $("#password", form).val();
    var roleid = $("#roleid", form).val()*1;
    var storeid = $("#storeid", form).val()*1;
    var status = $("#status", form).val()*1;
    //表单验证
    if(checkForm(nickname,username,password,roleid,status))
    {
        $.ajaxSubmit(form,{nickname: nickname,username:username,password:password,roleid:roleid,storeid:storeid,status:status},doStoreOrUpdate);
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




//表单验证
var checkForm = function(nickname,username,password,roleid,status) {
    if (nickname == "") {
        layer.msg("名称不能为空", {icon: 2,time:800});
        return false;
    }
    if (username == "") {
        layer.msg("账号不能为空", {icon: 2,time:800});
        return false;
    }
    if (password == "") {
        layer.msg("密码不能为空", {icon: 2,time:800});
        return false;
    }
    if (roleid == "") {
        layer.msg("角色不能为空", {icon: 2,time:800});
        return false;
    }
    if (status.length==0) {
        layer.msg("锁定不能为空", {icon: 2,time:800});
        return false;
    }
    return true;
}


});