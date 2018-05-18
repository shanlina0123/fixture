@extends('server.layout.content')
@section('title','授权')
@section('content')
<div class="main">
    <div class="toppart clearfix">
        @if( $data && $data->head_img )
            <img src="{{$data->head_img}}" class="leftimg fl">
        @else
            <img src="{{pix_asset('server/images/wx.png')}}" class="leftimg fl">
        @endif
        <div class="righttext fl">
            <div class="topname">小程序名称：{{$data?$data->principal_name:'小程序'}}</div>
            <div class="bottomBtns">
                @if( $data == false || $data->status == 1 )
                    <a href="{{route('wx-authorize')}}" class="btnlink">授权</a>
                @else
                    <a href="javascript:;" class="btnlink">已授权</a>
                @endif
                <a href="https://mp.weixin.qq.com/wxopen/waregister?action=step1" class="btnlink" target="_blank">注册小程序</a>
                <a href="" class="btnlink">升级</a>
            </div>
        </div>
    </div>
    <div class="bottomnotice">
        <p class="warmnotice">温馨提示：</p>
        <h2 class="noticetext">授权小程序后，即可发布小程序</h2>
        <div class="noticeitem">
            <p>1、微信官方规定：用户必须自己进行小程序注册。然后才可以将小程序授权给任意第三方进行设计和代码管理。</p>
            <p>2、微信官方规定：小程序个人开放的服务类目是有严格规定的，内容不在服务类目中的，是审核不通过的。<a href="#" style="color: #1E9FFF">查看详情</a></p>
            <p>3、微信官网规定：小程序代码审核需要2-7天，结果将通过微信通知。审核通过后，将立即更新到线上。</p>
            <p>4、小程序审核期间，不影响您在pc端的操作，您可以正常新建项目、活动等。</p>
        </div>
    </div>
</div>
<input type="hidden" id="msg" value="{{session('msg')}}">
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript">
        layui.use(['layer'], function() {
            var layer = layui.layer;
            /**
             * 页面提示
             */
            var msg = $("#msg").val();
            if( msg )
            {
                layer.msg($("#msg").val());
            }
        });
    </script>
@endsection