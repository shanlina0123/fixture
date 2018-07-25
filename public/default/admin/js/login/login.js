layui.use(['element','layer','form'], function() {
    var element = layui.element;
    var layer = layui.layer;
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("form").keyup(function(event){
    if(event.keyCode ==13){
        var tosubid=$(this).attr("tosubid")
        $("#btn_submit"+tosubid).trigger("click");
    }
});

$(".form1").Validform({
    btnSubmit:'#btn_submit1',
    postonce: true,
    showAllError: false,
    tiptype: function (msg, o, cssctl)
    {
        if ( !o.obj.is("form") )
        {
            if(  o.type !=2 )
            {
                var objtip = o.obj.parents(".loginInner").find('.loginError');
                cssctl(objtip, o.type);
                objtip.text(msg);
                $(".errorWrap").show();
            }else
            {
                var objtip = o.obj.parents(".loginInner").find('.loginError');
                cssctl(objtip, o.type);
                objtip.text('');
                $(".errorWrap").hide();
            }
        }
    }
});

