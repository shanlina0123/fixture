@extends('server.layout.content')
@section("title")促销活动@endsection
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/luck.css')}}">
@endsection
@section('content')
    <div class="main" style="margin-bottom:100px ">
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>新建促销活动</legend>
        </fieldset>
        <!--form切换-->
        <div class="formwrap">
            <form class="layui-form" id="0" method="put" action="{{route('activity-update','id')}}" multiple="true"
                  autoActioin="{{route('activity-update','id')}}">
                {{csrf_field()}}
                <div class="formInner">
                    <div class="layui-form-item">
                        <label class="layui-form-label"> <i class="layui-icon"
                                                            style="font-size: 12px; color: #FF5722;">*</i>选择门店</label>
                        <div class="layui-input-block">
                            <select name="storeid" lay-verify="required" lay-search="" id="storeid">
                                <option value="">全部</option>
                                @if($list['storeList']!=null) @foreach($list['storeList'] as $k=>$item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach  @endif
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>活动标题</label>
                        <div class="layui-input-block">
                            <input type="text" class="layui-input" name="title" id="title" datatype="*"
                                   maxlength="200" nullmsg="请输入活动标题" errormsg="输入有误超过了200个字符">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>活动简介</label>
                        <div class="layui-input-block">
                                <textarea class="layui-textarea" name="resume" id="resume" datatype="*" maxlength="200"
                                          nullmsg="请输入活动简介" errormsg="输入有误超过了200个字符"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>开始时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="startdate" id="startdate" lay-verify="date" placeholder="年/月/日"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>结束时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="enddate" id="enddate" lay-verify="date" placeholder="年/月/日"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>封面图</label>
                        <div class="layui-input-block layui-upload baseUrl">
                            <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片</button>
                            <span class="imgnotice">请上传750px*150px的图片,最大{{config("configure.maxImgSize")}}</span>
                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                预览图：
                                <div class="layui-upload-list showUrl" id="bgurl"></div>
                                <input type="hidden" name="bgurl" class="hiddenUrl"/>
                            </blockquote>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>内容</label>
                        <div class="layui-input-block">
                                <textarea class="layui-textarea" name="content" id="content" datatype="*" maxlength="800"
                                          nullmsg="请输入活动内容" errormsg="输入有误超过了800个字符"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">内容图</label>
                        <div class="layui-input-block layui-upload baseUrl">
                            <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片</button>
                            <span class="imgnotice">请上传宽为750px的图片,最大{{config("configure.maxImgSize")}}</span>
                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                预览图：
                                <div class="layui-upload-list showUrl" id="mainurl"></div>
                                <input type="hidden" name="mainurl" class="hiddenUrl"/>
                            </blockquote>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon"
                                                           style="font-size: 12px; color: #FF5722;">*</i>上线/下线</label>
                        <div class="layui-input-block">
                            <input type="radio" name="isonline" value="1" title="上线" checked>
                            <input type="radio" name="isonline" value="0" title="下线">
                        </div>
                    </div>
                </div>
                <div class="submitButWrap">
                    <button type="button" class="layui-btn ajaxSubmit">保存</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('other')
@endsection
@section("js")
    <script type="text/javascript"
            src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/activity/create.js')}}"></script>
@endsection