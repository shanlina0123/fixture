<div class="layui-logo"><a href="{{route('index')}}"><img src="{{pix_asset('server/images/topLogo.png')}}"></a></div>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item" >
        <a href="javascript:;" style="padding: 0 15px;">
            <img src="{{pix_asset('admin/images/default.png')}}" class="layui-nav-img" >{{session("adminInfo")->username}}
        </a>
        <dl class="layui-nav-child">
            <dd class="nav-menu"  url="{{route('set-pass')}}"><a>修改密码</a></dd>
            <dd> <a href="{{route('signout')}}">退出系统</a></dd>
        </dl>
    </li>
</ul>
