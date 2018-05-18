var upload, $;
layui.use(['form', 'layer', 'jquery', 'laydate', 'upload'], function() {
    var form = layui.form,
        layer = layui.layer,
        laydate = layui.laydate,
        $ = layui.jquery;
    upload = layui.upload;
    //日期
    laydate.render({
        elem: '#startdate'
        ,type: 'datetime'
    });
    laydate.render({
        elem: '#enddate'
        ,type: 'datetime'
    })

    //第一个切换上传
    upload.render({
        elem: '.tab1Upload',
        url: '/uploads/',
        done: function(res) {
            //console.log(res)
        }
    });
    //点击添加奖项设置
    $(".addPrize").click(function() {
        if ($(".priceTable tr").size() < 10) {
            var addTable = $(".priceTable")
            var addtr = $(".defaulttr").prop("outerHTML")
            addTable.append(addtr)
            form.render()
        } else {
            layer.msg("最多添加9个");
        }
    });
    //第三个切换上传图片
    $(".uploadImgWrap").delegate(".uploadImg", "click", function() {
        upload.render({
            elem: '.uploadImg',
            url: '/uploads/',
            done: function(res) {}
        })
    });

    //删除信息
    $(".deleteBtn").click(function(){
        var that=this;
        layer.confirm('确定要删除吗？', {
            btn: ['确定', '取消']
        }, function() {
            $(that).parents("tr").remove();
            layer.msg('删除成功', {
                icon: 1
            });
        });
    });
});