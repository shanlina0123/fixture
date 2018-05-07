$(".form").Validform({
    btnSubmit:'#btn_submit',
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
});

var oInput = $(".form-data input");
oInput.focus(function () {
    $(this).siblings("label").hide();
});
oInput.blur(function () {
    if($(this).val()==""){
        $(this).siblings("label").show();
    }
});

$(".p-input").find('input').click(function () {
    var o = $(this).parents('.p-input').find(".Validform_checktip");
    o.removeClass('show');
    o.addClass('hide');
});

$(".icon-ok-sign").click(function () {
     if( $(this).hasClass('boxcol') == true )
     {
         $(this).removeClass('boxcol');
         $("input[name='agree']").val('');
     }else
     {
         $(this).addClass('boxcol');
         $("input[name='agree']").val(1);
     }
});