<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\TestBusiness;
use App\Http\Controllers\Common\ServerTestBaseController;
use Illuminate\Http\Request;

/***
 * 测试
 * Class TestController
 */
class TestController extends ServerTestBaseController
{
    /**
     * The user repository instance.
     */
    protected $test_business;
    protected $request;
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->test_business =  new TestBusiness($request);
        $this->request = $request;
    }


    /***
     * 获取列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->test_business->index();
    }




}
