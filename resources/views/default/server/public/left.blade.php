<div class="layui-side-scroll">
    <ul class="layui-nav layui-nav-tree" lay-filter="test">
        @if(session("userInfo")->isadmin==0)
            @if(session("menueInfo")->menue)
                @foreach(session("menueInfo")->menue as $k=>$menue)
                    <li class="layui-nav-item @if($menue["url"])  nav-menu @if(url()->current() == route($menue["url"]) ) layui-this @endif @endif"    @if($menue["url"]) url="{{route($menue["url"])}}" @endif>
                        <a>{{$menue["menuname"]}}</a>
                        @if(array_key_exists("_child",$menue))
                            <dl class="layui-nav-child">
                                @foreach($menue["_child"] as $c=>$child)
                                    <dd class="nav-menu @if(url()->current() == route($child["url"]) )layui-this @endif"  url="@if($child["url"]) {{route($child["url"])}} @endif" >
                                        <a>{{$child["menuname"]}}</a>
                                    </dd>
                                @endforeach
                            </dl>
                        @endif
                    </li>
                @endforeach
            @endif
        @else
            <li class="layui-nav-item"  >
                <a href="javascript:;">活动管理</a>
                <dl class="layui-nav-child" >
                    <dd class="nav-menu @if(url()->current() == route('lucky-index') ) layui-this @endif"  url="{{route('lucky-index')}}"><a>幸运抽奖</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">项目管理</a>
                <dl class="layui-nav-child">
                    <dd class="nav-menu @if(url()->current() == route('site.index') )layui-this @endif"  url="{{route('site.index')}}"><a>项目列表</a></dd>
                    <dd class="nav-menu @if(url()->current() == route('site.create') )layui-this @endif"  url="{{route('site.create')}}"><a>新建项目</a></dd>
                    <dd class="nav-menu @if(url()->current() == route('site-template.index') )layui-this @endif"  url="{{route('site-template.index')}}"><a>阶段模板</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">客户管理</a>
                <dl class="layui-nav-child">
                    <dd class="nav-menu @if(url()->current() == route('client.index') )layui-this @endif"  url="{{route('client.index')}}"><a>预约客户</a></dd>
                    <dd class="nav-menu @if(url()->current() == route('lucky-client') )layui-this @endif"  url="{{route('lucky-client')}}"><a>抽奖客户</a></dd>
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
            <li class="layui-nav-item nav-menu @if(url()->current() == route('company-setting') ) layui-this @endif"  url="{{route('company-setting')}}"><a>资料设置</a></li>
            <li class="layui-nav-item nav-menu @if(url()->current() == route('user-authorize') ) layui-this @endif"  url="{{route('user-authorize')}}"><a>授权信息</a></li>
            <li class="layui-nav-item nav-menu @if(url()->current() == route('mp-send-index') ) layui-this @endif"  url="{{route('mp-send-index')}}"><a>服务通知</a></li>
            <li class="layui-nav-item nav-menu @if(url()->current() == route('store-index') ) layui-this @endif" url="{{route('store-index')}}"><a>门店管理</a></li>
            <li class="layui-nav-item nav-menu @if(url()->current() == route('roles-index') ) layui-this @endif"  url="{{route('roles-index')}}"><a>角色管理</a></li>
            <li class="layui-nav-item nav-menu @if(url()->current() == route('admin-index') ) layui-this @endif"  url="{{route('admin-index')}}"><a>用户管理</a></li>
            <li class="layui-nav-item nav-menu @if(url()->current() == route('data-index') ) layui-this @endif"  url="{{route('data-index')}}"><a>系统属性</a></li>
        @endif
    </ul>
</div>