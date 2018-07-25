<div class="layui-side-scroll">
    <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item nav-menu @if(url()->current() == route('index-content') ) layui-this @endif"  url="{{route('index-content')}}"><a>控制面板</a></li>
        <li class="layui-nav-item"  >
            <a href="javascript:;">订单管理</a>
            <dl class="layui-nav-child" >
                <dd class="nav-menu @if(url()->current() == route('order-index') ) layui-this @endif"  url="{{route('order-index')}}"><a>在线订单</a></dd>
                <dd class="nav-menu @if(url()->current() == route('order-entity-index') ) layui-this @endif"  url="{{route('order-entity-index')}}"><a>线下订单</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item"  >
                <a href="javascript:;">商户管理</a>
                <dl class="layui-nav-child" >
                    <dd class="nav-menu @if(url()->current() == route('used-index') ) layui-this @endif"  url="{{route('used-index')}}"><a>免费版</a></dd>
                    <dd class="nav-menu @if(url()->current() == route('used-fee-index') ) layui-this @endif"  url="{{route('used-free-index')}}"><a>标准版</a></dd>
                    <dd class="nav-menu @if(url()->current() == route('used-entity-index') ) layui-this @endif"  url="{{route('used-entity-index')}}"><a>定制版</a></dd>
                </dl>
            </li>
        <li class="layui-nav-item nav-menu @if(url()->current() == route('user-index') ) layui-this @endif"  url="{{route('user-index')}}"><a>用户管理</a></li>
        <li class="layui-nav-item nav-menu @if(url()->current() == route('admin-index') ) layui-this @endif"  url="{{route('admin-index')}}"><a>账号设置</a></li>
    </ul>
</div>