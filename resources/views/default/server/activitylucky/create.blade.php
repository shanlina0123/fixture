@extends('server.layout.content')
@section("title")活动管理@endsection
@section('css')
    <style>
        .layui-btn+.layui-btn {
            margin-left: 4px;
        }
        .formTab {
            margin-right: 20px;
            margin-bottom: 50px;
        }
        .showImg {
            width: 100%;
            height: 187.5px;
        }
        .imgHomeShow{
            width: 100%;
            height: 80px;
        }
    </style>
@endsection
@section('content')
    <div class="main">
        <!--form切换-->
        <div class="formTab fl">
            <form class="layui-form"  id="0" method="put" action="{{route('lucky-update','id')}}" multiple="true"  autoActioin="{{route('lucky-update','id')}}">
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
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach  @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>活动标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" class="layui-input" name="title" id="title" datatype="*" maxlength="200" nullmsg="请输入活动标题" errormsg="输入有误超过了200个字符">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>活动简介</label>
                                        <div class="layui-input-block">
                                            <textarea class="layui-textarea" name="resume" id="resume" datatype="*" maxlength="200" nullmsg="请输入活动简介" errormsg="输入有误超过了255个字符"></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>开始时间</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="startdate" id="startdate" lay-verify="date" placeholder="年/月/日" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>结束时间</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="enddate" id="enddate" lay-verify="date" placeholder="年/月/日"  class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item radioFilterNumber">
                                        <label class="layui-form-label">人数限制</label>
                                        <div class="layui-input-inline">
                                            <input type="radio" name="ispeoplelimit" value="0" title="不限制"  lay-filter="filterNum"   checked >
                                            <input type="radio" name="ispeoplelimit" value="1" title="限制" lay-filter="filterNum" >
                                        </div>
                                        <div class="layui-form-inline forLineheight hidden">
                                            <input type="number"  name="peoplelimitnum" class="layui-input" value="" />人参与
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">活动背景图</label>
                                        <div class="layui-input-block layui-upload baseUrl">
                                            <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片</button>
                                            <span class="imgnotice">请上传640px*1500px的图片</span>
                                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                                预览图：
                                                <div class="layui-upload-list showUrl" id="bgurl"></div>
                                                <input type="hidden" name="bgurl" class="hiddenUrl"/>
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">立即抽奖图</label>
                                        <div class="layui-input-block layui-upload baseUrl">
                                            <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片 </button>
                                            <span class="imgnotice">请上传134px*134px的图片</span>
                                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                                预览图：
                                                <div class="layui-upload-list showUrl" id="makeurl"></div>
                                                <input type="hidden" name="makeurl" class="hiddenUrl"/>
                                            </blockquote>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">未中奖图</label>
                                        <div class="layui-input-block layui-upload baseUrl">
                                            <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片
                                            </button>
                                            <span class="imgnotice">请上传460px*430px的图片</span>
                                            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                                预览图：
                                                <div class="layui-upload-list showUrl" id="loseurl"></div>
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
                                            <input type="radio" name="ischancelimit" value="0" title="不限制" lay-filter="filterNum" checked>
                                            <input type="radio" name="ischancelimit" value="1" title="限制" lay-filter="filterNum">
                                        </div>
                                        <div class="layui-form-inline forLineheight hidden">
                                            每人最多有&nbsp;<input type="number" name="chancelimitnum" class="layui-input">次
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label" style="width:83px"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>每人抽奖次数</label>
                                        <div class="layui-form-inline forLineheight">
                                            每人最多中奖&nbsp;<input type="number" name="everywinnum" class="layui-input ">次
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>总中奖率</label>
                                        <div class="layui-form-inline forLineheight">
                                            <input type="number" name="winpoint" class="layui-input ">% &nbsp;<span>每10次抽检3次获奖</span>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>联系信息</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="ishasconnectinfo" value="1" title="参与前填写">
                                            <input type="radio" name="ishasconnectinfo" value="2" title="参与后填写" checked>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!--奖项设置-->
                        <div class="layui-tab-item tabItem">
                            <div class="imgnotice">请上传134px*134px的图片</div>
                                <table class="layui-table priceTable">
                                    <tr>
                                        <th>奖品图片</th>
                                        <th>奖品名称</th>
                                        <th>奖品数量</th>
                                        <th>奖品等级</th>
                                        <th>奖品操作</th>
                                    </tr>
                                    <tr class="defaulttr" id="0">
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
                                        <td>
                                            <div class="editBtns clearfix">
                                                <button type="button" class="layui-btn layui-btn-sm fl deleteBtn" onclick="deleteItem(this)" url="{{route('lucky-prize-delete','id')}}">删除</button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <div class="btnWrap">
                                <button type="button" class="layui-btn addPrize">添加奖项</button>
                            </div>
                        </div>
                        <!--高级设置-->
                        <div class="layui-tab-item">
                            <div class="formInner">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">微信分享标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="sharetitle" class="layui-input" maxlength="200" nullmsg="请输入微信分享标题" errormsg="输入有误超过了200个字符">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">上线/下线</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="isonline" value="1" title="上线" >
                                            <input type="radio" name="isonline" value="0" title="下线" checked>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btns">
                    <button type="button"  class="layui-btn" id="showBtn">预览</button>
                    <button type="button"  class="layui-btn ajaxSubmit">保存</button>
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
    <script type="text/javascript" src="{{pix_asset('server/js/activitylucky/create.luck.js')}}"></script>
@endsection