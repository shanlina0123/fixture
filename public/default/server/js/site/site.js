layui.use(['form', 'layer','upload'], function() {
    var form = layui.form,
        layer = layui.layer;
    var upload = layui.upload;
    var form = layui.form;



    /**
     * 单图上传--工地封面
     */
    upload.render({
        elem: '#test10',
        exts:"jpg|png|jpeg",
        url: '/upload-temp-img',
        accept:'images',
        acceptMime:'image/*',
        before: function(obj)
        {
            layer.load(); //上传loading
        }
        ,done: function(res)
        {
            layer.closeAll();
            if(res.code==1)
            {
                $("#src").attr('src',res.data.src);
                $("#photo").val(res.data.name);
                $(".uploadImg").show();
            }else{
                layer.msg(res.msg,{icon: 2,  time:2000});
            }
            //console.log(res)
        },
        error: function(index, upload){
            layer.closeAll();
            layer.msg(res.msg,{icon: 2,  time:2000});
        }
    });

    /**
     * 上传小视频-工地动态
     */
    upload.render({
        elem: '#updateVideo',
        exts:"mp4",
        url: '/upload-temp-img',
        accept:'video',
        acceptMime:'video/mp4',
        before: function(obj)
        {
            layer.load(); //上传loading
        }
        ,done: function(res)
        {
            layer.closeAll();
            //上传完毕
            if( res.code==1)
            {
                var allnum=$(".layui-upload-img").length;
                var isvideo=$(".ImgWrap").find("video").length?1:0;
                var arr = $("#img").val().split(",");
                if(allnum<9)
                {
                    if(isvideo==0)
                    {
                        arr.unshift(res.data.name);
                        $('#update_img').prepend('<div class="ImgWrap fl"><span><img src="/default/server/images/close.png" data-title="'+ res.data.name +'" onclick="delTempImg(this)" style="z-index:1"></span><video src="'+res.data.src+'" class="layui-upload-img"  width="100" height="100" controls="controls">your browser does not support the video tag </video></div>');
                        $("#img").val(arr.join());
                    }else{
                        layer.msg('视频最多可上传1个');
                    }

                }else{
                    layer.msg('图片加视频最多可上传9个');
                }
            }else{
                layer.msg(res.msg,{icon: 2,  time:2000});
            }
        },
        error: function(index, upload){
            layer.closeAll();
            layer.msg(res.msg,{icon: 2,  time:2000});
        }
    });

    /**
     * 多图片上传-工地动态
     */
    upload.render({
        elem: '#updateImg'
        ,exts:"jpg|png|jpeg"
        ,url: '/upload-temp-img'
        ,multiple: true
        ,accept:'images'
        ,acceptMime:'image/*'
        ,number:9
        ,before: function(obj){
            //预读本地文件示例，不支持ie8
            var len = $('#update_img').find("img").length;
            if( len < 9 )
            {
                var i=0;
                obj.preview(function(index, file, result){
                    //$('#update_img').append(' <div class="ImgWrap fl"><span><img src="/default/server/images/close.png" onclick="delTempImg('+i+',this)"></span><img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img"></div>');
                });
            }
        }
        ,done: function(res){
            layer.closeAll();
            //上传完毕
            if( res.code==1)
            {
                var allnum=$(".layui-upload-img").length;
                var isvideo=$(".ImgWrap").find("video").length?1:0;
                var arr = $("#img").val().split(",");
                if(allnum<9)
                {
                    arr.push(res.data.name);
                    $('#update_img').append('<div class="ImgWrap fl"><span><img src="/default/server/images/close.png" data-title="'+ res.data.name +'" onclick="delTempImg(this)"></span><img src="'+ res.data.src +'" alt="'+ res.data.name +'" class="layui-upload-img"></div></div>');

                    $("#img").val(arr.join());
                }else{
                    layer.msg('图片最多可上传9张');
                }
            }else{
                layer.msg(res.msg,{icon: 2,  time:2000});
            }
        },
        error: function (index, upload) {
            layer.closeAll();
            layer.msg(res.msg,{icon: 2,  time:2000});
        }
    });
    form.on('select(stagetemplate)', function(data){
        $("#templateTag").empty();
        $("#templateTag").parents('.layui-form-item').removeClass('layui-hide');
        $("#templateTag").parents('.layui-form-item').addClass('layui-show');
        var url = $("#stagetemplateid option:selected").data("url");
        var tid = data.elem.value;
        var str = '';
        $.post(url,{tid:tid},function ( data ) {
            for( var i= 0;i<data.length;i++ )
            {
                str+='<input type="radio" name="stageid" lay-filter="radio"  data-name="'+data[i].name+'" value="'+data[i].id+'" title="'+data[i].name+'" >';
            }
            $("#templateTag").append(str);
            form.render('radio');
        },'json');
    });

    form.on('radio(radio)', function(data){
        var name = $(data.elem).data('name');
        $("#sitestagename").val(name);
        /* console.log(data.elem); //得到checkbox原始DOM对象
         console.log(data.elem.checked); //开关是否开启，true或者false
         console.log(data.value); //开关value值，也可以通过data.elem.value得到
         console.log(data.othis); //得到美化后的DOM对象*/
    });

    form.on('switch(isOpen)', function(data){
        var url = $(data.elem).data('url');
        var isopen = data.elem.checked?1:0;
        $.post(url,{id:data.value,'isopen':isopen},function ( msg ) {
            if( msg.status )
            {
                if(isopen==1){
                    $(".publicBtn").show();
                }else{
                    $(".publicBtn").hide();
                }
                layer.msg(msg.messages,{icon:1},function () {
                    location.href = location;
                });
            }else
            {
                layer.msg(msg.messages, {icon: 5, time: 2000, shift: 6});
            }
        },'json');
       /* console.log(data.elem); //得到checkbox原始DOM对象
        console.log(data.elem.checked); //开关是否开启，true或者false
        console.log(data.value); //开关value值，也可以通过data.elem.value得到
        console.log(data.othis); //得到美化后的DOM对象*/
    });

    if( $("#msg").val() )
    {
        layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
    }

    if( $("#error").val() )
    {
        layer.msg($("#error").val(), {icon: 5, time: 2000, shift: 6});
    }

});

/**
 * 删除临时图片
 */
function delTempImg( index )
{
    var name = $(index).attr('data-title');
    $.get('/upload-temp-del/'+name);

    $(index).parents('.ImgWrap').remove();
}

/**
 * 编辑删除图片
 */
function delUpImg( index ) {
    var name = $(index).attr('data-title');
    var delimg = $("#delimg").val();
    if( delimg )
    {
        var arr = delimg.split(',');
            arr.push(name);
        $("#delimg").val(arr.join(','));
    }else
    {
        $("#delimg").val(name);
    }
    $(index).parents('.ImgWrap').remove();
}

/**
 * 删除动态
 */
function delDynamic( index )
{
    var url = $(index).data('url');
    layer.confirm('您确认要删除吗？', {
        icon: 3, title:'删除',
        btn: ['确认','取消'] //按钮
    }, function(){
        $.post(url,{_method:'DELETE'},function ( msg ) {
            if( msg == 'success' )
            {
                layer.msg('删除成功',{icon:1});
                $(index).parents('tr').remove();
            }else
            {
                layer.msg('删除失败', {icon: 5, time: 2000, shift: 6});
            }
        })
    });
}
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
                layer.msg('删除成功',{icon:1},function () {
                    location.href = location;
                });
            }else
            {
                layer.msg('删除失败', {icon: 5, time: 2000, shift: 6});
            }
        })
    });
}

$.extend($.Datatype, {
    "mj": function (gets, obj, curform, regxp)
    {
        var reg = /^([1-9][0-9]*)+(.[0-9]{1,2})?$/;
        // ^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$ 
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

/**
 * 地图检索
 */
$("#suggestId").keyup(function () {
    var keyword = $(this).val();
    var url = $(this).data('url');
    $.post(url,{keyword:keyword},function (data)
    {
        if( data )
        {
            if( data.status == 0 )
            {
                var list = data.data;
                var str = '';
                for(var i=0;i<list.length;i++)
                {
                    str+='<dd data-lat="'+list[i].location.lat+'"  data-lng="'+list[i].location.lng+'" data-address="'+list[i].address+'" data-title="'+list[i].title+'" data-district="'+list[i].district+'" onclick="getItem(this)">'+list[i].address+'</dd>';

                    //console.log( list[i] );
                }
                $("#seach").empty();
                $("#seach").append(str);
                if( str )
                {
                    $("#seach").show();
                }else
                {
                    $("#seach").hide();
                }
            }
        }
    },'json')
});

/**
 * 选中
 * @param index
 */
function getItem( index )
{
    var lat = $(index).data('lat');
    var lng = $(index).data('lng');
    var address = $(index).data('address');
    var title = $(index).data('title');
    var district = $(index).data('district');
    $("input[name=addr]").val(address);
  /*  $("input[name=street]").val(district+title);
    $("input[name=fulladdr]").val(address);*/
    $("input[name=lat]").val(lat);
    $("input[name=lng]").val(lng);
    $("#suggestId").val(address);
    $("#seach").hide();
}

//正整数
$("input[type=number]").keyup(function () {
    $(this).val($(this).val().replace(/[^0-9]*$/, ''));
}).bind("paste", function () {  //CTR+V事件处理
    $(this).val($(this).val().replace(/[^0-9]*$/, ''));
}).css("ime-mode", "disabled"); //CSS设置输入法不可用




//第一步：点击推广按钮
$(".publicBtn").click(function ()
{
    var that=this;
    var url=$(that).attr("url");
    $.getJSON(url,null,doExtension);
});
var doExtension=function (data) {
    var parent=$("#extensionContent");
    if(data.status===1)
    {
        $("#wxappcode",parent).attr("src",data.data.wxappcode);
        $("#wxappcode",parent).show();
        //下载路径
        $("#downloadExtension",parent).attr('href',data.data.wxappcode);
        //下载名称
        $("#downloadExtension",parent).attr('download','活动二维码');

        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            content: $("#extensionContent")
        })
    }else
    {
        layer.msg(data.messages, {icon: 2,time: 2000});
    }
}
