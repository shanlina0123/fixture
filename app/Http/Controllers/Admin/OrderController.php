<?php
namespace App\Http\Controllers\Admin;
use \App\Http\Controllers\Common\AdminBaseController;


/***
 * 订单管理
 * Class OrderController
 * @package App\Http\Controllers\Admin
 */
class OrderController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /***
     * 线上订单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function index(){
        return view('admin.order.index');
    }

    /***
     * 线下订单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     */
    public function  entity()
    {
        return view('admin.order.entity');
    }

}