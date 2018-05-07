<div class="layui-logo"><img src="{{asset('server/images/logo.png')}}"></div>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item">
        <a href="../users/userCenter.html" title="会员中心"><img src="{{asset('server/images/user.png')}}" width="32"></a>
    </li>
    <li class="layui-nav-item">
        <a href="../notice/notice.html" title="通知消息"><img src="{{asset('server/images/notice.png')}}" width="32"><span class="layui-badge-dot" style="position: relative; top: -3px; left: -3px;"></span></a>
    </li>
    <li class="layui-nav-item">
        <a href="../notice/askNotice.html" title="咨询消息"><img src="{{asset('server/images/message.png')}}" width="32"><span class="layui-badge-dot" style="position: relative; top: -3px; left: -3px;"></span></a>
    </li>
    <li class="layui-nav-item">
        <a href="javascript:;">
            <img src="{{asset('server/images/default.png')}}" class="layui-nav-img">管理员
        </a>
        <dl class="layui-nav-child">
            <dd><a href="../index/userMessage.html">个人资料</a></dd>
            <dd><a href="../index/changePwd.html">修改密码</a></dd>
            <dd><a href="../../login.html">退出系统</a></dd>
        </dl>
    </li>
</ul>