$(function(){
    var form = layui.form;
    var upload = layui.upload;

    var layer = parent.layer === undefined ? layui.layer : parent.layer,
        laypage = layui.laypage,
        layedit = layui.layedit,
        laydate = layui.laydate,
        $ = layui.jquery;
    //创建一个编辑器
    var editIndex = layedit.build('news_content');
    var addNewsArray = [],addNews;


    //全选
    form.on('checkbox(allChoose)', function(data){
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        child.each(function(index, item){
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });

    //设置是否公开
    form.on('switch(isShow)', function (data) {
        var index = layer.msg('设置中，请稍候', {icon: 16, time: false, shade: 0.8});
        //post url
        var $url=$(this).data("url");
        //post param
        var $uuid=data.elem.parentElement.parentElement.id;
        var $isopen=$(this).data("open-value");
        setTimeout(function () {
            $.ajax({
                url : $url,
                type : "post",
                data:{uuid:$uuid,isopen:$isopen},
                dataType : "json",
                success : function(data){
                    layer.msg(data.msg);
                }
            })
            layer.close(index);
        }, 1000);
    });

    //预览活动
    //改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
    $(window).one("resize",function(){
        $(".audit_btn").click(function(){
            var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]');
            var $uuid=$('.news_list tbody [type=checkbox]:checked').val()
            var $url=$(this).data("url").slice(0,-1)+$uuid;
            if($checkbox.is(":checked")){
                var index = layui.layer.open({
                    title : "活动预览",
                    type : 2,
                    content : $url,
                    success : function(layero, index){
                        setTimeout(function(){
                            layui.layer.tips('点击此处返回活动列表', '.layui-layer-setwin .layui-layer-close', {
                                tips: 3
                            });
                        },500)
                    }
                })
                layui.layer.full(index);
            }else{
                layer.msg("请选择需要预览的活动");
            }
        });

        //创建活动
        $(".newsAdd_btn").click(function(){
            var $url=$(this).data("url");
            var index = layui.layer.open({
                title : "创建活动",
                type : 2,
                content : $url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回活动列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            })
            layui.layer.full(index);
        })
    }).resize();



    //执行创建活动
    form.on("submit(addNews)",function(data){
        //是否添加过信息
        if(window.sessionStorage.getItem("addNews")){
            addNewsArray = JSON.parse(window.sessionStorage.getItem("addNews"));
        }
        //显示、审核状态
        var isShow = data.field.show=="on" ? "checked" : "",
            newsStatus = data.field.shenhe=="on" ? "审核通过" : "待审核";

        addNews = '{"newsName":"'+$(".newsName").val()+'",';  //文章名称
        addNews += '"newsId":"'+new Date().getTime()+'",';	 //文章id
        addNews += '"newsLook":"'+$(".newsLook option").eq($(".newsLook").val()).text()+'",'; //开放浏览
        addNews += '"newsTime":"'+$(".newsTime").val()+'",'; //发布时间
        addNews += '"newsAuthor":"'+$(".newsAuthor").val()+'",'; //文章作者
        addNews += '"isShow":"'+ isShow +'",';  //是否展示
        addNews += '"newsStatus":"'+ newsStatus +'"}'; //审核状态
        addNewsArray.unshift(JSON.parse(addNews));
        window.sessionStorage.setItem("addNews",JSON.stringify(addNewsArray));
        //弹出loading
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            top.layer.close(index);
            top.layer.msg("活动添加成功！");
            layer.closeAll("iframe");
            //刷新父页面
            parent.location.reload();
        },2000);
        return false;
    })


    /**
     * 拖拽上传图片
     */
    upload.render({
        elem: '#test10',
        exts:"jpg|png|jpeg",
        size:5120,
        url: '/upload-temp-img',
        before: function(obj)
        {
            layer.load(); //上传loading
        },done: function(res)
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


});

