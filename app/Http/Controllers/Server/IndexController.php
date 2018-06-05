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
        event('log.notice',array('type'=>22,'data'=>1));
        //Cache::flush();
        return view('server.index.index');
    }

    /**
     *  后台首页
     */
    public function indexContent()
    {
       // Cache::flush();
        return view('server.index.index');
    }


}