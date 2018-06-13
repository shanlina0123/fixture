

<div class="layui-side-scroll">
    <ul class="layui-nav layui-nav-tree" lay-filter="test">
        @if(session("userInfo")->isadmin==0)
            @if(session("userInfo")->menue)
                @foreach(session("userInfo")->menue as $k=>$menue)
                    <li class="layui-nav-item @if($menue["url"]) @if(url()->current() == route($menue["url"]) ) layui-this @endif" @endif>
                        <a href="@if($menue["url"]){{route($menue["url"])}}@else javascript:; @endif">{{$menue["menuname"]}}</a>
                        @if(array_key_exists("_child",$menue))
                            <dl class="layui-nav-child">
                                @foreach($menue["_child"] as $c=>$child)
                                    <dd @if(url()->current() == route($child["url"]) ) class="layui-this" @endif>
                                        <a href="@if($child["url"]){{route($child["url"])}}@else javascript:; @endif" >{{$child["menuname"]}}</a>
                                    </dd>
                                @endforeach
                            </dl>
                        @endif
                    </li>
                @endforeach
            @endif
        @else
            <li class="layui-nav-item">
                <a href="javascript:;">活动管理</a>
                <dl class="layui-nav-child">
                    <dd @if(url()->current() == route('lucky-index') ) class="layui-this" @endif><a href="{{route('lucky-index')}}">幸运抽奖</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">项目管理</a>
                <dl class="layui-nav-child">
                    <dd @if(url()->current() == route('site.index') ) class="layui-this" @endif><a href="{{route('site.index')}}">项目列表</a></dd>
                    <dd @if(url()->current() == route('site.create') ) class="layui-this" @endif><a href="{{route('site.create')}}">新建项目</a></dd>
                    <dd @if(url()->current() == route('site-template.index') ) class="layui-this" @endif><a href="{{route('site-template.index')}}">阶段模板</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">客户管理</a>
                <dl class="layui-nav-child">
                    <dd @if(url()->current() == route('client.index') ) class="layui-this" @endif><a href="{{route('client.index')}}">预约客户</a></dd>
                    <dd @if(url()->current() == route('lucky-client') ) class="layui-this" @endif><a href="{{route('lucky-client')}}">抽奖客户</a></dd>
                </dl>
            </li>
            {{--<li class="layui-nav-item">--}}
            {{--<a href="javascript:;">数据分析</a>--}}
            {{--<dl class="layui-nav-child">--}}
            {{--<dd><a href="">数据概览</a></dd>--}}
            {{--<dd><a href="">客户分析</a></dd>--}}
            {{--<dd><a href="">工地分析</a></dd>--}}
            {{--<dd><a href="">营销排行</a></dd>--}}
            {{--<dd><a href="">活动分析</a></dd>--}}
            {{--</dl>--}}
            {{--</li>--}}
            <li class="layui-nav-item @if(url()->current() == route('company-setting') ) layui-this @endif"><a href="{{route('company-setting')}}">资料设置</a></li>
            <li class="layui-nav-item @if(url()->current() == route('user-authorize') ) layui-this @endif"><a href="{{route('user-authorize')}}">授权信息</a></li>
            <li class="layui-nav-item @if(url()->current() == route('store-index') ) layui-this @endif"><a href="{{route('store-index')}}">门店管理</a></li>
            <li class="layui-nav-item @if(url()->current() == route('roles-index') ) layui-this @endif"><a href="{{route('roles-index')}}">角色管理</a></li>
            <li class="layui-nav-item @if(url()->current() == route('admin-index') ) layui-this @endif"><a href="{{route('admin-index')}}">用户管理</a></li>
            <li class="layui-nav-item @if(url()->current() == route('data-index') ) layui-this @endif"><a href="{{route('data-index')}}">系统属性</a></li>
        @endif
    </ul>
</div>