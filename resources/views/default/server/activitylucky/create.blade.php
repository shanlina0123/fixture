@extends('server.layout.content')
@section("title")活动管理@endsection
@section('css')
    <style>
        .layui-btn+.layui-btn {
            margin-left: 4px;
        }
    </style>
@endsection
@section('content')
    <div class="main">
        <!--form切换-->
        <div class="formTab fl">
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
                            <form class="layui-form">
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
                                        <input type="text" class="layui-input" name="title" id="title">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>活动简介</label>
                                    <div class="layui-input-block">
                                        <textarea class="layui-textarea" name="resume" id="resume"></textarea>
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
                                <div class="layui-form-item">
                                    <label class="layui-form-label">人数限制</label>
                                    <div class="layui-input-inline">
                                        <input type="radio" name="ispeoplelimit" value="0" title="不限制" checked>
                                        <input type="radio" name="ispeoplelimit" value="1" title="限制">
                                    </div>
                                    <div class="layui-form-inline forLineheight">
                                        <input type="text" name="peoplelimitnum" class="layui-input" >人参与
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">活动背景图</label>
                                    <div class="layui-input-block layui-upload">
                                        <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片</button>
                                        <span class="imgnotice">请上传640px*1500px的图片</span>
                                        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                            预览图：
                                            <div class="layui-upload-list" id="bgurl"></div>
                                            <input type="hidden" name="bgurl" />
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">立即抽奖图</label>
                                    <div class="layui-input-block layui-upload">
                                        <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片 </button>
                                        <span class="imgnotice">请上传134px*134px的图片</span>
                                        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                            预览图：
                                            <div class="layui-upload-list" id="makeurl"></div>
                                            <input type="hidden" name="makeurl" />
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">未中奖图</label>
                                    <div class="layui-input-block layui-upload">
                                        <button type="button" class="layui-btn tab1Upload"><i class="layui-icon"></i>上传图片
                                        </button>
                                        <span class="imgnotice">请上传460px*430px的图片</span>
                                        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                                            预览图：
                                            <div class="layui-upload-list" id="loseurl"></div>
                                            <input type="hidden" name="loseurl" />
                                        </blockquote>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--派奖方式-->
                    <div class="layui-tab-item">
                        <div class="formInner">
                            <form class="layui-form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>总抽奖机会</label>
                                    <div class="layui-input-inline">
                                        <input type="radio" name="ischancelimit" value="0" title="不限制" checked>
                                        <input type="radio" name="ischancelimit" value="1" title="限制">
                                    </div>
                                    <div class="layui-form-inline forLineheight">
                                        每人最多有&nbsp;<input type="text" name="chancelimitnum" class="layui-input">次
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width:83px"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>每人抽奖次数</label>
                                    <div class="layui-form-inline forLineheight">
                                        每人最多中奖&nbsp;<input type="text" name="everywinnum" class="layui-input ">次
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>总中奖率</label>
                                    <div class="layui-form-inline forLineheight">
                                        <input type="text" name="winpoint" class="layui-input ">% &nbsp;<span>每10次抽检3次获奖</span>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label"><i class="layui-icon"  style="font-size: 12px; color: #FF5722;">*</i>联系信息</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="ishasconnectinfo" value="1" title="参与前填写">
                                        <input type="radio" name="ishasconnectinfo" value="2" title="参与后填写" checked>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--奖项设置-->
                    <div class="layui-tab-item tabItem">
                        <div class="imgnotice">请上传134px*134px的图片</div>
                        <form class="layui-form">
                            <table class="layui-table priceTable">
                                <tr>
                                    <th>奖品图片</th>
                                    <th>奖品名称</th>
                                    <th>奖品数量</th>
                                    <th>奖品等级</th>
                                    <th>奖品操作</th>
                                </tr>
                                <tr class="defaulttr">
                                    <td>
                                        <div class="uploadImgWrap">
                                            <!--<button type="button" class="layui-btn uploadBtn uploadImg"></button>-->
                                            <input name="prizelist['picture']" type="file" class="uploadBtn uploadImg">
                                            <div class="imgHome" style="background: url({{pix_asset('server/images/add.png')}}) center center no-repeat"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="layui-input-inline"><input type="text" name="prizelist['name']" class="layui-input"></div>
                                    </td>
                                    <td>
                                        <div class="layui-input-inline"><input type="text"  name="prizelist['num']" class="layui-input"></div>
                                    </td>
                                    <td>
                                        <div class="layui-input-inline">
                                            <select name="levelid" lay-verify="required" lay-search="" id="levelid">
                                                <option value="">全部</option>
                                                @if($list['levelList']!=null) @foreach($list['levelList'] as $k=>$item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach  @endif
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="editBtns clearfix">
                                            <button type="button" class="layui-btn layui-btn-sm fl updateBtn">保存</button>
                                            <button type="button" class="layui-btn layui-btn-sm fl deleteBtn">删除</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div class="btnWrap">
                            <button class="layui-btn addPrize">添加奖项</button>
                        </div>
                    </div>
                    <!--高级设置-->
                    <div class="layui-tab-item">
                        <div class="formInner">
                            <form class="layui-form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">微信分享标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="sharetitle" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">上线/下线</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="isonline" value="1" title="上线" checked>
                                        <input type="radio" name="isonline" value="0" title="下线" >
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btns">
                <input type="hidden" nmae="ispublic" value="0" />
                <button type="button" class="layui-btn">预览</button>
                <button type="button" class="layui-btn">暂存</button>
                <button type="button" class="layui-btn">保存</button>
            </div>
        </div>
        <!--展示切换-->
        <div class="showTab fl">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">活动首页</li>
                    <li>活动说明</li>
                    <li>中奖记录</li>
                    <li>无中奖记录</li>
                    <li>中奖页面</li>
                    <li>未中奖页面</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <div class="contentinner">
                            <div class="paddinginner tabindex">
                                <p class="activename">开心转转转</p>
                                <div class="prizetime">距离抽奖结束还剩<br><span>20小时5分钟12秒</span></div>
                                <a href="javascript:;" class="prizetip"><img src="{{pix_asset('server/images/prizetip.png')}}"  class="prizetipimg"></a>
                                <div class="prizemsg">恭喜用户135****5648抽得三等奖</div>
                                <div class="prizepart">
                                    <div class="prizeinner clearfix">
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize1.png')}}" class="itemimg"> </div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize2.png')}}" class="itemimg"></div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize3.png')}}" class="itemimg"> </div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize4.png')}}" class="itemimg"> </div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/brginprize.png')}}" class="itemimg"></div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize5.png')}}" class="itemimg"></div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize6.png')}}" class="itemimg"></div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize7.png')}}" class="itemimg"></div>
                                        <div class="priceitem fl"><img src="{{pix_asset('server/images/prize8.png')}}" class="itemimg"></div>
                                    </div>
                                </div>
                                <div class="times">您还有<span class="colorred">2</span>次抽奖机会</div>
                                <div class="share">邀请好友来抽奖<a href="" class="colorred">去分享</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="contentinner">
                            <div class="paddinginner">
                                <div class="deswrap">
                                    <div class="desli">
                                        <p>活动时间</p>
                                        <span>2018-04-02到2018-01-02</span>
                                    </div>
                                    <div class="desli">
                                        <p>主办单位</p>
                                        <span>熊先森科技有限公司</span>
                                    </div>
                                    <div class="desli">
                                        <p>活动说明</p>
                                        <span>这里是一个活动说明</span>
                                    </div>
                                    <div class="desli">
                                        <p>技术支持</p>
                                        <span>页面技术由<span class="colorbule">西安灰熊家族网络科技提供（<a href="" class="colorbule">点击了解</a>）</span>提供， 技术支持方仅能提供页面技术，不承担由活动引起的相关法律责任
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="contentinner">
                            <div class="paddinginner">
                                <ul class="prizeul">
                                    <li>
                                        <div><span>奖品：</span>开心转转转</div>
                                        <div><span>中奖时间：</span>2017-08-03 15:34:25</div>
                                    </li>
                                    <li>
                                        <div><span>奖品：</span>开心转转转</div>
                                        <div><span>中奖时间：</span>2017-08-03 15:34:25</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="contentinner">
                            <div class="paddinginner">
                                <p class="noprize">暂无中奖记录，祝您好运！</p>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="contentinner">
                            <div class="paddinginner blackbg">
                                <div class="prizewrap">
                                    <p class="toptext">中奖啦！</p>
                                    <img src="{{pix_asset('server/images/gift.png')}}" class="prizeimg">
                                    <p class="centertext">恭喜您，抽中了<span>四等奖</span>！</p>
                                    <p class="pricenotice">我们会尽快和您联系，请您保持手机畅通！</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="contentinner">
                            <div class="paddinginner blackbg">
                                <div class="prizewrap">
                                    <img src="{{pix_asset('server/images/noprize.png')}}" class="noprizeimg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('other')
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/activitylucky/create.luck.js')}}"></script>
@endsection