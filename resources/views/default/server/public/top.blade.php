<div class="layui-logo"><img src="{{pix_asset('server/images/topLogo.png')}}"></div>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item">
        <a href="{{route('vip-index')}}" title="会员中心"><img src="{{pix_asset('server/images/user.png')}}" width="32"></a>
    </li>
    <li class="layui-nav-item">
        <a href="{{route('notice-index')}}" title="通知消息"><img src="{{pix_asset('server/images/notice.png')}}" width="32"><span class="layui-badge-dot" style="position: relative; top: -3px; left: -3px;"></span></a>
    </li>
    <li class="layui-nav-item">
        <a href="../notice/askNotice.html" title="咨询消息"><img src="{{pix_asset('server/images/message.png')}}" width="32"><span class="layui-badge-dot" style="position: relative; top: -3px; left: -3px;"></span></a>
    </li>
    <li class="layui-nav-item">
        <a href="javascript:;">
            <img src="{{pix_asset('server/images/default.png')}}" class="layui-nav-img">管理员
        </a>
        <dl class="layui-nav-child">
            <dd><a href="{{route('user-info')}}">个人资料</a></dd>
            <dd><a href="{{route('set-pass')}}">修改密码</a></dd>
            <dd><a href="{{route('signout')}}">退出系统</a></dd>
        </dl>
    </li>
</ul>
