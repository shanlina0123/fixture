<!--展示切换-->
<div class="showTab fl" id="showContent">
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
                    <div class="paddinginner tabindex"  id="bgurl"
                         @if(array_key_exists("luckData",$list)&&$list["luckData"]['bgurl'])style="background: url({{"/".config('configure.uploads')."/".$list["luckData"]['bgurl']}}) center top no-repeat;" @endif>
                        <p class="activename">@if(array_key_exists("luckData",$list)){{$list["luckData"]["title"]}}@endif</p>
                        <div class="prizetime">距离抽奖结束还剩<br><span>20小时5分钟12秒</span></div>
                        <a href="javascript:;" class="prizetip"><img src="{{pix_asset('server/images/prizetip.png')}}"
                                                                     class="prizetipimg"></a>
                        <div class="prizemsg">恭喜用户135****5648抽得三等奖</div>
                        <div class="prizepart">
                            <div class="prizeinner clearfix">
                                @if(array_key_exists("prizeList",$list)&&$list["prizeList"])
                                    <div class="priceitem fl" id="prizeList0">@if(in_array(0,array_keys($list["prizeList"]))&&$list["prizeList"][0])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][0]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="prizeList1">@if(in_array(1,array_keys($list["prizeList"]))&&$list["prizeList"][1])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][1]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="prizeList2">@if(in_array(2,array_keys($list["prizeList"]))&&$list["prizeList"][2])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][2]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="prizeList3">@if(in_array(3,array_keys($list["prizeList"]))&&$list["prizeList"][3])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][3]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="makeurl"><img
                                                src="@if($list["luckData"]['makeurl']){{"/".config('configure.uploads')."/".$list["luckData"]['makeurl']}} @endif"
                                                class="itemimg"></div>
                                    <div class="priceitem fl" id="prizeList4">@if(in_array(4,array_keys($list["prizeList"]))&&$list["prizeList"][4])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][4]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="prizeList5">@if(in_array(5,array_keys($list["prizeList"]))&&$list["prizeList"][5])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][5]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="prizeList6">@if(in_array(6,array_keys($list["prizeList"]))&&$list["prizeList"][6])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][6]['picture']}}"
                                                 class="itemimg">@endif </div>
                                    <div class="priceitem fl" id="prizeList7">@if(in_array(7,array_keys($list["prizeList"]))&&$list["prizeList"][7])
                                            <img src="{{"/".config('configure.uploads')."/".$list["prizeList"][7]['picture']}}"
                                                 class="itemimg">@endif </div>
                                @else
                                    <div class="priceitem fl"  id="prizeList0"><img src="{{pix_asset('server/images/prize1.png')}}"   class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList1"><img src="{{pix_asset('server/images/prize2.png')}}"   class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList2"><img src="{{pix_asset('server/images/prize3.png')}}"   class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList3"><img src="{{pix_asset('server/images/prize4.png')}}"   class="itemimg"></div>
                                    <div class="priceitem fl"  id="makeurl"><img src="{{pix_asset('server/images/brginprize.png')}}"   class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList4"><img src="{{pix_asset('server/images/prize5.png')}}"  class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList5"><img src="{{pix_asset('server/images/prize6.png')}}"  class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList6"><img src="{{pix_asset('server/images/prize7.png')}}"  class="itemimg"></div>
                                    <div class="priceitem fl"  id="prizeList7"><img src="{{pix_asset('server/images/prize8.png')}}"  class="itemimg"></div>
                                @endif
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
                                <span id="luckydate">@if(array_key_exists("luckData",$list)&&$list["luckData"]){{$list["luckData"]["startdate"]}} 到 {{$list["luckData"]["enddate"]}}@endif</span>
                            </div>
                            <div class="desli">
                                <p>主办单位</p>
                                <span>@if(array_key_exists("luckData",$list)&&$list["luckData"]){{$list["luckData"]["companyname"]}}@endif</span>
                            </div>
                            <div class="desli">
                                <p>活动说明</p>
                                <span id="resume">@if(array_key_exists("luckData",$list)&&$list["luckData"]){{$list["luckData"]["resume"]}} @endif</span>
                            </div>
                            <div class="desli">
                                <p>技术支持</p>
                                <span>{!! config("configure.technology_support") !!}</span>
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
                        <div class="prizewrap" id="loseurl">
                            <img  src="@if(array_key_exists("luckData",$list)&&$list["luckData"]){{"/".config('configure.uploads')."/".$list["luckData"]['loseurl']}}@else{{pix_asset('server/images/noprize.png')}}@endif" class="noprizeimg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>