<?php

namespace App\Http\Controllers\Server;
use App\Http\Controllers\Common\ServerBaseController;

use App\Http\Model\Activity\ActivityLuckyPrize;
use App\Http\Model\Activity\ActivityLuckyRecord;
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