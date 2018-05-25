@extends('server.layout.content')
@section("title")消息管理@endsection
@section('content')
    <div class="main">
        <div class="toppart clearfix">
            <img src="{{pix_asset('server/images/wxmessage.png')}}" class="leftimg fl" width="101" height="101">
            <div class="righttext fl">
                <div class="bottomBtns">
                    <a href="https://mpkf.weixin.qq.com/cgi-bin/kfloginpage" class="btnlink" target="_blank">登录客服系统</a>
                    <a href="https://mp.weixin.qq.com/ " class="btnlink" target="_blank">绑定客服</a>
                    <a href="https://mp.weixin.qq.com/ " class="btnlink" target="_blank">帮助</a>
                </div>
            </div>
        </div>
        <div class="bottomnotice">
            <p class="warmnotice">温馨提示：</p>
            <div class="noticeitem">
                <p>1、小程序需要绑定客服账号才能接受客户咨询消息</p>
                <p>2、如果您还未绑定客服微信，请登录【绑定客服】按钮微信小程序-绑定客服-点击添加（最多可添加100个客服人员）</p>
                <p>3、如果您已经绑定客服账号，请点击【登录客服系统】按钮</p>
                <p>4、详细操作请点击本页【帮助】查看相关文档按钮</p>
            </div>
        </div>
    </div>
@endsection