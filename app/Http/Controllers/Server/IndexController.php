<?php

namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;

class IndexController extends ServerBaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 入口文件
     */
    public function index()
    {
        return view('server.index');
    }

    /**
     *  后台首页
     */
    public function indexContent()
    {
        return view('server.index.index');
    }
}