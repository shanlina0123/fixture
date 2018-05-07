<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="{{asset('plugins/layui/css/layui.css')}}" media="all" />
    <link rel="stylesheet" href="{{asset('css/server/font.css')}}" media="all" />
    <link rel="stylesheet" href="{{asset('css/server/page.css')}}" media="all" />
    @yield('css')
</head>
<body class="childrenBody">
    @yield('content')
</div>
<script src="{{asset('js/public/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/server/public.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/layui2.5/layui.all.js')}}"></script>
@yield('js')
</body>
</html>