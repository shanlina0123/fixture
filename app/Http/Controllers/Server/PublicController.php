<?php
namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;

class PublicController extends ServerBaseController
{

    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp(Request $request)
    {
        $obj = new \stdClass();
        $src = new \stdClass();
        if( $request->file('file') == false ) return '';
        try {
            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];
            $obj->code = 0;
            $obj->msg = '上传成功';
            $src->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
            $src->name = $name;
            $obj->data = $src;
            return response()->json($obj, 200);
        } catch (Exception $e)
        {
            $obj->code = 0;
            $obj->msg = '上传失败';
            $obj->data = '';
            return response()->json($obj, 200);
        }
    }

    /**
     *  获取腾讯地图搜索的地址
     */
    public function getMapAddress( Request $request )
    {
        $keyword = $request->input('keyword');
        if( $keyword )
        {
            $url = 'https://apis.map.qq.com/ws/place/v1/suggestion/?keyword='.$keyword.'&key=N6LBZ-XRSWP-NM5DY-LW7S6-GCKO7-WBFF7';
            $data = file_get_contents($url);
            return $data;

        }else
        {
            return response()->json('', 200);
        }
    }
}