<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="{{asset('plugins/layui/css/layui.css')}}" media="all" />
    <link rel="stylesheet" href="{{asset('css/server/font.css')}}" media="all" />
    <link rel="stylesheet" href="{{asset('css/server/main.css')}}" media="all" />
</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    @include('server.public.top')
    <!-- 左侧导航 -->
    @include('server.public.left')
    <!-- 右侧内容 -->
    @include('server.public.right')
    <!-- 底部 -->
    @include('server.public.footer')
</div>
<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>
<script type="text/javascript" src="{{asset('plugins/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('js/server/index.js')}}"></script>
</body>
</html>