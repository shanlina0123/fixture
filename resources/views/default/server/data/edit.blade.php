@extends('server.layout.content')
@section("title")属性管理@endsection
@section('content')
    <div class="main" style="margin-bottom: 100px;">
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <h1 class="pageTitle" >{{$list["cateData"]["name"]}}</h1>
        <div class="settingPop">
            <div class="setttingPopInner">
                <form class="layui-form" cateid="{{$list["cateData"]["id"]}}" action="{{route('data-update','id')}}" method="put" id="addAndEditAndDeleteForm"   deleteAction="{{route('data-delete','id')}}" deleteMethod="delete">
                <table class="layui-table popSettingTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>值</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    @if($list["dataList"]) @foreach($list["dataList"] as $index=>$item)
                    <tr id="{{$item['id']}}" index="{{$index+1}}" >
                        <td>{{$index+1}}</td>
                        <td><input type="text" class="layui-input readonly" name="name" value="{{$item['name']}}" readonly id="name"></td>
                        <td>
                            <div class="settingBtns">
                                <button type="button" class="layui-btn layui-btn-sm popEditBtn" onclick="edit(this)">编辑</button>
                                <button type="button" class="layui-btn layui-btn-sm popDelateBtn" onclick="deleteItem(this)">删除</button>
                            </div>
                            <div class="settingBtn" style="display: none">
                                <button type="button" class="layui-btn layui-btn-sm saveBtn" onclick="save(this)">保存</button>
                                <button type="button" class="layui-btn layui-btn-sm popDelateBtn" onclick="removeItem(this)">删除</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach @endif
                </table>
                </form>
            </div>
            <div class="addBtnWrap">
                <button class="layui-btn addBtn"><i class="layui-icon"></i></button>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/data/data.js')}}"></script>
@endsection