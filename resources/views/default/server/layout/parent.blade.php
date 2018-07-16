<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]>
<!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>云易装管理端</title>
    <link rel="icon" href="{{pix_asset('server/images/icon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--去除缓存 start-->
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="">
    <!--css-->
    <link rel="stylesheet" href="{{pix_asset('server/plugins/layui/css/layui.css',false)}}">
    <link rel="stylesheet" href="{{pix_asset('server/css/common.css')}}">
    <link rel="stylesheet" href="{{pix_asset('server/css/base.css')}}">
    <script type="text/javascript" src="{{pix_asset('server/plugins/jquery/jquery-2.1.4.min.js',false)}}"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <!--顶部导航-->
    <div class="layui-header" id="header">
        @include('server.public.top')
    </div>
    <!--左侧导航-->
    <div class="layui-side layui-bg-black" id="left">
        @include('server.public.left')
    </div>
    <div class="layui-body">
        @if(!session("userInfo")->companyid && session("userInfo")->isadmin == 1 )
            <iframe name="iframeMain" id="iframeMain" src="{{route('company-setting')}}" scrolling="yes" frameborder="0" width="100%" height="100%" firsturl="{{route('index-content')}}">
                该浏览器不支持iframe，请使用其他浏览器！
            </iframe>
        @elseif(session("userInfo")->companyid &&(!session("userInfo")->phone))
            <iframe name="iframeMain" id="iframeMain" src="{{route('user-info')}}" scrolling="yes" frameborder="0" width="100%" height="100%" firsturl="{{route('index-content')}}">
                该浏览器不支持iframe，请使用其他浏览器！
            </iframe>
        @else
            <iframe name="iframeMain" id="iframeMain" src="{{route('index-content')}}" scrolling="yes" frameborder="0" width="100%" height="100%" firsturl="{{route('index-content')}}">
                该浏览器不支持iframe，请使用其他浏览器！
            </iframe>
        @endif
        <!--iframe框自适应js-->
        <script type="text/javascript">
            function changeFrameHeight(){
                var ifm= document.getElementById("iframeMain");
                ifm.height=document.documentElement.clientHeight;
            }
            window.onresize=function(){
                changeFrameHeight();
            }
        </script>
    </div>
</div>
<!--分享功能-->
<div class="sharewrap" title="分享">
    <img src="{{pix_asset('server/images/share.png')}}">
</div>
<ul class="sharepop clearfix">
    <li>
        <p>小程序码</p>
        <a href="{{url('wx-code')}}/index/null/258" download="小程序二维码"><img src="{{url('wx-code')}}/index/null/258"></a>
    </li>
</ul>
<input type="hidden" id="sessionTmp" data-companyid="{{session("userInfo")->companyid}}" data-isadmin="{{session("userInfo")->isadmin}}"  data-phone="{{session("userInfo")->phone}}" />
<input type="hidden"  id="sessionUrl" data-company="{{route('company-setting')}}"  data-user="{{route('user-info')}}"/>
</body>
<script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/common/base.js')}}"></script>
{{--<script type="text/javascript" src="{{pix_asset('server/js/public/listen.js')}}"></script>--}}
</html>