@extends('server.layout.content')
@section('title','授权')
@section('content')
<div class="main">
<div class="powerwrap">
    <ul class="tabbtnwrap clearfix">
        <li class="li1 on">
            <a href="javascript:;">注册小程序</a>
        </li>
        <li class="li2">
            <a href="javascript:;">小程序授权</a>
        </li>
        <li class="li3">
            <a href="javascript:;">扫码体验</a>
        </li>
    </ul>
    <div class="tabcontentwrap">
        <!--注册小程序-->
        <div class="tabcontent part1">
            <div class="bottomnotice">
                <h2 class="noticetext">小程序注册须知：</h2>
                <div class="noticeitem">
                    <p>1、微信官方规定：用户必须自己进行小程序注册。然后才可以将小程序授权给任意第三方进行设计和代码管理。</p>
                    <p>2、微信官方规定：小程序个人开放的服务类目是有严格规定的，内容不在服务类目中的，是审核不通过的。<a href="http://kf.qq.com/faq/170926eiqeiy170926QJVRje.html" style="color: #1E9FFF">查看详情</a></p>
                    <p>3、微信官网规定：小程序代码审核需要2-7天，结果将通过微信通知。审核通过后，将立即更新到线上。</p>
                    <p>4、小程序审核期间，不影响您在pc端的操作，您可以正常新建项目、活动等。</p>
                </div>
            </div>
            <div class="bottombtn">
                <a href="https://mp.weixin.qq.com/cgi-bin/wx" target="blank" class="layui-btn">注册小程序</a>
                <button class="registbtn layui-btn">已有小程序</button>
            </div>
        </div>
        <!--小程序授权-->
        <div class="tabcontent part2">
            @if( $data && $data->status == 0 )
                <div class="backmessage"><img src="{{pix_asset('server/images/succ.png')}}">&nbsp;授权成功！</div>
            @else
                <p class="tips"><a href="{{route('wx-authorize')}}" class="layui-btn">去授权</a></p>
            @endif
            @if( $data && $data->status == 0 )
                <div class="settingwrap">
                    <ul class="settingwrapul">
                        <li @if( $data->codestatus == 1 ) class="fail" @else  class="success" @endif >
                            <span class="number">1</span>
                            <span class="name">检测用户信息</span>
                            @if( $data->codestatus == 1 ) <a href="{{route('wx-submission')}}">已完善点击提交</a>@endif
                        </li>
                        <li @if( $data->codestatus == 2 ) class="fail" @elseif( $data->codestatus > 2 )  class="success" @endif>
                            <span class="number">2</span>
                            <span class="name">检测类目设置</span>
                            @if( $data->codestatus == 2 ) <a href="{{route('wx-submission')}}">已设置点击提交</a> @endif
                        </li>
                        <li @if( $data->codestatus == 3 ) class="fail" @elseif( $data->codestatus > 3 )  class="success" @endif >
                            <span class="number">3</span>
                            <span class="name">检测服务器域名</span>
                            @if( $data->codestatus == 3 ) <a href="{{route('wx-submission')}}">点击去设置</a> @endif
                        </li>
                        <li @if( $data->codestatus == 4 ) class="fail" @elseif( $data->codestatus > 4 )  class="success" @endif>
                            <span class="number">4</span>
                            <span class="name">上传小程序代码</span>
                            @if( $data->codestatus == 4 ) <a href="{{route('wx-submission')}}">点击上传</a> @endif
                        </li>
                        <li @if( $data->codestatus == 5 ) class="fail" @elseif( $data->codestatus > 5 )  class="success" @endif>
                            <span class="number">5</span>
                            <span class="name">小程序代码审核</span>
                            @if( $data->codestatus == 5 ) <a href="{{route('wx-submission')}}">点击提交</a> @endif
                        </li>
                        <li @if( $data->codestatus == 6 ) class="fail" @elseif( $data->codestatus > 6 )  class="success" @endif>
                            <span class="number">6</span>
                            <span class="name">小程序审核中</span>
                        </li>
                        <li @if( $data->codestatus == 7 ) class="success" @endif>
                            <span class="number">7</span>
                            <span class="name">小程序发布成功</span>
                        </li>
                    </ul>
                </div>
            @endif
             @if( $data && $data->status == 0 )
                @if( $data->codestatus < 6 && $data->errmsg )
                    <div class="backtext">
                        <span>错误原因：</span>{!! $data->errmsg !!}</span>
                   </div>
              @endif
            @endif
            <div class="bottombtn">
                <a href="javascript:;" class="page2last layui-btn">上一步</a>
                @if( $data && $data->codestatus >=6 )
                    <a href="javascript:;" class="hadpower layui-btn">下一步</a>
                @else
                    <a href="javascript:;" class="layui-btn layui-btn layui-btn-disabled">下一步</a>
                @endif
            </div>
        </div>
        <!--扫码关注-->
        <div class="tabcontent part3">
            <ul class="erweimawrapul clearfix">
                <li>
                    <p style="text-align: center">小程序码</p>
                    @if( $data && $data->codestatus ==6 )
                        <div class="erweimawrap"><img src="{{route('wx-experience-code')}}"></div>
                    @else
                        <div class="erweimawrap"><img src="{{url('wx-code')}}/index/null/258"></div>
                    @endif
                </li>
            </ul>
            <div class="bottombtn">
                <a href="javascript:;" class="page3last layui-btn">上一步</a>
            </div>
        </div>
    </div>
</div>
</div>
<input type="hidden" id="msg" value="{{session('msg')}}">
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript">
        layui.use(['form','layer'], function() {
            var layer = layui.layer;
            /**
             * 页面提示
             */
            var msg = $("#msg").val();
            if( msg )
            {
                layer.msg($("#msg").val());
            }
            //小程序流程切换
            $(".page2last").click(function() {
                $(".tabbtnwrap .li1").addClass("on").siblings().removeClass("on");
                $(".tabcontentwrap .part1").css("display", "block").siblings().css("display", "none");
            })
            $(".registbtn,.page3last").click(function() {
                $(".tabbtnwrap .li2").addClass("on").siblings().removeClass("on");
                $(".tabcontentwrap .part2").css("display", "block").siblings().css("display", "none");
            })
            $(".hadpower,.page4last").click(function() {
                $(".tabbtnwrap .li3").addClass("on").siblings().removeClass("on");
                $(".tabcontentwrap .part3").css("display", "block").siblings().css("display", "none");
            })
        });
        /**
         * 表单验证
         */
        if( $(".changeForm").length )
        {
            $(".changeForm").Validform({
                btnSubmit: '#btn_submit',
                tiptype: 1,
                postonce: true,
                showAllError: false,
                tiptype: function (msg, o, cssctl) {
                    if (!o.obj.is("form")) {
                        if (o.type != 2) {
                            var objtip = o.obj.parents('.layui-form-item').find(".layui-input");
                            objtip.addClass('layui-form-danger');
                            cssctl(objtip, o.type);
                            layer.msg(msg, {icon: 5, time: 2000, shift: 6});
                        }
                    }
                }
            });
        }
    </script>
@endsection
