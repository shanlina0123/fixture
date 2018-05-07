<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\FilterBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
class FilterController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $filter;

    /**
     * 创建新的控制器实例
     *
     * @param UserRepository $users
     * @return void
     */
    public function __construct(FilterBusiness $filter)
    {
        $this->filter = $filter;
    }

    /***
     * 获取门店列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeIndex(Request $request)
    {
        if( $request->method() === 'POST' )
        {

        }else
        {
            $data = $this->filter->getStoreList();
            return view('server.filter.store-index',compact('data'));
        }
    }
    /***
     * 获取角色列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleIndex(Request $request)
    {
            $data = $this->filter->getRoleList();
            return view('server.filter.role-index',compact('data'));
    }
}
