<?php
namespace App\Http\Controllers\Admin;
use \App\Http\Controllers\Common\AdminBaseController;


/***
 * 账号设置
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /***
     * 后台账号
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index(){
        return view('admin.admin.index');
    }
   

}