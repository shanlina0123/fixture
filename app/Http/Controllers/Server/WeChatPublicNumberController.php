<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 9:40
 * 微信公众平台操作类
 */

namespace App\Http\Controllers\Server;


use App\Http\Business\Server\WeChatPublicNumberBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;

class WeChatPublicNumberController extends ServerBaseController
{

    public $weChat;
    public $request;
    public function __construct( Request $request, WeChatPublicNumberBusiness $weChat)
    {
        parent::__construct();
        $this->request = $request;
        $this->weChat = $weChat;
    }
}