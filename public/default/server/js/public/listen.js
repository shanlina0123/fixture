var ListenTimeout = false; //启动及关闭按钮
var outListenTime=5000;
time();
function time()
{
    if(ListenTimeout) return;
    getListen();
    setTimeout(time,outListenTime); //time是指本身,延时递归调用自己,100为间隔调用时间,单位毫秒
}

function getListen() {
    //监听通知notice的小红点
    var listen=$("#notice-listen");
    var url=listen.attr("url");
    var red=$(".layui-badge-dot",listen);
    $.getJSON(url,null,function(data){
        if(data.status==1)
        {
            if(data.data>0){
                red.show();
            }else{
                red.hide();
                outListenTime=8000;
            }
        }else{
            red.hide();
            outListenTime=8000;
        }
    })
}