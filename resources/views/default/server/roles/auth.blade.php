@extends('server.layout.content')
@section("title")角色管理@endsection
@section('content')
    <div class="main">
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <h1 class="pageTitle">权限编辑</h1>
        <div class="editRoleWrap roleAuthListDiv">
            <form class="layui-form" action="{{route('roles-auth-update',$list['role']['id'])}}" method="put" >
                <div class="layui-form-item">
                    <label class="layui-form-label">角色</label>
                    <div class="layui-input-block">
                        <input type="text" placeholder="{{$list['role']['name']}}" class="layui-input readonly" readonly value="{{$list['role']['name']}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">配置权限</label>
                    <div class="layui-input-block">
                        <ul class="powerListUl">
                            @if($list['functionList']!=null)@foreach($list['functionList'] as $index=>$item)
                                <li>
                                    <div class="basePower">
                                        <div class="powerName">菜单权限</div>
                                        <div class="basePowerWrap">
                                            <div class="allPower">
                                                <input type="checkbox" name="funcislook[{{$item['id']}}]" tolook="@if($list["roleFunctionList"]!=null&&array_key_exists($item["id"],$list["roleFunctionList"])){{$list["roleFunctionList"][$item['id']]['islook']}}@else 1 @endif" class="functionidSubmit" lay-skin="primary" lay-filter="allChoose" title="{{$item["menuname"]}}" value="{{$item["id"]}}" @if($list["roleFunctionList"]!=null&&array_key_exists($item["id"],$list["roleFunctionList"]))checked=""@endif/>
                                            </div>
                                            <ul class="subPower">
                                                <li>
                                                    @if(array_key_exists("_child",$item)&&$item["_child"])
                                                        <div class="subPowerName">
                                                            @foreach($item["_child"] as $key=>$child)
                                                            <input type="checkbox" name="funcislook[{{$child["id"]}}]" tolook="@if($list["roleFunctionList"]!=null&&array_key_exists($item["id"],$list["roleFunctionList"])){{$list["roleFunctionList"][$item['id']]['islook']}} @else 1 @endif"  class="functionidSubmit" lay-skin="primary" lay-filter="subChoose" title="{{$child["menuname"]}}" value="{{$child["id"]}}" @if($list["roleFunctionList"]!=null&&array_key_exists($item["id"],$list["roleFunctionList"]))checked=""@endif disabled>
                                                            @endforeach
                                                        </div>
                                                   @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="otherPower">
                                        <div class="powerName">视野权限</div>
                                        <div class="powers">
                                            <input type="radio" name="islook[{{$item['id']}}]"  value="1" title="全部" class="isLookCheck"  lay-filter="isLookCheck" @if($list["roleFunctionList"]==null || !array_key_exists($item["id"],$list["roleFunctionList"]) || $list["roleFunctionList"][$item['id']]['islook']==1)checked=""@endif>
                                            <input type="radio" name="islook[{{$item['id']}}]"  value="2" title="城市" class="isLookCheck"  lay-filter="isLookCheck" @if($list["roleFunctionList"]!=null&&array_key_exists($item["id"],$list["roleFunctionList"])&&$list["roleFunctionList"][$item['id']]['islook']==2)checked=""@endif>
                                            <input type="radio" name="islook[{{$item['id']}}]"  value="3" title="门店" class="isLookCheck"  lay-filter="isLookCheck" @if($list["roleFunctionList"]!=null&&array_key_exists($item["id"],$list["roleFunctionList"])&&$list["roleFunctionList"][$item['id']]['islook']==3)checked=""@endif>
                                        </div>
                                    </div>
                                </li>
                            @endforeach @endif
                        </ul>
                    </div>
                </div>
                <div class="submitButWrap">
                    <button type="button" class="layui-btn ajaxSubmit">立即提交</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/roles/auth.js')}}"></script>
@endsection