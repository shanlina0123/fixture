$(".account_number").click(function (){
    $(".message").removeClass('on');
	$(this).addClass('on');
    $(".form1").removeClass('hide');
    $(".form2").addClass('hide');
});

$(".message").click(function (){
    $(".account_number").removeClass('on');
    $(this).addClass('on');
    $(".form2").removeClass('hide');
    $(".form1").addClass('hide');
});


var oInput = $(".form input");
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
});