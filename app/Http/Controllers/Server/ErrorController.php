<?php
namespace App\Http\Controllers\Server;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ErrorController extends Controller
{

    /***
     * 404
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function undefined()
    {
        return view('server.error.undefined');
    }

    /***
     * 500系统错误
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  syserror()
    {
        return view('server.error.syserror');
    }

    /***
     * 无权限
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lock()
    {
        return view('server.error.lock');
    }

    public function coming()
    {
        return view('server.error.coming');
    }
}