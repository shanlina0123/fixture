@extends('server.layout.content')
@section("title")首页@endsection
@section('content')
    <div class="indexright">
        <p class="pagenotice">云易装操作指引</p>
        <div class="flowWrap">
            <table class="floTable">
                <tr>
                    <td>
                        <div class="bulewrap">
                            <a href="{{route('company-setting')}}" class="circle">完善公司信息</a>
                            <p class="jiantou1"><img src="{{pix_asset('server/images/fordown.png')}}" class="jiantou"></p>
                        </div>
                    </td>
                    <td>
                        <div class="forwidth"></div>
                    </td>
                    <td>
                        <div class="phonewrap">
                            <div class="phoneimg">项目推广</div>
                            <p class="jiantou1 jiantou11"><img src="{{pix_asset('server/images/fortop.jpg')}}" class="jiantou"></p>
                        </div>
                    </td>
                    <td>
                        <div class="phonewrap">
                            <div class="phoneimg">活动推广</div>
                            <p class="jiantou1 jiantou11"><img src="{{pix_asset('server/images/fortop.jpg')}}" class="jiantou"></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="bulewrap">
                            <a href="{{route('user-authorize')}}" class="circle">应用授权</a>
                        </div>
                    </td>
                    <td>
                        <div class="forwidth">
                            <p class="widthtext">如果您是个体用户</p>
                            <img src="{{pix_asset('server/images/fortoright.jpg')}}" class="jiantou">
                        </div>
                    </td>
                    <td>
                        <div class="rightjiantouwrap clearfix">
                            <a href="{{route('site.index')}}" class="circle fl">项目管理</a>
                            <img src="{{pix_asset('server/images/forright.jpg')}}" class="sright fl">
                        </div>
                    </td>
                    <td>
                        <div class="rightjiantouwrap clearfix">
                            <a href="{{route('lucky-index')}}" class="circle fl">活动管理</a>
                            <img src="{{pix_asset('server/images/forright.jpg')}}" class="sright fl">
                        </div>
                    </td>
                    <td>
                        <div class="rightjiantouwrap clearfix">
                            <a href="{{route('client.index')}}" class="circle fl">客户管理</a>
                            <img src="{{pix_asset('server/images/forright.jpg')}}" class="sright fl">
                        </div>
                    </td>
                    <td>
                        <div class="rightjiantouwrap clearfix">
                            <a href="" class="circle fl">消息管理</a>
                            <img src="{{pix_asset('server/images/forright.jpg')}}" class="sright fl">
                        </div>
                    </td>
                    <td>
                        <div class="bulewrap">
                            <a href="" class="circle">数据分析</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="jiantou1"><img src="{{pix_asset('server/images/fordown.png')}}" class="jiantou"></p>
                    </td>
                    <td>
                        <p class="widthtext">如果您是连锁企业</p>
                    </td>
                    <td>
                        <p class="jiantou1"><img src="{{pix_asset('server/images/fortop.jpg')}}" class="jiantou"></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="rightjiantouwrap clearfix">
                            <a href="{{route('roles-index')}}" class="circle yellowcircle fl">角色管理</a>
                        </div>
                    </td>
                    <td>
                        <div class="rightjiantouwrap clearfix">
                            <img src="{{pix_asset('server/images/forright.jpg')}}" class="sright fl">
                            <a href="{{route('store-index')}}" class="circle yellowcircle fl">门店管理</a>
                            <img src="{{pix_asset('server/images/forright.jpg')}}" class="sright fl">
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <!-- <img src="{{pix_asset('server/images/fortop.jpg')}}" class="jiantou"> -->
                            <a href="{{route('admin-index')}}" class="circle yellowcircle">用户管理</a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/index/index.js')}}"></script>
@endsection