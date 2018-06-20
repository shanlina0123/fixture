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
        try {
            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];
            $obj = new \stdClass();
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
}