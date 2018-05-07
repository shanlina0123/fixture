var pName,cName,aName;
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
            $("#logo").val(res.data.name);
            console.log(res)
        },
        error: function(index, upload){
            layer.closeAll('loading'); //关闭loading
        }
    });

    form.on('select(province)', function(data){
        $("#city").find("option:not(option:first)").remove();
        $("#area").find("option:not(option:first)").remove();
        pName = data.elem[data.elem.selectedIndex].title;
        getCity(data.elem.value,$("#city").data('cityid'));
        $("#fulladdr").val(pName);
    });
    form.on('select(city)', function(data){
        $("#area").find("option:not(option:first)").remove();
        cName = data.elem[data.elem.selectedIndex].title;
        $("#fulladdr").val(pName+cName);
        getArea(data.elem.value,$("#area").data('coucntryid'));
    });
    form.on('select(area)', function(data){
        aName = data.elem[data.elem.selectedIndex].title;
        $("#fulladdr").val(pName+cName+aName);
    });
    getProvince($("#province").data('province'));

    /**
     * 验证是不是传值
     */
    if($("#province").data('province'))
    {
        getCity($("#province").data('province'),$("#city").data('cityid'));
    }

    if($("#city").data('cityid'))
    {
        getArea($("#city").data('cityid'),$("#area").data('coucntryid'));
    }
}();


/**
 * 表单验证
 */
$(".layui-form").Validform({
    btnSubmit:'#btn_submit',
    tiptype:1,
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if( o.type != 2 )
            {
                var objtip = o.obj.parents('.layui-form-item').find(".layui-input");
                objtip.addClass('layui-form-danger');
                cssctl(objtip, o.type);
                layer.msg(msg,{icon:5,time:2000, shift: 6});
            }
        }
    }
});

/**
 * 页面提示
 */
var msg = $("#msg").val();
if( msg )
{
    layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
}

/**
 * 获取省份
 */
function getProvince(provinceid)
{
    $.get('/json/province.json',function ( data )
    {
        var str = '';
        for ( var i=0; i<data.length; i++ )
        {
            if(  provinceid != data[i]['id'] )
            {
                str+='<option value="'+data[i]['id']+'"  title="'+data[i]['name']+'">'+data[i]['name']+'</option>';
            }else
            {
                str+='<option value="'+data[i]['id']+'" selected="selected" title="'+data[i]['name']+'">'+data[i]['name']+'</option>';
            }
        }
        $("#province").append(str);
        var form = layui.form;
        form.render('select');
    });
}


/**
 * 获取城市
 * @param provinceID
 */
function getCity( provinceID,cityid )
{
    $.get('/json/city.json',function ( data )
    {
        var str = '';
        for ( var j=0; j<data.length; j++ )
        {
            if( data[j]['provinceid'] == provinceID )
            {
                if( cityid == data[j]['id'] )
                {
                    str+='<option value="'+data[j]['id']+'"  selected="selected" title="'+data[j]['name']+'">'+data[j]['name']+'</option>';
                }else
                {
                    str+='<option value="'+data[j]['id']+'"  title="'+data[j]['name']+'">'+data[j]['name']+'</option>';
                }
            }
        }
        $("#city").append(str);
        var form = layui.form;
        form.render('select');
    });
}

/**
 * 获取区域
 * @param cityID
 */
function getArea( cityID,coucntryid )
{
    $.get('/json/area.json',function ( data )
    {
        var str = '';
        for ( var k=0; k<data.length; k++ )
        {
            if( data[k]['cityid'] == cityID )
            {
                if( coucntryid == data[k]['id'] )
                {
                    str+='<option value="'+data[k]['id']+'" selected="selected" title="'+data[k]['name']+'" >'+data[k]['name']+'</option>';
                }else
                {
                    str+='<option value="'+data[k]['id']+'" title="'+data[k]['name']+'" >'+data[k]['name']+'</option>';
                }
            }
        }
        $("#area").append(str);
        var form = layui.form;
        form.render('select');
    });
}