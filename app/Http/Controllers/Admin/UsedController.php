<?php
namespace App\Http\Controllers\Admin;
use \App\Http\Controllers\Common\AdminBaseController;


/***
 * 商户管理
 * Class UsedController
 * @package App\Http\Controllers\Admin
 */
class UsedController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /***
     * 免费版商户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index(){
        return view('admin.used.index');
    }
    /***
     * 标准版商户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function fee()
    {
        return view('admin.used.fee');
    }
    /***
     * 定制版版商户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function  entity()
    {
        return view('admin.used.entity');
    }

}