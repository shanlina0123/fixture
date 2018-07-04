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
    <title>@yield('title')</title>
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
    <link rel="stylesheet" href="{{pix_asset('server/css/style.css')}}">
    <script type="text/javascript" src="{{pix_asset('server/plugins/jquery/jquery-2.1.4.min.js',false)}}"></script>
    @yield('css')
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
            @yield('content')
        </div>
    </div>
    @yield('other')
</body>
<script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/common/common.js')}}"></script>
{{--<script type="text/javascript" src="{{pix_asset('server/js/public/listen.js')}}"></script>--}}
@yield('js')
</html>