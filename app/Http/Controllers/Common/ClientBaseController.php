<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
class ClientBaseController extends Controller
{
    public $apiUser;
    public $request;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->request = $request;
            $apiUser = $request->get('apiUser');
            $this->apiUser = $apiUser?$apiUser->tokenToUser:'';
            return $next( $request );
        });
    }
}
