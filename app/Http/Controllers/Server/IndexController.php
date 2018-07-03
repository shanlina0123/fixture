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
        //dd(http_build_query(['u'=>1,'p'=>2,'s'=>3,'t'=>1]));
        return view('server.index.index');
    }

    /**
     *  后台首页
     */
    public function indexContent()
    {
        return view('server.index.index');
    }
}