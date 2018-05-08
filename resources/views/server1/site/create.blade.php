@extends('server.layout.content')
@section('title','工地管理')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <form class="layui-form" id="layui-form" method="post" action="{{route('site.store')}}">
        {{csrf_field()}}
        <div class="layui-form-item">
            <label class="layui-form-label">门店</label>
            <div class="layui-input-block">
                <select name="storeid" datatype="*" nullmsg="请选择门店">
                    @if( count($data->store) )
                        @foreach( $data->store as $row )
                            <option value="{{$row->id}}" @if(old('storeid') == $row->id ) selected @endif>{{$row->name}}</option>
                        @endforeach
                    @else
                        <option value="0">暂无门店</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">工地名称</label>
            <div class="layui-input-block">
                <input type="text"  name="name"  value="{{old('name')}}" class="layui-input newsName" placeholder="请输入工地名称" datatype="*" maxlength="255" nullmsg="请输入工地名称" errormsg="输入有误">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
                <input type="text"  name="addr"  id="suggestId"  data-url="{{route('map-address')}}" value="{{old('addr')}}" class="layui-input newsName" placeholder="请输入小区名称或者地址" datatype="*" nullmsg="请输入小区名称或者地址" errormsg="输入有误">
                <div>
                    <ul id="seach">
                        <li>222</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">门牌</label>
            <div class="layui-input-block">
                <input type="text" name="doornumber"  value="{{old('doornumber')}}" class="layui-input" placeholder="请输入门牌，例如5号楼808室" datatype="*1-20" nullmsg="请输入门牌号" errormsg="请输入正确的门牌号" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">阶段模板</label>
            <div class="layui-input-block">
                <select name="stagetemplateid"  id="stagetemplateid" lay-filter="stagetemplate" datatype="*" nullmsg="请选择阶段模板">
                    <option value="">请选择阶段模板</option>
                    @foreach( $data->stageTemplate as $row )
                        <option value="{{$row->id}}" data-type="1" data-url="{{route('site-template-tag')}}">{{$row->name}}</option>
                    @endforeach
                    @foreach( $data->companyTemplate as $crow )
                        <option value="{{$crow->id}}" data-type="0" data-url="{{route('site-template-tag')}}">{{$crow->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="isdefaulttemplate" value="" id="isdefaulttemplate">
        </div>
        <div class="layui-form-item layui-hide">
            <label class="layui-form-label">&nbsp;</label>
            <div class="layui-input-block" id="templateTag">

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">户型</label>
            <div class="layui-input-block">
                <select name="roomtypeid"  datatype="*" nullmsg="请选择户型">
                    <option value="">请选择户型</option>
                    @foreach( $data->roomType as $row )
                        <option value="{{$row->id}}" @if(old('roomtypeid') == $row->id ) selected @endif>{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">房型</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" name="room"  value="{{old('room')}}" placeholder="室" min="1" max="9" maxlength="2" datatype="n1-2" nullmsg="请输入室" errormsg="请输入正确的房型" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">室</div>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" name="office"  value="{{old('office')}}"  placeholder="厅" min="1" max="9" maxlength="11"   datatype="n1-2" nullmsg="请输入厅" errormsg="请输入正确的房型" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">厅</div>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" name="kitchen"  value="{{old('kitchen')}}" placeholder="厨" min="1" max="9" maxlength="11"   datatype="n1-2" nullmsg="请输入厨" errormsg="请输入正确的房型"  autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">厨</div>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" name="wei"  value="{{old('wei')}}"  placeholder="卫" min="1" max="9" maxlength="11"  datatype="n1-2" nullmsg="请输入卫" errormsg="请输入正确的房型"  autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">卫</div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">面积</label>
            <div class="layui-input-block">
                <input type="number" name="acreage"  value="{{old('acreage')}}" class="layui-input" placeholder="面积（㎡）" max="99999"  datatype="mj" nullmsg="请输入面积" errormsg="请输入正确的面积">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">装修风格</label>
            <div class="layui-input-block">
                <select name="roomstyleid" datatype="*" nullmsg="请选择装修风格">
                    <option value="">请选择装修风格</option>
                    @foreach( $data->roomStyle as $row )
                        <option value="{{$row->id}}" @if(old('roomstyleid') ==$row->id ) selected @endif>{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">装修方式</label>
            <div class="layui-input-block">
                <select name="renovationmodeid"   datatype="*" nullmsg="请选择装修方式">
                    <option value="">请选择装修方式</option>
                    @foreach( $data->renovationMode as $row )
                        <option value="{{$row->id}}" @if(old('renovationmodeid') == $row->id ) selected @endif>{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">预算</label>
            <div class="layui-input-block">
                <input type="number" name="budget" value="{{old('budget')}}" class="layui-input" placeholder="预算（万元）"   maxlength="11"  datatype="n1-11" nullmsg="请输入预算" errormsg="请输入正确的数字">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上传Login</label>
            <div class="layui-upload-drag" id="test10">
                <i class="layui-icon"></i>
                <p>点击上传，或将文件拖拽到此处（工地封面：建议上传效果图）</p>
            </div>
            <div class="layui-inline" >
                <img width="258" height="135" id="src">
            </div>
            <input type="hidden" name="photo" id="photo">
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">展示</label>
            <div class="layui-input-block">
                <input type="checkbox" checked="" name="isopen" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" id="btn_submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
    <input type="hidden" id="msg" value="{{session('msg')}}">
    @if( count($errors) > 0 )
        @foreach ($errors->all() as $K=>$error)
            <input type="hidden" id="error" value="{{$error}}">
        @endforeach
    @endif
@stop
@section('js')
    <script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
    <script src="{{asset('js/server/site.js')}}"></script>
    <script type="text/javascript">
        $("#suggestId").keyup(function () {
            var keyword = $(this).val();
            var url = $(this).data('url');
            $.post(url,{keyword:keyword},function (data)
            {
                if( data )
                {
                    if( data.status == 0 )
                    {
                        var arr = data.data;
                        var str = '';
                        for(var i=0;i<arr.length;i++)
                        {
                            str+='<li>'+arr[i].address+'</li>';
                        }
                        $("#seach").find('li').remove();
                        $("#seach").append(str);
                    }
                }
            },'json')
        });
    </script>
@stop
