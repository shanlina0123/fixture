<?php

namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;

use Illuminate\Support\Facades\Cache;

class IndexController extends ServerBaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 入口文件
     */
    public function index()
    {
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