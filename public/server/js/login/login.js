layui.use(['element'], function() {
   var element = layui.element;
});

$(".form1").Validform({
    btnSubmit:'#btn_submit1',
    //tiptype:1,
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if( o.type != 2 )
            {
                var objtip = $(".Validform_checktip");
                objtip.addClass('Validform_error');
                objtip.find('span').text(msg);
            }else
            {
               // var objtip = o.obj.parents('.p-input').find(".Validform_checktip");
            }
        }
    }
});

/*
$(".form2").Validform({
    btnSubmit:'#btn_submit2',
    //tiptype:1,
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if( o.type != 2 )
            {
                var objtip = o.obj.parents('.p-input').find(".Validform_checktip");
                objtip.removeClass('hide');
                objtip.addClass('show');
                cssctl(objtip, o.type);
                objtip.find('span').text(msg);
            }else
            {
                var objtip = o.obj.parents('.p-input').find(".Validform_checktip");
                objtip.removeClass('show');
                objtip.addClass('hide');
            }
        }
    }
});*/
