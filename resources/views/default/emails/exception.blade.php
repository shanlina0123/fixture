<html>
<head>
    <title>系统异常，请及时维护！</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>
<body>
<h1 style="border-bottom-color:#cccccc;border-bottom-width:2px;border-bottom-style:solid;padding:5px 4px 5px 0px;margin:0px 0px 10px;overflow: hidden">
    <span style="color:#e36c09;float: left">[系统异常]</span>
    <img src="{{pix_asset('server/images/logoblue.png')}}"  width="134" height="48" style="float: right"/>
</h1>
<h3 style="white-space: normal;margin: 0 0 !important;">
    <span style="color: rgb(227, 108, 9); font-size: 20px;">作者：</span>
</h3>
<ul style="padding: 0 0 !important;">
    <li style="list-style-type:none;">
        <p>
            提交者：{{$html["opt"]}}
        </p>
    </li>
    <li  style="list-style-type:none;">
        <p>
            处理者：{{$html["deal"]}}
        </p>
    </li>
</ul>
<h3 style="white-space: normal;margin: 0 0 !important;">
    <span style="color: rgb(227, 108, 9); font-size: 20px;">错误信息：</span>
</h3>
<ul style="padding: 0 0 !important;">
    <li  style="list-style:none;list-style-type:none;">
        <p>
            message：{{$html["message"]}}
        </p>
    </li>
    <li  style="list-style:none;list-style-type:none;">
        <p>
            code：{{$html["code"]}}
        </p>
    </li>
    <li  style="list-style:none;list-style-type:none;">
        <p>
            file：{{$html["file"]}}
        </p>
    </li>
    <li  style="list-style:none;list-style-type:none;">
        <p>
            line：{{$html["line"]}}
        </p>
    </li>
</ul>
<h3 style="white-space: normal;margin: 14px 0 !important;">
    <span style="color: rgb(227, 108, 9); font-size: 20px;">异常内容：</span>
</h3>
 {!!$html["content"]!!}
</body>
</html>