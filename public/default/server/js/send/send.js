layui.use(['form', 'jquery', 'layer'], function() {
    var form = layui.form,
        $ = layui.jquery,
        layer = layui.layer;
    $(".sharewrap,.auth").click(function() {
        //获取appid和密钥进行判断
        var appid = $("#union_wechat_mp_appid").val();
        var appsecret = $("#union_wechat_mp_appsecret").val();
        if( appid == false)
        {
            layer.msg('请填写APPID');
            return;
        }
        if( appsecret == false)
        {
            layer.msg('请填写APP秘钥');
            return;
        }
        var url = $(this).attr('data-url');
        var obj={
            "union_wechat_mp_appid":appid,
            "union_wechat_mp_appsecret":appsecret
        };
        $.post(url,obj,function (data) {
            if(data.status == 1)
            {
                layer.alert(data.messages,function () {
                    location = location;
                });

            }else
            {
                layer.msg(data.messages);
            }
        },'json');
    });
    $(".applywrap .ask").click(function() {
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        layer.open({
            type: 1,
            title: '申请模板',
            skin: 'layui-layer-rim',
            area: ['400px', '200px'],
            btn: ['提交', '取消'],
            btnAlign: 'c',
            content: $('.applyPop'),
            yes: function(){
                var modelid = $("#modelid").val();
                if( modelid == false )
                {
                    layer.msg('请填写模板ID');
                    return;
                }else
                {
                    var obj={
                        "mptemplateid":modelid,
                        "datatemplateid":id
                    };
                    $.post(url,obj,function (data) {
                        if(data.status == 1)
                        {
                            if( data.data.isOpenid == 0 )
                            {
                                layer.closeAll();
                                var i;
                                $("#src").attr('src','https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='+data.data.ticket);
                                //弹出
                                layer.open({
                                    type: 1,
                                    closeBtn: 1,
                                    title: false,
                                    shadeClose: true,
                                    content: $('.sharepop'),
                                    cancel: function(){
                                        clearInterval(i);
                                    }
                                });
                                var url = '/mp/send/authorize/back';
                                i= checkOpenid(url,data.data.backStr);
                            }else
                            {
                                location = location;
                            }
                        }else
                        {
                            layer.msg(data.messages);
                        }
                    },'json');
                }
            }
        });
    });
    $(".applywrap .tip").click(function() {
        layer.msg('授权完成才可申请');
    });
    $(".applywrap .isadmin").click(function() {
        layer.msg('管理员未绑定微信公众号服务通知，绑定后您可进行申请此模板为自己的通知模板',{time:5000});
    });

    /**
     * 监听指定开关
     * 非管理员添加模板
     */
    form.on('switch(addUserTemplate)', function(data){
        var mpstatus = data.elem.checked?1:0;
        var datatemplateid = $(data.elem).attr('data-datatemplateid');
        var companytempid = $(data.elem).attr('data-companytempid');
        var url = $(data.elem).attr('data-url');
        $.post(url,{'datatemplateid':datatemplateid,'companytempid':companytempid,'mpstatus':mpstatus},function (res) {
            if(res.status==1)
            {
                if( res.data && res.data.isOpenid == 0 )
                {
                    var i;
                    $(data.elem).removeAttr('checked');
                    form.render();
                    layer.closeAll();
                    $("#src").attr('src','https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='+res.data.ticket);
                    layer.open({
                        type: 1,
                        closeBtn: 1,
                        title: false,
                        shadeClose: true,
                        content: $('.sharepop'),
                        cancel: function(){
                            clearInterval(i);
                        }
                    });
                    var url = '/mp/send/authorize/back';
                    i = checkOpenid(url,res.data.backStr);
                }else
                {
                    layer.msg(res.messages);
                }
            }else
            {
                layer.msg(res.messages);
            }
        },'json');
    });
});
/**
 * 检测openid
 */
var num=0;
function checkOpenid(url,data)
{
    var i = setInterval(function()
    {
        num++;
        $.post(url,{'str':data},function(data){
            if( data == 'success' )
            {
                clearInterval(i);
                window.location = location;
            }
        });
        if ( num > 100 )
        {
            clearInterval(i);
            window.location = location;
        }
    }, 3000);
    return i;
}