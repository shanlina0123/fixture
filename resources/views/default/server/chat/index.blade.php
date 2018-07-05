<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>云易装-聊天室</title>
    <style>
        *, *:before, *:after {
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            overflow: hidden;
        }
        body, ul {
            margin: 0;
            padding: 0;
        }
        body {
            color: #4d4d4d;
            font: 14px/1.4em 'Helvetica Neue', Helvetica, 'Microsoft Yahei', Arial, sans-serif;
            background: #f5f5f5 url('{{pix_asset('server/images/chatbg.jpg')}}') no-repeat center;
            background-size: cover;
            font-smoothing: antialiased;
        }
        ul {
            list-style: none;
        }
        #chat {
            margin: 20px auto;
            width: 800px;
        	height: 600px;
        }
    </style>
</head>
<body >
<div id="dashboard" style="display: none"></div>
<input type="hidden" id="init-url" value="{{route('chat-init')}}" />
<input type="hidden" id="login-url" value="{{route('chat-login')}}" />
<input type="hidden" id="main-js" value="{{pix_asset('server/js/chat/main.js')}}" />
<div id="chat"></div>
<script type="text/javascript" src="{{pix_asset('server/plugins/jquery/jquery-2.1.4.min.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/vue/vue.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/plugins/chat/jmessage-sdk-web.2.6.0.min.js',false)}}"></script>
<script type="text/javascript" src="{{pix_asset('server/js/chat/main.js')}}"></script>

</body>
</html>
