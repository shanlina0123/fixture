$("#addRow").click(function () {
    var tem = '<div class="layui-form-item">\n' +
        '                <label class="layui-form-label">阶段标签</label>\n' +
        '                <div class="layui-input-block">\n' +
        '                    <div class="layui-input-inline" style="width:25%;">\n' +
        '                        <input type="text"  name="tag[]" class="layui-input" placeholder="请输入标签" datatype="*1-2" nullmsg="请输入标签" errormsg="标签2个字内">\n' +
        '                    </div>\n' +
        '                    <div class="layui-input-inline btn" style="width:25%;">\n' +
        '                        <button  type="button" class="layui-btn layui-btn-primary up" onclick="upRow(this)">上移</button>\n' +
        '                        <button  type="button" class="layui-btn layui-btn-primary dow" onclick="dowRow(this)">下移</button>\n' +
        '                        <button  type="button" class="layui-btn layui-btn-primary rem" onclick="removeRow(this)">删除</button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>';
    $("#tagList").append( tem );
    updateDivStatus();
});

function removeRow( index )
{

    if( $(index).hasClass('layui-disabled') == false )
    {
        $(index).parents('.layui-form-item').remove();
        updateDivStatus();
    }

}

function upRow( index )
{
    if( $(index).parents('.layui-form-item').prev() )
    {
        $(index).parents('.layui-form-item').prev().before($(index).parents('.layui-form-item'));
        updateDivStatus();
    }
}

function dowRow( index ) {

    if( $(index).parents('.layui-form-item').next() )
    {
        $(index).parents('.layui-form-item').next().after($(index).parents('.layui-form-item'));
        updateDivStatus();
    }
}

/**
 * 修改加载的状态
 */
function updateDivStatus()
{
    $("#tagList").find('.layui-form-item').find('button').removeClass('layui-disabled');
    $("#tagList").find('.layui-form-item').find('.layui-form-label').html('');
    //第一个有label
    $("#tagList").find('.layui-form-item').first().find('.layui-form-label').html('阶段标签');
    //取消第一个删除
    $("#tagList").find('.layui-form-item').first().find('.btn .rem').addClass('layui-disabled');
    //取消第一个上移
    $("#tagList").find('.layui-form-item').first().find('.btn .up').addClass('layui-disabled');
    //取消最后一个下移
    $("#tagList").find('.layui-form-item').last().find('.btn .dow').addClass('layui-disabled');
}


!function(){

    updateDivStatus();
    if( $("#msg").val() )
    {

        layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
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
        postonce:true,
        tipSweep:true,
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


$(".del-btn").click(function () {
    var url = $(this).data('url');
    layer.confirm('您确认要删除吗？', {
        icon: 3, title:'删除',
        btn: ['确认','取消'] //按钮
    }, function(){
        $.post(url,{_method:'DELETE'},function ( data ) {
            if( data.status == 1 )
            {
                layer.msg(data.msg,{icon:1},function () {
                    location.href = location;
                });
            }else
            {
                layer.msg(data.msg, {icon: 5, time: 2000, shift: 6});
            }
        },'json')
    });
});

$(".default-btn").click(function () {
    var url = $(this).data('url');
    $.post(url,function ( data ) {
        if( data.status == 1 )
        {
            layer.msg(data.msg,{icon:1},function () {
                location.href = location;
            });
        }else
        {
            layer.msg(data.msg, {icon: 5, time: 2000, shift: 6});
        }
    },'json')
});

$(".edit-btn").click(function () {
    var url = $(this).data('url');
    var type = $(this).data('type');
    var index = layui.layer.open({
        title : "编辑",
        type : 2,
        content: url+"?type="+type,
        success : function(layero, index){
            setTimeout(function(){
                layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                    tips: 3
                });
            },500)
        }
    })
    layui.layer.full(index);
});