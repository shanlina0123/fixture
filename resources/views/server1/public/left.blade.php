<div class="layui-side layui-bg-black">
    <div class="user-photo">
        <a class="img" title="我的头像" ><img src="images/face.jpg"></a>
        <p>你好！<span class="userName">请叫我马哥</span>, 欢迎登录</p>
    </div>
    <div class="navBar layui-side-scroll">
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item">
                <a href="javascript:;" data-url="{{route('company-setting')}}">
                    <i class="layui-icon" style="font-size: 16px;" data-icon="&#xe620">&#xe620;</i>
                    <cite>基本设置</cite>
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <i class="layui-icon" data-icon=""></i>
                    <cite>项目管理</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('activity.index')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>活动管理</cite>
                        </a>
                    </dd>
                </dl>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('site.index')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>工地管理</cite>
                        </a>
                    </dd>
                </dl>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('client.index')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>客户预约</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <i class="layui-icon" data-icon=""></i>
                    <cite>阶段模板</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('site-template.index')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>模板列表</cite>
                        </a>
                    </dd>
                </dl>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('site-template.create')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>新建模板</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <i class="layui-icon" data-icon=""></i>
                    <cite>系统设置</cite>
                    <span class="layui-nav-more"></span>
                </a>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('filter-store-index')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>门店管理</cite>
                        </a>
                    </dd>
                </dl>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{route('filter-role-index')}}">
                            <i class="layui-icon" data-icon=""></i>
                            <cite>角色管理</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <span class="layui-nav-bar" style="top: 112.5px; height: 0px; opacity: 0;"></span>
        </ul>
    </div>
</div>