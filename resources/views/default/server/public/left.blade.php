<div class="layui-side-scroll">
    <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item">
            <a href="javascript:;">活动管理</a>
            <dl class="layui-nav-child">
                <dd><a href="">宣传活动</a></dd>
                <dd><a href="../activity/lucky.html">幸运抽奖</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item">
            <a href="javascript:;">项目管理</a>
            <dl class="layui-nav-child">
                <dd><a href="{{route('site.index')}}">项目列表</a></dd>
                <dd><a href="{{route('site.create')}}">新建项目</a></dd>
                <dd><a href="../project/modelList.html">阶段模板</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item">
            <a href="javascript:;">客户管理</a>
            <dl class="layui-nav-child">
                <dd><a href="../client/clientList.html">预约客户</a></dd>
                <dd><a href="../client/luckClientList.html">抽奖客户</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item">
            <a href="javascript:;">数据分析</a>
            <dl class="layui-nav-child">
                <dd><a href="">数据概览</a></dd>
                <dd><a href="">客户分析</a></dd>
                <dd><a href="">工地分析</a></dd>
                <dd><a href="">营销排行</a></dd>
                <dd><a href="">活动分析</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="../message/message.html">资料设置</a></li>
        <li class="layui-nav-item"><a href="{{route('roles-index')}}">角色管理</a></li>
        <li class="layui-nav-item"><a href="../store/storeList.html">门店管理</a></li>
        <li class="layui-nav-item"><a href="../users/userList.html">用户管理</a></li>
        <li class="layui-nav-item"><a href="../system/settingList.html">系统属性</a></li>
    </ul>
</div>