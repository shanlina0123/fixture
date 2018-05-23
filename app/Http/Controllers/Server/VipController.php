<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\VipBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VipController extends ServerBaseController
{
    protected $request;
    protected $vip;
    public function __construct( VipBusiness $vip, Request $request)
    {
        $this->request = $request;
        $this->vip_business = $vip;
    }

    public function index()
    {
        return view('server.error.coming');
    }

}