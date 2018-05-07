@extends('server.layout.content')
@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="10%">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <td>标题</td>
            <td>{{$responseData["title"]}}</td>
        </tr>
        <tr>
            <td>发布时间</td>
            <td>{{$responseData["created_at"]}}</td>
        </tr>
        <tr>
            <td>封面图</td>
            <td>
                <a class="img" title="活动封面" style="width:5px;height:5px;">
                    {!!image($responseData["showurl"],"20%")!!}
                </a>
            </td>
        </tr>
        <tr>
            <td>内容摘要</td>
            <td>{{$responseData["resume"]}}</td>
        </tr>
        <tr>
            <td>内容</td>
            <td>{!!$responseData["content"]!!}</td>
        </tr>
        <tr>
            <td>参与方式</td>
            <td>
                @empty($responseData->participatory->name)
                    无
                 @else
                    {{ $responseData->participatory->name }}
                 @endempty
            </td>
        </tr>
        </tbody>
    </table>
@endsection
