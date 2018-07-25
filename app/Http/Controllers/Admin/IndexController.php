<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Common\AdminBaseController;

/***
 * 控制面板
 * Class IndexController
 * @package App\Http\Controllers\Admin
 */
class IndexController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 入口文件
     */
    public function index()
    {
        return view('admin.index.main');
    }

    /**
     *  后台首页
     */
    public function indexContent()
    {
        return view('admin.index.index');
    }
}