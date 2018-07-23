@extends('server.layout.content')
@section("title")活动管理@endsection
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/luck.css')}}">
@endsection
@section('content')
    <div class="main">
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <!--form切换-->
        <div class="formTab fl" >
            <form class="layui-form"  id="{{$list["luckData"]["id"]}}" method="put" action="{{route('lucky-update',$list["luckData"]["id"])}}" multiple="true"  autoActioin="{{route('lucky-update','id')}}">
                {{csrf_field()}}
                <div class="layui-tab layui-tab-card">
                    <ul class="layui-tab-title">
                        <li class="layui-this">基础设置</li>
                        <li>派奖方式</li>
                        <li>奖项设置</li>
                        <li>高级设置</li>
                    </ul>
                    <div class="layui-tab-content">
                        <!--基础设置-->
                        <div class="layui-tab-item layui-show">
                            <div class="formInner">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"> <i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>选择门店</label>
                                        <div class="layui-input-block">
                                            <select name="storeid" lay-verify="required" lay-search="" id="storeid">
                                                <option value="">全部</option>
                                                @if($list['storeList']!=null) @foreach($list['storeList'] as $k=>$item)
                                                    <option value="{{$item->id}}" @if($item->id==$list["luckData"]["storeid"]) selected @endif>{{$item->name}}</option>
                                                @endforeach  @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>活动标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" class="layui-input" name="title" id="title" value="{{$list["luckData"]['title']}}" datatype="*" maxlength="200" nullmsg="请输入活动标题" errormsg="输入有误超过了200个字符">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>活动简介</label>
                                        <div class="layui-input-block">
                                            <textarea class="layui-textarea" name="resume" id="resume" value="{{$list["luckData"]['resume']}}" datatype="*" maxlength="200" nullmsg="请输入活动简介" errormsg="输入有误超过了255个字符">{{$list["luckData"]['resume']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>开始时间</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="startdate" id="startdate" lay-verify="date" placeholder="年/月/日" class="layui-input" value="{{$list["luckData"]['startdate']}}">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>结束时间</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="enddate" id="enddate" lay-verify="date" placeholder="年/月/日"  class="layui-input" value="{{$list["luckData"]['enddate']}}">
                                        </div>
                                    </div>
                                    <div class="layui-form-item radioFilterNumber">
                                        <label class="layui-form-label">人数限制</label>
                                        <div class="layui-input-inline">
                                            <input type="radio" name="ispeoplelimit" value="0" title="不限制"  lay-filter="filterNum"   @if($list['luckData']["ispeoplelimit"]==0) checked @endif>
                                            <input type="radio" name="ispeoplelimit" value="1" title="限制" lay-filter="filterNum" @if($list['luckData']["ispeoplelimit"]==1) checked @endif >
                                        </div>
                                        <div class="layui-form-inline forLineheight  @if($list['luckData']["ispeoplelimit"]==0)  hidden @endif">
                                            <input type="number" name="peoplelimitnum" class="layui-input" value="{{$list['luckData']["peoplelimitnum"]}}" />人参与
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">活动背景图</label>
                                        <div class="layui-input-block layui-upload baseUrl">
                                            <span class="imgnotice">请上传640px*1500px的图片,最大{{config("configure.maxImgSize")}}</span>
                                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                                预览图：
                                                <div class="layui-upload-list showUrl" id="bgurl">
                                                  @if($list['luckData']["bgurl"])<img src="{{"/".config('configure.uploads')."/".$list['luckData']["bgurl"]}}"  class="showImg">@endif
                                                </div>
                                                <input type="hidden" name="bgurl" class="hiddenUrl"/>
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">立即抽奖图</label>
                                        <div class="layui-input-block layui-upload baseUrl">
                                            <span class="imgnotice">请上传134px*134px的图片,最大{{config("configure.maxImgSize")}}</span>
                                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                                预览图：
                                                <div class="layui-upload-list showUrl" id="makeurl">
                                                    @if($list['luckData']["makeurl"])<img src="{{"/".config('configure.uploads')."/".$list['luckData']["makeurl"]}}"  class="showImg">@endif
                                                </div>
                                                <input type="hidden" name="makeurl" class="hiddenUrl"/>
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">未中奖图</label>
                                        <div class="layui-input-block layui-upload baseUrl">
                                            </button>
                                            <span class="imgnotice">请上传460px*430px的图片,最大{{config("configure.maxImgSize")}}</span>
                                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                                预览图：
                                                <div class="layui-upload-list showUrl" id="loseurl">
                                                    @if($list['luckData']["loseurl"])<img src="{{"/".config('configure.uploads')."/".$list['luckData']["loseurl"]}}"  class="showImg">@endif
                                                </div>
                                                <input type="hidden" name="loseurl" class="hiddenUrl" />
                                            </blockquote>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!--派奖方式-->
                        <div class="layui-tab-item">
                            <div class="formInner">
                                    <div class="layui-form-item radioFilterNumber">
                                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>总抽奖机会</label>
                                        <div class="layui-input-inline">
                                            <input type="radio" name="ischancelimit" value="0" title="不限制" lay-filter="filterNum" @if($list['luckData']["ischancelimit"]==0) checked @endif>
                                            <input type="radio" name="ischancelimit" value="1" title="限制" lay-filter="filterNum" @if($list['luckData']["ischancelimit"]==1) checked @endif>
                                        </div>
                                        <div class="layui-form-inline forLineheight @if($list['luckData']["ischancelimit"]==0) hidden @endif">
                                            每人最多有&nbsp;<input type="number" name="chancelimitnum" class="layui-input" value="{{$list['luckData']["chancelimitnum"]}}">次
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label" style="width:83px"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>每人抽奖次数</label>
                                        <div class="layui-form-inline forLineheight">
                                            每人最多中奖&nbsp;<input type="number" name="everywinnum" class="layui-input"  value="{{$list['luckData']["everywinnum"]}}">次
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>总中奖率</label>
                                        <div class="layui-form-inline forLineheight">
                                            <input type="number" name="winpoint" class="layui-input" value="{{$list['luckData']["winpoint"]}}">% &nbsp;<span>每10次抽检3次获奖</span>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>联系信息</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="ishasconnectinfo" value="1" title="参与前填写" @if($list['luckData']["ishasconnectinfo"]==1) checked @endif>
                                            <input type="radio" name="ishasconnectinfo" value="2" title="参与后填写" @if($list['luckData']["ishasconnectinfo"]==2) checked @endif>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!--奖项设置-->
                        <div class="layui-tab-item tabItem">
                            <div class="imgnotice">请上传134px*134px的图片,最大{{config("configure.maxImgSize")}}</div>
                                <table class="layui-table priceTable">
                                    <tr>
                                        <th>奖品图片</th>
                                        <th>奖品名称</th>
                                        <th>奖品数量</th>
                                        <th>奖品等级</th>
                                    </tr>

                                    @if($list["prizeList"])@foreach($list["prizeList"] as $k=>$itemPrize)
                                    <tr class="defaulttr" id="{{$itemPrize['id']}}" >
                                        <td>
                                            <div class="uploadImgWrap">
                                                <!--<button type="button" class="layui-btn uploadBtn uploadImg"></button>-->
                                                <input name="file" type="file" class="uploadBtn uploadImg prizelist"  id="uploadImg{{$k}}" selectIndex="{{$k}}">
                                                <input type="hidden" name="picture" />
                                                <div class="imgHome" >
                                                    @if($itemPrize['picture'])<img src="{{"/".config('configure.uploads')."/".$itemPrize['picture']}}"  class="layui-upload-img imgHomeShow">@endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="layui-input-inline"><input type="text" name="name" value="{{$itemPrize['name']}}" class="layui-input" maxlength="200" nullmsg="请输入奖项名称" errormsg="输入有误超过了200个字符"></div>
                                        </td>
                                        <td>
                                            <div class="layui-input-inline"><input type="number"  name="num" value="{{$itemPrize['num']}}" class="layui-input" maxlength="200" nullmsg="请输入奖项数量" ></div>
                                        </td>
                                        <td>
                                            <div class="layui-input-inline">
                                                <select name="levelid" lay-verify="required" lay-search="" id="levelid"  maxlength="200" nullmsg="请选择奖项级别" >
                                                    <option value="">请选择</option>
                                                    @if($list['levelList']!=null) @foreach($list['levelList'] as $k=>$item)
                                                        <option value="{{$item->id}}" @if($itemPrize['levelid']==$item->id) selected @endif>{{$item->name}}</option>
                                                    @endforeach  @endif
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach  @else
                                        <tr class="defaulttr"  id="0">
                                            <td>
                                                <div class="uploadImgWrap">
                                                    <!--<button type="button" class="layui-btn uploadBtn uploadImg"></button>-->
                                                    <input name="file" type="file" class="uploadBtn uploadImg prizelist"  id="uploadImg0" selectIndex="0">
                                                    <input type="hidden" name="picture" />
                                                    <div class="imgHome" style="background: url({{pix_asset('server/images/add.png')}}) center center no-repeat"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="layui-input-inline"><input type="text" name="name" class="layui-input" maxlength="200" nullmsg="请输入奖项名称" errormsg="输入有误超过了200个字符"></div>
                                            </td>
                                            <td>
                                                <div class="layui-input-inline"><input type="number"  name="num" class="layui-input" maxlength="200" nullmsg="请输入奖项数量" ></div>
                                            </td>
                                            <td>
                                                <div class="layui-input-inline">
                                                    <select name="levelid" lay-verify="required" lay-search="" id="levelid"  maxlength="200" nullmsg="请选择奖项级别" >
                                                        <option value="">请选择</option>
                                                        @if($list['levelList']!=null) @foreach($list['levelList'] as $k=>$item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach  @endif
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                        </div>
                        <!--高级设置-->
                        <div class="layui-tab-item">
                            <div class="formInner">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">微信分享标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="sharetitle" class="layui-input" value="{{$list['luckData']['sharetitle']}}" maxlength="200" nullmsg="请输入微信分享标题" errormsg="输入有误超过了200个字符">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">上线/下线</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="isonline" value="1" title="上线" @if($list['luckData']['isonline']==1) checked @endif>
                                            <input type="radio" name="isonline" value="0" title="下线" @if($list['luckData']['isonline']==0) checked @endif >
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--展示切换-->
        @include('server.activitylucky.mobile')
    </div>
@endsection
@section('other')
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/activitylucky/see.luck.js')}}"></script>
@endsection