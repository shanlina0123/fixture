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


    //点击添加奖项设置
    $(".addPrize").click(function () {
        if ($(".priceTable tr").size() < 9) {
            var addTable = $(".priceTable")
            var addtr = $(".defaulttr").prop("outerHTML");
            addTable.append(addtr);
            var lasttr = $(".defaulttr:last");
            var newIndex = $(".defaulttr").length - 1;
            $(".uploadImg", lasttr).attr("selectIndex", newIndex);
            $(".uploadImg", lasttr).attr("id", "uploadImg" + newIndex);
            $('.imgHome', lasttr).html('');
            $('[name=picture]', lasttr).val("");
            $('[name=name]', lasttr).val("");
            $('[name=num]', lasttr).val("");
            $(lasttr).attr("id",0);
            layuiForm.render();
            uploadMuilty('#uploadImg' + newIndex);
        } else {
            layer.msg("最多添加8个");
        }
    });

    /**
     * 基本设置-上传
     */
    upload.render({
        elem: '.tab1Upload',
        exts: "jpg|png|jpeg",
        size: 5120,
        url: '/upload-temp-img',
        accept: 'images',
        acceptMime: 'image/*',
        before: function (obj) {
            layer.msg('图片上传中...', {icon: 16, shade: 0.01, time: 0})
        }
        , done: function (res) {
            layer.closeAll();
            if (res.code == 1) {
                var parent = this.item.parents(".baseUrl")
                layer.closeAll('loading'); //关闭loading
                $('.showUrl', parent).html("");
                $(".showUrl", parent).append("<img class='showImg' src='" + res.data.src + "'/>");
                $(".hiddenUrl", parent).val(res.data.name);
            } else {
                layer.msg("上传失败", {icon: 2})
            }

        },
        error: function (index, upload) {
            layer.closeAll();
        }
    });


    //已有页面的tr的绑定多图上传事件
    $.each($(".uploadImg"), function (i, n) {
        uploadMuilty('#uploadImg' + i);
    });

    //多图上传被调用
    function uploadMuilty(el) {
        upload.render({
            elem: el
            , exts: "jpg|png|jpeg"
            , url: '/upload-temp-img'
            , multiple: true
            , accept: 'images'
            , acceptMime: 'image/*'
            , number: 8
            , before: function (obj) {
                layer.msg('图片上传中...', {icon: 16, shade: 0.01, time: 0})
                //预读本地文件示例，不支持ie8

                var parentsList = $(".uploadImgWrap");
                var len = parentsList.length;
                var selectIndex = this.elem.attr("selectIndex");
                var parent = parentsList.get(selectIndex);
                var abc = obj;
                if (len < 9) {
                    obj.preview(function (index, file, result) {
                        $('.imgHome', parent).html("");
                        $('.imgHome', parent).append('<img src="' + result + '" alt="' + file.name + '" class="layui-upload-img imgHomeShow">');
                    });
                }
            }
            , done: function (res) {
                layer.closeAll();
                //上传完毕
                if (res.code == 1) {
                    if ($(".imgHomeShow").length > 8) {
                        layer.msg('最多可上传9个哦');
                    }
                    var parentsList = $(".uploadImgWrap");
                    var len = parentsList.length;
                    var selectIndex = this.elem.attr("selectIndex");
                    var parent = parentsList.get(selectIndex);
                    $('[name=picture]', parent).val(res.data.name);
                } else {
                    layer.msg("上传失败", {icon: 2})
                }
            },
            error: function (index, upload) {
                layer.closeAll();
            }
        });
    }


    //新增、修改
    $(".ajaxSubmit").click(function () {
        var form = $(this).parents("form");
        var title = $("#title", form).val();
        var id=$(form).attr("id");
        if(id)setAutoToFormUrl(form,"id");
        else setFormUrl(form,"id");
        var postData=getPostData(this,form);
        //表单验证
        if(checkForm(title,1))
        {
            $.ajaxSubmit(form,postData,doStoreOrUpdate);
        }
    });

    //新增、修改Ajax结果处理
    var doStoreOrUpdate=function (data) {
        var form=$("form");
        form.attr("id",data.data.id);
        if(data.status===1){
            if(data.data.isonline==1)
            {
                window.location.href=data.data.listurl;
            }
            $("[name=bgurl]",form).val("");
            $("[name=makeurl]",form).val("");
            $("[name=loseurl]",form).val("");
            $("[name=picture]",form).val("");
            setRowData(data.data.prizeIds);
            layer.msg(data.messages,{icon: 1,time: 1000});
        }else{
            layer.msg(data.messages, {icon: 2,time: 2000});
        }
    }

});

//删除奖项页面元素
function deleteItem(index) {

    layer.confirm('确定要删除吗？', {
        btn: ['确定', '取消']
    },function(){
        var id=$(index).parents("tr").attr("id");
        if(id)
        {
            $.deleteJSON($(index).attr("url"),null,function(data){
                $(index).parents("tr").remove();
                layer.msg('删除成功', {icon: 1});
            });
        }else{
            $(index).parents("tr").remove();
        }
    });
}



//添加修改的post
var getPostData=function (obj,form) {
    return {
        "id":$(form).attr("id"),
        "storeid":$("[name=storeid]",form).val(),
        "title":$("[name=title]",form).val(),
        "resume":$("[name=resume]",form).val(),
        "startdate":$("[name=startdate]",form).val(),
        "enddate":$("[name=enddate]",form).val(),
        "ispeoplelimit":$("[name=ispeoplelimit]:checked",form).val(),
        "peoplelimitnum":$("[name=peoplelimitnum]",form).val(),
        "bgurl":$("[name=bgurl]",form).val(),
        "makeurl":$("[name=makeurl]",form).val(),
        "loseurl":$("[name=loseurl]",form).val(),
        "ischancelimit":$("[name=ischancelimit]:checked",form).val(),
        "chancelimitnum":$("[name=chancelimitnum]",form).val(),
        "everywinnum":$("[name=everywinnum]",form).val(),
        "winpoint":$("[name=winpoint]",form).val(),
        "ishasconnectinfo":$("[name=ishasconnectinfo]:checked",form).val(),
        "prizelist":getRowPostData(form),
        "sharetitle":$("[name=sharetitle]",form).val(),
        "isonline":$("[name=isonline]:checked",form).val(),
        "ispublic":$(obj).attr("ispublic"),
    };
}



//设置录入成功后的数据
var setRowData=function (data) {
    var postData=[];
    var strJson;
    var obj=$(".defaulttr");
    for(var i=0;i<obj.length;i++)
    {
        var one=obj.get(i);
        var levelid=$("[name=levelid]",one).val();
        var rsid=data[levelid];
         $(one).attr("id",rsid);
         $(".deleteBtn",one).attr("url").replace("id",rsid);
    }
    return postData;
}

//整理勾选提交的数据
var getRowPostData=function () {
    var postData=[];
    var strJson;
    var obj=$(".defaulttr");
    for(var i=0;i<obj.length;i++)
    {
        var one=obj.get(i);
        var picture=$("[name=picture]",one).val();
        var name=$("[name=name]",one).val();
        var num=$("[name=num]",one).val();
        var levelid=$("[name=levelid]",one).val();
        var id=$(one).attr("id");
        if(name&&num&&levelid)
        {
            var strJson={id:id,picture:picture,name:name,num:num,levelid:levelid};
            postData.push(strJson);
        }
    }
    return postData;
}

//预览
$("#showBtn").click(function () {
      //动态数据
      var form=$("form");
      var startdate=$("[name=startdate]",form).val();
      var enddate=$("[name=enddate]",form).val();
      var resume=$("[name=resume]",form).val();
      var bgurl=$("#bgurl",form).find("img").attr("src");
      var makeurl=$("#makeurl",form).find("img").attr("src");
      var loseurl=$("#loseurl",form).find("img").attr("src");
      //预览
      var showDiv=$("#showContent");
      startdate&&enddate?$("#luckydate",showDiv).html(startdate+" 到 "+enddate):"";
      resume?$("#resume",showDiv).html(resume):"";
      bgurl?$("#bgurl",showDiv).css("background","url("+bgurl+") center top no-repeat"):"";
      makeurl?$("#makeurl",showDiv).find("img").attr("src",makeurl):"";
      loseurl?$("#loseurl",showDiv).find("img").attr("src",loseurl):"";
        var obj=$(".defaulttr");
        for(var i=0;i<obj.length;i++)
        {
            var one=obj.get(i);
            var picture=$(".imgHome",one).find("img").attr("src");
            picture?$("#prizeList"+i).find("img").attr("src",picture):"";
        }
});

//表单验证
var checkForm = function (title,id) {
    if(id=="")
    {
        layer.msg("请求错误",{icon: 2});
        return false;
    }
    if (title == "") {
        layer.msg("标题不能为空", {icon: 2});
        return false;
    }
    return true;
}

//正整数
$("input[type=number]").keyup(function () {
    $(this).val($(this).val().replace(/[^0-9]*$/, ''));
    if($(this).val()==0)
    {
        $(this).val($(this).val().replace(0,''));
    }
}).bind("paste", function () {  //CTR+V事件处理
    $(this).val($(this).val().replace(/[^0-9]*$/, ''));
    if($(this).val()==0)
    {
        $(this).val($(this).val().replace(0,''));
    }
}).css("ime-mode", "disabled"); //CSS设置输入法不可用
