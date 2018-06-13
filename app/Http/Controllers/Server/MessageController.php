<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\MessageBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/***
 * 消息
 * Class MessageController
 * @package App\Http\Controllers\Server
 */
class MessageController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $message_business;
    protected $request;
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->message_business =  new MessageBusiness($request);
        $this->request = $request;
    }

    /***
     * 获取列表
     */
    public function index()
    {
        $data = SmallProgram::where(['companyid'=>$this->userInfo->companyid])->first();
        if( $data )
        {
            if($data->token)
            {
                return view('server.message.index',compact('data'));
            }
        }
        $data = $this->message_business->setSmallProgram(['companyid'=>$this->userInfo->companyid]);
        return view('server.message.index',compact('data'));
    }



}
