@extends('server.layout.content')
@section('title','公众号服务通知配置')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/service.css')}}"/>
@endsection
@section('content')
<div class="main">
    <div class="servicewrap">
        <fieldset class="layui-elem-field layui-field-title">
           <legend>微信公众号服务通知配置</legend>
        </fieldset>

        <div class="topnotice">请联系管理员进行操作</div>
        @if($user->type == 0 && $user->isadmin )
        <div class="partwrap formwrap">
            <p class="lefttext">公众号开发信息：</p>
            <form class="form">
                <div class="formitem">
                    <span class="formname">APPID：</span>
                    <input type="text" class="forminput" maxlength="255" id="union_wechat_mp_appid" placeholder="请输入APPID" value="{{$small?$small->union_wechat_mp_appid:''}}">
                </div>
                <div class="formitem">
                    <span class="formname">APP秘钥：</span>
                    <input type="{{$small && $small->union_wechat_mp_appid?'password':'text'}}" value="{{$small && $small->union_wechat_mp_appid?"****************":''}}" class="forminput"  maxlength="255" id="union_wechat_mp_appsecret" placeholder="请输入APP秘钥" >
                </div>
            </form>
            @if( $small && $small->union_wechat_mp_appid )
                <button class="layui-btn bindbtn" data-url="{{route('mp-authorize')}}">已授权</button>
            @else
                <button class="layui-btn bindbtn auth" data-url="{{route('mp-authorize')}}">授权</button>
            @endif
        </div>
        <div class="partwrap">
            <p class="lefttext">服务器配置：</p>
            <ul class="listul">
                <!--如果信息没有回填显示未填写和请在公众号开发信息部分绑定，如果有直接显示信息-->
                <li class="clearfix">
                    <span class="leftnumber fl">服务器地址(URL)</span>
                    <div class="listdiv fl"><span class=" noinsert">{{$small?url('wx/messageAuthorize').'?token='.$small->token:''}}</span></div>
                </li>
                <li class="clearfix">
                    <span class="leftnumber fl">令牌(Token)</span>
                    <div class="listdiv fl"><span class="noinsert">{{$small?$small->token:''}}</span></div>
                </li>
                <li class="clearfix">
                    <span class="leftnumber fl">消息加解密秘钥</span>
                    <div class="listdiv fl"><span class="noinsert">{{$small?$small->EncodingAESKey:''}}</span></div>
                </li>
            </ul>
        </div>
        @endif
        <div class="partwrap">
            <p class="lefttext">模板配置：</p>
            <ul class="settingul clearfix">
                @foreach( $mpData as $row )
                <li class="fl @if($row->templateToCompanyTemplate) clearfix complete @endif">
                    <div class="leftpart">
                        <div class="centermsg">
                            <div class="centertop">
                                <img src="{{pix_asset('server/images/default.jpg')}}">
                            </div>
                            <div class="centertoptext">
                                <p>{{$row->name}}</p>
                                <span>{{$row->created_at?date("Y年m月",strtotime($row->created_at)):''}}</span>
                            </div>
                            <ul class="centerul">
                                @if(is_array(json_decode($row->content,true)))
                                    @foreach( json_decode($row->content,true) as $k=>$v )
                                    <li>@if($loop->first || $loop->last) {{$v}} @else <span>{{$k}}</span>{{$v}} @endif</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="bottomdetail clearfix">
                            <span>查看详情</span>
                            <img src="{{pix_asset('server/images/right.png')}}" class="fr">
                        </div>
                    </div>
                    <div class="bottonbtnswrap clearfix">
                        <div class="applywrap fl">
                            @if($row->templateToCompanyTemplate)
                                <button class="layui-btn">已申请</button>
                            @else
                                @if( $small && $small->union_wechat_mp_appid)
                                    <button class="layui-btn ask" data-url="{{route('send-template')}}" data-id="{{encrypt($row->id)}}"  data-ww="{{$row->id}}">申请</button>
                                @else
                                    <button class="layui-btn tip">申请</button>
                                @endif
                            @endif
                            <a href="#" target="black">如何申请模板?</a>
                        </div>
                        <div class="islock fr">
                            <form class="layui-form switchwrap">
                                <input type="checkbox"  @if($row->templateToCompanyTemplate) @endif name="open" lay-skin="switch" lay-text="ON|OFF">
                            </form>
                            <span>开启后可接受微信通知</span>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
<!--申请模板弹窗-->
<ul class="sharepop clearfix">
    <li>
        <p>公众号二维码</p>
        <a href="javascript:;"><img src="../../images/erweima.png"></a>
        <p class="popnotice">这是一段提示信息</p>
    </li>
</ul>
<div class="applyPop">
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">模板ID</label>
            <div class="layui-input-inline">
                <input type="text" id="modelid" placeholder="微信公众号消息模板ID" autocomplete="off" class="layui-input popinput">
            </div>
        </div>
    </form>
</div>
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script>
        layui.use(['form', 'jquery', 'layer'], function() {
            var form = layui.form,
                $ = layui.jquery,
                layer = layui.layer;
            $(".sharewrap,.auth").click(function() {
                //获取appid和密钥进行判断
                var appid = $("#union_wechat_mp_appid").val();
                var appsecret = $("#union_wechat_mp_appsecret").val();
                if( appid == false)
                {
                    layer.msg('请填写APPID');
                    return;
                }
                if( appsecret == false)
                {
                    layer.msg('请填写APP秘钥');
                    return;
                }
                var url = $(this).attr('data-url');
                var obj={
                    "union_wechat_mp_appid":appid,
                    "union_wechat_mp_appsecret":appsecret
                };
                $.post(url,obj,function (data) {
                    if(data.status == 1)
                    {
                        layer.alert(data.messages,function () {
                            location = location;
                        });

                    }else
                    {
                        layer.msg(data.messages);
                    }
                },'json');
            });
            $(".applywrap .ask").click(function() {
                var url = $(this).attr('data-url');
                var id = $(this).attr('data-id');
                layer.open({
                    type: 1,
                    title: '申请模板',
                    skin: 'layui-layer-rim',
                    area: ['400px', '200px'],
                    btn: ['提交', '取消'],
                    btnAlign: 'c',
                    content: $('.applyPop'),
                    yes: function(){
                        var modelid = $("#modelid").val();
                        if( modelid == false )
                        {
                            layer.msg('请填写模板ID');
                            return;
                        }else
                        {
                            var obj={
                                "mptemplateid":modelid,
                                "datatemplateid":id
                            };
                            $.post(url,obj,function (data) {
                                if(data.status == 1)
                                {
                                    if( data.data.isOpenid == 0 )
                                    {
                                        //弹出
                                    }
                                }else
                                {
                                    layer.msg(data.messages);
                                }
                            },'json');
                        }
                    }
                });
            });
            $(".applywrap .tip").click(function() {
                layer.msg('授权完成才可申请');
            });
        });
    </script>
@endsection
