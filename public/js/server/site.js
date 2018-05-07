$(window).one("resize",function(){
    $(".add-btn").click(function(){
        var url = $(this).data('url');
        var index = layui.layer.open({
            title : "创建工地",
            type : 2,
            content: url,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回工地列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
    })

    $(".edit-btn").click(function(){
        var url = $(this).data('url');
        var index = layui.layer.open({
            title : "编辑工地",
            type : 2,
            content: url,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回工地列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
    })

    $(".update-btn").click(function(){
        var url = $(this).data('url');
        var index = layui.layer.open({
            title : "更新",
            type : 2,
            content: url,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回工地列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
    })

}).resize();

!function(){
    var upload = layui.upload;
    var form = layui.form;
    /**
     * 拖拽上传
     */
    upload.render({
        elem: '#test10',
        exts:"jpg|png|jpeg",
        size:5120,
        url: '/upload-temp-img',
        before: function(obj)
        {
            layer.load(); //上传loading
        }
        ,done: function(res)
        {
            layer.closeAll('loading'); //关闭loading
            $("#src").attr('src',res.data.src);
            $("#photo").val(res.data.name);
            console.log(res)
        },
        error: function(index, upload){
            layer.closeAll('loading'); //关闭loading
        }
    });

    form.on('select(stagetemplate)', function(data){
         $("#templateTag").empty();
         $("#templateTag").parents('.layui-form-item').removeClass('layui-hide');
         $("#templateTag").parents('.layui-form-item').addClass('layui-show');
         var type = $("#stagetemplateid option:selected").data("type");
         $("#isdefaulttemplate").val(type);
         var url = $("#stagetemplateid option:selected").data("url");
         var tid = data.elem.value;
         var str = '';
         $.post(url,{type:type,tid:tid},function ( data ) {
             for( var i= 0;i<data.length;i++ )
             {
                 str+='<input type="radio" name="stagetagid" value="'+data[i].id+'" title="'+data[i].name+'" >';
             }
             $("#templateTag").append(str);
             form.render('radio');
         },'json');
    });

    if( $("#msg").val() )
    {
        layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6},function () {
            parent.location.reload();
        });
    }

    if( $("#error").val() )
    {
        layer.msg($("#error").val(), {icon: 5, time: 2000, shift: 6});
    }
}();

/**
 * 表单验证
 */
if( $("#layui-form").length )
{
    $("#layui-form").Validform({
        btnSubmit: '#btn_submit',
        tiptype: 1,
        postonce: true,
        showAllError: false,
        tiptype: function (msg, o, cssctl) {
            if (!o.obj.is("form")) {
                if (o.type != 2) {
                    var objtip = o.obj.parents('.layui-form-item').find(".layui-input");
                    objtip.addClass('layui-form-danger');
                    cssctl(objtip, o.type);
                    layer.msg(msg, {icon: 5, time: 2000, shift: 6});
                }
            }
        }
    });
}


function  del(index)
{
    var url = $(index).data('url');
    layer.confirm('您确认要删除吗？', {
        icon: 3, title:'删除',
        btn: ['确认','取消'] //按钮
    }, function(){
        $.post(url,{_method:'DELETE'},function ( msg ) {
            if( msg == 'success' )
            {
                layer.msg('删除成功。。。',{icon:1},function () {
                    location.href = location;
                });
            }else
            {
                layer.msg('删除失败。。。', {icon: 5, time: 2000, shift: 6});
            }
        })
    });
}

$.extend($.Datatype, {
    "mj": function (gets, obj, curform, regxp)
    {
        var reg = /^([1-9][0-9]*)+(.[0-9]{1,2})?$/;
        if ( reg.test(gets) && gets <=50000 && gets >= 1)
        {
            return true;

        }else
        {
            return false;
        }
    },
    "jg": function (gets, obj, curform, regxp)
    {
        var reg = /^([1-9][0-9]*)+(.[0-9]{1,2})?$/;
        if ( reg.test(gets) && gets <=10000 && gets >= 2)
        {
            return true;
        }else
        {
            var len = gets.toString().split(".");
            if( len.length > 1 && isNaN(gets) == false )
            {
                if( len[0] <= 1 )
                {
                    return false;
                }

                if( len[1].length > 2 )
                {
                    return false;
                }
            }else
            {
                if( isNaN(gets) == false )
                {
                    obj.attr('errormsg', '售价要大于2万元小于1亿元');
                    return false;

                }else
                {
                    obj.attr('errormsg', '非法字符');
                    return false;
                }

            }
        }
    }
});
