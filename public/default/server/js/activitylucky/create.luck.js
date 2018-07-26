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
            $(lasttr).attr("id", 0);
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
                layer.msg(res.msg,{icon: 2,  time:2000});
            }
        },
        error: function (index, upload) {
            layer.closeAll(); //关闭loading
            layer.msg(res.msg,{icon: 2,  time:2000});
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
                    layer.msg(res.msg,{icon: 2,  time:2000});
                }
            },
            error: function (index, upload) {
                layer.closeAll();
                layer.msg(res.msg,{icon: 2,  time:2000});
            }
        });
    }


    //上一步
    $(".prevShow").click(function () {
        var stepIndex = $(this).attr("index") * 1;//当前索引
        var nextIndex=stepIndex+1;//下一页索引
        var prevIndex=stepIndex-1;
        if (stepIndex < 1) {
            layer.msg("无此操作", {icon: 2});
            return false;
        }
        //切换到上一个页面
        $(".layui-tab-title-onlyshow>li").removeClass("layui-this");
        $('#luck_show_tab' + stepIndex).addClass("layui-this");
        $('#luck_tab' + stepIndex).click();

        if(stepIndex==1)
        {
            $(this).hide();//隐藏上一步
            $('.nextShow').show();//显示下一步
            $(".ajaxSubmit").hide();//隐藏保存
        }else{
            $('.nextShow').show();//显示下一步
            $(".ajaxSubmit").hide();//隐藏保存
        }

        //下一步页面索引
         $(".nextShow").attr("index",stepIndex);
        //上一步页面索引
        $(this).attr("index", prevIndex);
    });

    //下一步
    $(".nextShow").click(function () {
        var form = $(this).parents("form");
        var stepIndex = $(this).attr("index") * 1;//当前索引 1
        var nexIndex=stepIndex+1;//下一步索引 2
        var prevIndex=nexIndex-1;//上一步索引 1
        var id = $(form).attr("id");
        if (stepIndex >= 4) {
            layer.msg("无此操作", {icon: 2});
            return false;
        }
        //表单验证
        if (checkForm(id, stepIndex)) {
            //切换到下一个页面
            $(".layui-tab-title-onlyshow>li").removeClass("layui-this");
            $('#luck_show_tab' + nexIndex).addClass("layui-this");
            $('#luck_tab' + nexIndex).click();

            //最后一步
            if (stepIndex == 3) {
                $(this).hide();//隐藏下一步
                $(".ajaxSubmit").show();//显示保存
            }else{
                $(this).show();//显示下一步
                $(".ajaxSubmit").hide();//隐藏保存
            }

            //设置下一页索引
            $(this).attr("index",nexIndex);

            //设置上一页索引
            $(".prevShow").attr("index",prevIndex);
            $(".prevShow").show();
        }

    })

    //保存（新增、修改）
    $(".ajaxSubmit").click(function () {
        var form = $(this).parents("form");
        var id = $(form).attr("id");
        //提交表单
        if (id) setAutoToFormUrl(form, "id");
        else setFormUrl(form, "id");
        var postData = getPostData(this, form);

        $(this).attr("disabled","disabled");
        $.ajaxSubmit(form, postData, doStoreOrUpdate);
    });

    //新增、修改Ajax结果处理
    var doStoreOrUpdate = function (data) {
        var form = $("form");
        form.attr("id", data.data.id);
        if (data.status === 1) {
            layer.msg(data.messages, {icon: 1, time: 500},function(){
                window.location.href = data.data.listurl;
            });
            //if (data.data.isonline == 1) {
          //  window.location.href = data.data.listurl;
           // }
           //  $("[name=bgurl]", form).val("");
           //  $("[name=makeurl]", form).val("");
           //  $("[name=loseurl]", form).val("");
           //  $("[name=picture]", form).val("");
           //  setRowData(data.data.prizeIds);
        } else {
            $(".ajaxSubmit",form).removeAttr("disabled");
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
        "ispeoplelimit": $("[name=ispeoplelimit]:checked", form).val(),
        "peoplelimitnum": $("[name=peoplelimitnum]", form).val(),
        "bgurl": $("[name=bgurl]", form).val(),
        "makeurl": $("[name=makeurl]", form).val(),
        "loseurl": $("[name=loseurl]", form).val(),
        "ischancelimit": $("[name=ischancelimit]:checked", form).val(),
        "chancelimitnum": $("[name=chancelimitnum]", form).val(),
        "everywinnum": $("[name=everywinnum]", form).val(),
        "winpoint": $("[name=winpoint]", form).val(),
        "ishasconnectinfo": $("[name=ishasconnectinfo]:checked", form).val(),
        "prizelist": getRowPostData(form),
        "sharetitle": $("[name=sharetitle]", form).val(),
        "advurl":$("[name=advurl]", form).val(),
        "isonline": $("[name=isonline]:checked", form).val(),
        "ispublic": $(obj).attr("ispublic"),
    };
}


//设置录入成功后的数据
var setRowData = function (data) {
    var postData = [];
    var strJson;
    var obj = $(".defaulttr");
    for (var i = 0; i < obj.length; i++) {
        var one = obj.get(i);
        var levelid = $("[name=levelid]", one).val();
        var rsid = data[levelid];
        $(one).attr("id", rsid);
        $(".deleteBtn", one).attr("url").replace("id", rsid);
    }
    return postData;
}

//整理勾选提交的数据
var getRowPostData = function () {
    var postData = [];
    var strJson;
    var obj = $(".defaulttr");
    for (var i = 0; i < obj.length; i++) {
        var one = obj.get(i);
        var picture = $("[name=picture]", one).val();
        var name = $("[name=name]", one).val();
        var num = $("[name=num]", one).val();
        var levelid = $("[name=levelid]", one).val();
        var id = $(one).attr("id");
        if (name && num && levelid) {
            var strJson = {id: id, picture: picture, name: name, num: num, levelid: levelid};
            postData.push(strJson);
        }
    }
    return postData;
}

//预览
$("#showBtn").click(function () {
    //动态数据
    var form = $("form");
    var startdate = $("[name=startdate]", form).val();
    var enddate = $("[name=enddate]", form).val();
    var resume = $("[name=resume]", form).val();
    var bgurl = $("#bgurl", form).find("img").attr("src");
    var makeurl = $("#makeurl", form).find("img").attr("src");
    var loseurl = $("#loseurl", form).find("img").attr("src");
    //预览
    var showDiv = $("#showContent");
    startdate && enddate ? $("#luckydate", showDiv).html(startdate + " 到 " + enddate) : "";
    resume ? $("#resume", showDiv).html(resume) : "";
    bgurl ? $("#bgurl", showDiv).css("background", "url(" + bgurl + ") center top no-repeat") : "";
    makeurl ? $("#makeurl", showDiv).find("img").attr("src", makeurl) : "";
    loseurl ? $("#loseurl", showDiv).find("img").attr("src", loseurl) : "";
    var obj = $(".defaulttr");
    for (var i = 0; i < obj.length; i++) {
        var one = obj.get(i);
        var picture = $(".imgHome", one).find("img").attr("src");
        picture ? $("#prizeList" + i).find("img").attr("src", picture) : "";
    }
});

//表单验证
var checkForm = function (id, stepIndex) {
    if (id == "") {
        layer.msg("请求错误", {icon: 2});
        return false;
    }
    switch (stepIndex) {
        case 1:
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
            if ($("#startdate").val() >=$("#enddate").val()) {
                layer.msg("开始时间不能大于等于结束时间", {icon: 2});
                return false;
            }
            if ($("input[name=ispeoplelimit]:checked").val() == 1 && $("#peoplelimitnum").val() == "") {
                layer.msg("人数限制不能为空", {icon: 2});
                return false;
            }
            break;
        case 2:
            if ($("input[name=ischancelimit]:checked").val() == 1 && $("#chancelimitnum").val() == "") {
                layer.msg("总抽奖机会人数限制不能为空", {icon: 2});
                return false;
            }
            if ($("#everywinnum").val() == "") {
                layer.msg("每人抽奖次数不能为空", {icon: 2});
                return false;
            }
            if ($("#winpoint").val() == "") {
                layer.msg("总中奖率不能为空", {icon: 2});
                return false;
            }
            break;
        case 3:
            if ($(".defaulttr").length < 8) {
                layer.msg("至少上传8种奖品", {icon: 2, time: 1000});
                return false;
            }else{
                var levelArrData=[];
                for(var i=0;i<8;i++)
                {
                    var leveid=$($("select[name=levelid]").get(i)).val();
                    if($($("input[name=name]").get(i)).val()=="" || $($("input[name=num]").get(i)).val()=="" || leveid=="")
                    {
                        layer.msg("请完善奖品,图片无则使用系统默认图", {icon: 2, time: 1000});
                        return false;
                        break;
                    }
                    if(leveid){
                        levelArrData.push(leveid);
                    }
                }
                if(checkArrRepeat(levelArrData))
                {
                    layer.msg("奖项等级重复，请重新选择", {icon: 2, time: 1000});
                    return false;
                }
            }
            break;
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
