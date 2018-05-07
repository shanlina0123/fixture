//相册层
$.getJSON('test/photos.json?v='+new Date, function(json){
    layer.photos({
        photos: json //格式见API文档手册页
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
    });
});