<?php
namespace App\Http\Controllers\Admin;
use \App\Http\Controllers\Common\AdminBaseController;


/***
 * 平台用户管理
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /***
     * 平台用户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index(){
        return view('admin.used.index');
    }


}