<?php

namespace App\Http\Controllers\Server;

use App\Http\Business\Common\WxAlone;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;

class IndexController extends ServerBaseController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 入口文件
     */
    public function index(Request $request)
    {
        //echo encrypt('ab5e6a0349268ed349fa976aef7babf3');die;
        return view('server.index.main');
    }

    /**
     *  后台首页
     */
    public function indexContent()
    {
        return view('server.index.index');
    }
}