<?php

namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class IndexController extends ServerBaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 入口文件
     */
    public function index()
    {
       /* $arr8 = array(
            array("id"=>1,"name"=>"安慰奖","percent"=>10),
            array("id"=>2,"name"=>"玩具车","percent"=>1),
            array("id"=>3,"name"=>"自行车","percent"=>0),
            array("id"=>4,"name"=>"电动车","percent"=>0),
            array("id"=>5,"name"=>"摩托","percent"=>0),
            array("id"=>6,"name"=>"拖拉机","percent"=>0),
            array("id"=>7,"name"=>"夏利","percent"=>6),
            array("id"=>8,"name"=>"奥迪","percent"=>0),
        );
        //下标存储数组100个下表，0-7 按概率分配对应的数量
        $indexArr = array();
        for($i=0;$i<sizeof($arr8);$i++){
            for($j=0;$j<$arr8[$i]['percent'];$j++){
                //index 追加到数组indexArr
                array_push($indexArr, $i);
            }
        }

        //数组乱序
        shuffle($indexArr);
        dd($indexArr);
        //从下标数组中随机取一个下标作为中奖下标，$rand_index 是$indexArr的随机元素的下标（0-99）
        $rand_index = array_rand($indexArr,1);
        //获取中奖信息
        $prize_index = $indexArr[$rand_index];
        $prizeInfo = $arr8[$prize_index];


        $data['pnum'] = $prize_index;//对应前端奖品编号
        $data['pid'] = $prizeInfo['id'];
        $data['pname'] = $prizeInfo['name'];

        dd($data);*/
        Cache::flush();
        return view('server.index.index');
    }

    /**
     *  后台首页
     */
    public function indexContent()
    {
        Cache::flush();
        return view('server.index.index');
    }


}