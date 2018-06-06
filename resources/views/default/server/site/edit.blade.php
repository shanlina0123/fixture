@extends('server.layout.content')
@section('title','编辑项目')
@section('css')
@endsection
@section('content')
<div class="main" style="margin-bottom: 100px;">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>编辑项目</legend>
    </fieldset>
    <div class="fullForm">
        <div class="fullFormInner">
            <form class="layui-form" id="layui-form" method="post" action="{{route('site.update',$data->info->uuid)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>项目名称</label>
                <div class="layui-input-block">
                    <input type="text"  name="name" value="{{$data->info->name}}" class="layui-input" placeholder="请输入项目名称" datatype="*" maxlength="255" nullmsg="请输入项目名称" errormsg="输入有误">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>详细地址</label>
                <div class="layui-input-block">
                    <div class="layui-unselect layui-form-select layui-form-selected">
                        <div class="layui-select-title">
                            <input type="text"  name="addr" value="{{$data->info->addr}}"  id="suggestId"  data-url="{{route('map-address')}}" value="{{old('addr')}}" class="layui-input layui-unselect" placeholder="请输入小区名称或者地址" datatype="*" nullmsg="请输入小区名称或者地址" errormsg="输入有误">
                        </div>
                        <dl id="seach" style="display: none">

                        </dl>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">门牌</label>
                <div class="layui-input-block">
                    <input type="text" name="doornumber"  ignore="ignore" value="{{$data->info->doornumber}}" class="layui-input" placeholder="请输入门牌，例如5号楼808室" datatype="*1-20" nullmsg="请输入门牌号" errormsg="请输入正确的门牌号" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>阶段</label>
                <div class="layui-input-block" id="templateTag">
                    @foreach( $data->info->tage as $row )
                        <input type="radio" @if($row->id == $data->info->stageid ) checked="checked" @endif name="stageid" value="{{$row->id}}" title="{{$row->name}}" >
                    @endforeach
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">户型</label>
                <div class="layui-input-block">
                    <select name="roomtypeid"  ignore="ignore" datatype="*"  nullmsg="请选择户型">
                        <option value="">请选择户型</option>
                        @foreach( $data->roomType as $row )
                            <option value="{{$row->id}}" @if($data->info->roomtypeid == $row->id) selected="selected" @endif >{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">房型</label>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="number"  ignore="ignore" name="room" value="{{extractionInt($data->info->roomshap,0)}}" placeholder="室" min="1" max="9" maxlength="2" datatype="n1-2" nullmsg="请输入室" errormsg="请输入正确的房型" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">室</div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="number"  ignore="ignore" name="office"  value="{{extractionInt($data->info->roomshap,1)}}" placeholder="厅" min="1" max="9" maxlength="11"   datatype="n1-2" nullmsg="请输入厅" errormsg="请输入正确的房型" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">厅</div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="number"  ignore="ignore" name="kitchen"  value="{{extractionInt($data->info->roomshap,2)}}" placeholder="厨" min="1" max="9" maxlength="11"   datatype="n1-2" nullmsg="请输入厨" errormsg="请输入正确的房型"  autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">厨</div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="number"  ignore="ignore" name="wei"  value="{{extractionInt($data->info->roomshap,3)}}" placeholder="卫" min="1" max="9" maxlength="11"  datatype="n1-2" nullmsg="请输入卫" errormsg="请输入正确的房型"  autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">卫</div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">面积</label>
                <div class="layui-input-block">
                    <input type="number" name="acreage" ignore="ignore" value="{{(int)$data->info->acreage?$data->info->acreage:''}}" class="layui-input" placeholder="面积（㎡）" max="3"  datatype="mj" nullmsg="请输入面积" errormsg="请输入正确的面积">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">装修风格</label>
                <div class="layui-input-block">
                    <select name="roomstyleid" datatype="*"  ignore="ignore" nullmsg="请选择装修风格">
                        <option value="">请选择装修风格</option>
                        @foreach( $data->roomStyle as $row )
                            <option value="{{$row->id}}" @if($data->info->roomstyleid == $row->id) selected="selected" @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">装修方式</label>
                <div class="layui-input-block">
                    <select name="renovationmodeid"   ignore="ignore" datatype="*" nullmsg="请选择装修方式">
                        <option value="">请选择装修方式</option>
                        @foreach( $data->renovationMode as $row )
                            <option value="{{$row->id}}"  @if($data->info->renovationMode == $row->id) selected="selected" @endif>{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">预算</label>
                <div class="layui-input-block">
                    <input type="number" name="budget" ignore="ignore" value="{{(int)$data->info->budget?$data->info->budget:''}}" class="layui-input" placeholder="预算（万元）"   maxlength="11"  datatype="n1-11" nullmsg="请输入预算" errormsg="请输入正确的数字">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">项目封面</label>
                <div class="layui-upload-drag" id="test10" style="float: left">
                    <i class="layui-icon"></i>
                    <p>点击上传，或将文件拖拽到此处（项目封面：建议上传效果图）</p>
                </div>
                <div class="uploadImg layui-inline fl" style="margin-left: 20px;"><img id="src" src="{{getImgUrl($data->info->explodedossurl)}}" style="max-width: 100%;max-height:135px;"></div>
                <input type="hidden" name="photo" id="photo" value="">
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">展示</label>
                <div class="layui-input-block">
                    <input type="checkbox" @if($data->info->isopen == 1 ) checked="checked" @endif name="isopen" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                </div>
            </div>
            <div class="submitButWrap">
                <button type="button" class="layui-btn" id="btn_submit">立即提交</button>
            </div>
            <input type="hidden" name="street" value="">
            <input type="hidden" name="fulladdr" value="">
            <input type="hidden" name="lng" value="{{$data->info->lng}}">
            <input type="hidden" name="lat" value="{{$data->info->lat}}">
            <input type="hidden" name="sitestagename" value="" id="sitestagename">
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="msg" value="{{session('msg')}}">
@if( count($errors) > 0 )
    @foreach ($errors->all() as $K=>$error)
        <input type="hidden" id="error" value="{{$error}}">
    @endforeach
@endif
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script src="{{pix_asset('server/js/site/site.js')}}"></script>
@endsection
