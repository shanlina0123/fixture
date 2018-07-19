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
    <title>云易装-对话聊天</title>
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
    <link rel="stylesheet" href="{{pix_asset('server/css/chat.css')}}">
</head>
@if(!$errorMsg)
    <body>
    <div class="dwrap">
        <div class="dialogwrap clearfix">
            <div class="sidebar">
                <div class="m-card">
                    <header class="clearfix" ><img class="avatar fl" width="40" height="40" alt="Coffce" src="{{$list["user"]["faceimg"]}}">
                        <p class="name fl">{{$list["user"]["nickname"]}}</p>
                    </header>
                    <footer><input class="search" placeholder="搜索"></footer>
                </div>
                <div class="m-list">
                    <ul>
                        @foreach($list["friend"] as $k=>$item)
                            <li class="clearfix" jguser="{{$item["username"]}}">
                                <img class="avatar fl" width="30" height="30" alt="{{$item["nickname"]}}" src="{{$item["faceimg"]}}">
                                <p class="name fl" title="{{$item["nickname"]}}">{{$item["nickname"]}}</p>
                                {{--<span class=""></span>--}}
                                {{--<a href="javascript:;" class="deleteli">删除对话</a>--}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--如果没有对话消息给main添加nomsg的样式-->
            <div class="main nomsg">
                <div class="hasmeg hide">
                    <div class="mainuser" ><span></span></div>
                    <div class="m-message">
                        <ul id="m-message-ul">
                        </ul>
                    </div>
                    <div class="bottom">
                        <!-- <div class="handlewrap clearfix">
                            <img src="../../images/4.png" class="fl">
                            <div class="uploadwrap fl">
                                <input type="file" class="uploadinput">
                                <img src="../../images/5.png">
                            </div>
                        </div> -->
                        <div class="insearwrap">
                            <textarea placeholder="按 Enter 发送"></textarea>
                        </div>
                        <div class="sendbtnwrap ">
                            <p class="notice hide">不能发送空白消息</p>
                            <button>发送</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="appkey" value="{{$list["init"]->appkey}}"/>
    <input type="hidden" id="random_str" value="{{$list["init"]->random_str}}"/>
    <input type="hidden" id="signature" value="{{$list["init"]->signature}}"/>
    <input type="hidden" id="timestamp" value="{{$list["init"]->timestamp}}"/>
    <input type="hidden" id="flag" value="{{$list["init"]->flag}}"/>
    <input type="hidden" id="username" value="{{$list["user"]["username"]}}"/>
    <input type="hidden" id="password" value="{{$list["user"]["password"]}}"/>
    <input type="hidden" id="chat-message" value="{{route('chat-message')}}"/>
    <input type="hidden" id="sendfail-img" value="{{pix_asset('server/images/sendfail.png')}}"/>
    <input type="hidden" id="default-faceimg" value="{{config("jmessage.defaultfaceimg")}}"/>
    </body>
    <script type="text/javascript" src="{{pix_asset('server/plugins/jquery/jquery-2.1.4.min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/plugins/chat/jmessage-sdk-web.2.6.0.min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/chat/main.js')}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/chat/chat.js')}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/chat/jg.js')}}"></script>
@else
    <body>
    <div class="dwrap">
        <div  id="errorMsg" content="{{$errorMsg}}"></div>
    </div>
    </body>
    <script type="text/javascript" src="{{pix_asset('server/plugins/layui/layui.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/chat/err.js')}}"></script>
@endif
</html>