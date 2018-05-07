@extends('server.layout.content')
@section('title','修改')
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/layui2.5/css/layui.css')}}" media="all" />
@stop
@section('content')
    <form class="layui-form" id="layui-form" method="post" action="{{route('client.update',$data->uuid)}}">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline">
                <select name="followstatusid">
                    @foreach( $status as $row )
                        <option value="{{$row->id}}" @if($data->followstatusid == $row->id) selected="selected" @endif >{{$row->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
                <textarea name="followcontent" maxlength="255" placeholder="请输入站点描述" class="layui-textarea linksDesc">{{$data->followcontent}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" id="btn_submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
    跟进日志
    <ul>
        @foreach( $data->clientToClientFollow as $follow )
        <li>
            @foreach( $status as $row )
                @if( $row->id == $follow->followstatus_id )
                <span>{{$row->name}}</span>
                @endif
            @endforeach
            <span>{{$follow->remarks}}</span>
            <span>{{$follow->follow_username}}</span>
            <span>{{$follow->created_at}}</span>
        </li>
        <br/>
        @endforeach
    </ul>
    <input type="hidden" id="msg" value="{{session('msg')}}">
    @if( count($errors) > 0 )
        @foreach ($errors->all() as $K=>$error)
            <input type="hidden" id="error" value="{{$error}}">
        @endforeach
    @endif
@stop
@section('js')
    <script src="{{asset('js/public/Validform_v5.3.2_min.js')}}"></script>
@stop
