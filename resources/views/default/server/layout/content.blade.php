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
    <link rel="icon" href="../../images/icon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--css-->
    <link rel="stylesheet" href="{{asset('default/server/css/common.css')}}">
    <link rel="stylesheet" href="{{asset('default/server/plugins/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('default/server/css/base.css')}}">
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
</body>
<script type="text/javascript" src=="{{asset('default/server/plugins/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('default/server/plugins/jquery/jquery-2.1.4.min.js')}}"></script>
@yield('js')
</html>