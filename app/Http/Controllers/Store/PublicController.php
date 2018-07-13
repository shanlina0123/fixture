<?php
namespace App\Http\Controllers\Store;
use App\Http\Controllers\Common\StoreBaseController;
use Illuminate\Http\Request;

class PublicController extends StoreBaseController
{

    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp( Request $request )
    {
        if( $request->file('file') == false )
        {
            responseData(\StatusCode::ERROR,'文件不存在');
        }
        $obj = new \stdClass();
        
        //检验文件类型
        $fileTypes = array('image/jpeg','image/png','video/mp4');
        if(!in_array($request->file('file')->getMimeType(),$fileTypes)) {
            $obj->code = 0;
            $obj->msg =  '文件格式不合法'.$request->file('file')->getMimeType();
            $obj->data = '';
            return response()->json($obj, 200);
        }
        //检验大小
        $fileSize=$request->file('file')->getSize();
        if(!$request->file('file')->getSize() || $fileSize>config("configure.maxImgSizeByte"))
        {
            $obj->code = 0;
            $obj->msg = $fileSize."图片大小不能低于0或超过".config("configure.maxImgSize");;
            $obj->data = '';
            return response()->json($obj, 200);
        }
        try {
            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];

            $obj->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
            $obj->name = $name;
            responseData(\StatusCode::SUCCESS,'上传成功',$obj);
        } catch (Exception $e)
        {
            responseData(\StatusCode::ERROR,'上传失败');
        }
    }

    /**
     * @param $name
     * 删除临时图片
     */
    public function delImg( $name )
    {
        @unlink(public_path().'/temp/'.$name);
    }

    /**
     * 当前位置周边小区
     */
    public function getMapAddress( Request $request )
    {
        $keyword = urlencode('小区');
        $latitude  = $request->input('latitude');
        $longitude  = $request->input('longitude');
        if( $keyword )
        {
            $url = 'http://apis.map.qq.com/ws/place/v1/search?boundary=nearby('.$latitude.','.$longitude.',1000)&page_size=20&page_index=1&keyword='.$keyword.'&orderby=_distance&key=N6LBZ-XRSWP-NM5DY-LW7S6-GCKO7-WBFF7';
            $data = file_get_contents($url);
            $data = json_decode($data);
            if( $data->status == 0 )
            {
                responseData(\StatusCode::SUCCESS,'小区信息',$data->data);
            }
            responseData(\StatusCode::ERROR,'');

        }else
        {
            responseData(\StatusCode::ERROR,'');
        }
    }



    /**
     *  获取腾讯地图搜索的地址
     */
    public function seachMapAddress( Request $request )
    {
        $keyword = $request->input('keyword');
        if( $keyword )
        {
            $url = 'https://apis.map.qq.com/ws/place/v1/suggestion/?filter%3Dcategory%3D%E5%B0%8F%E5%8C%BA&keyword='.$keyword.'&key=N6LBZ-XRSWP-NM5DY-LW7S6-GCKO7-WBFF7';
            $data = file_get_contents($url);
            $data = json_decode($data);
            if( $data->status == 0 )
            {
                responseData(\StatusCode::SUCCESS,'小区信息',$data->data);
            }
        }
    }
}