var pName,cName,aName,form,layer,ProvinceJson;
$.get('/default/server/json/city.json',function ( data )
{
    if( data )
    {
        ProvinceJson = data;
        layui.use(['form','layer','upload'], function() {
            var upload = layui.upload;
                form = layui.form;
                layer = layui.layer;

            /**
             * 拖拽上传
             */
            upload.render({
                elem: '#test10',
                exts: "jpg|png|jpeg",
                size: 5120,
                url: '/upload-temp-img',
                before: function (obj) {
                    layer.load(); //上传loading
                }
                , done: function (res) {
                    layer.closeAll('loading'); //关闭loading
                    if( $(".uploadImg").length )
                    {
                        $("#src").attr('src', res.data.src);
                    }else
                    {
                        $("#companyLogo").append('<div class="uploadImg layui-inline fl"><img width="230" height="132" id="src" src="'+res.data.src+'" class="layui-upload-img"> </div>');
                    }
                    $("#logo").val(res.data.name);
                    //console.log(res)
                },
                error: function (index, upload) {
                    layer.closeAll('loading'); //关闭loading
                }
            });

            form.on('select(province)', function (data) {
                $("#city").find("option:not(option:first)").remove();
                $("#area").find("option:not(option:first)").remove();
                pName = data.elem[data.elem.selectedIndex].title;
                getCity(data.elem.value, $("#city").data('cityid'));
                $("#fulladdr").val(pName);
            });
            form.on('select(city)', function (data) {
                $("#area").find("option:not(option:first)").remove();
                cName = data.elem[data.elem.selectedIndex].title;
                $("#fulladdr").val(pName + cName);
                getArea(data.elem.value, $("#area").data('coucntryid'));
            });
            form.on('select(area)', function (data) {
                aName = data.elem[data.elem.selectedIndex].title;
                $("#fulladdr").val(pName + cName + aName);
            });


            getProvince($("#province").data('province'));
            /**
             * 验证是不是传值
             */
            if ($("#province").data('province')) {
                getCity($("#province").data('province'), $("#city").data('cityid'));
            }

            if ($("#city").data('cityid')) {
                getArea($("#city").data('cityid'), $("#area").data('coucntryid'));
            }

            /**
             * 页面提示
             */
            var msg = $("#msg").val();
            if( msg )
            {
                layer.msg($("#msg").val(), {icon: 1, time: 2000, shift: 6});
            }
        });

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
         * 获取省份
         */
        function getProvince(provinceid)
        {
            var str = '';
            $.each(ProvinceJson, function (k,v) {
                if(  provinceid != k )
                {
                    str+='<option value="'+k+'"  title="'+v.name+'">'+v.name+'</option>';
                }else
                {
                    str+='<option value="'+k+'" selected="selected" title="'+v.name+'">'+v.name+'</option>';
                }
            });
            $("#province").append(str);
            form.render('select');
        }


        /**
         * 获取城市
         * @param provinceID
         */
        var cityJson;
        function getCity( provinceID,cityid )
        {
            cityJson = ProvinceJson[provinceID].child;
            var str='';
            $.each( ProvinceJson[provinceID].child, function (k,v) {
                if(  cityid != k )
                {
                    str+='<option value="'+k+'"  title="'+v.name+'">'+v.name+'</option>';
                }else
                {
                    str+='<option value="'+k+'" selected="selected" title="'+v.name+'">'+v.name+'</option>';
                }
            });
            $("#city").append(str);
            form.render('select');
        }

        /**
         * 获取区域
         * @param cityID
         */
        function getArea( cityID,coucntryid )
        {
            var str='';
            $.each( cityJson[cityID].child, function (k,v) {
                if(  coucntryid != k )
                {
                    str+='<option value="'+k+'"  title="'+v+'">'+v+'</option>';
                }else
                {
                    str+='<option value="'+k+'" selected="selected" title="'+v+'">'+v+'</option>';
                }
            });
            $("#area").append(str);
            form.render('select');
        }
    }
});