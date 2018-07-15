<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 14:24
 */

namespace App\Http\Controllers\Common;

use App\Http\Business\Common\JmessageBusiness;
use App\Http\Business\Common\SystemMessage;
use App\Http\Business\Server\WeChatPublicNumberBusiness;
use App\Http\Controllers\Controller;
use App\Http\Model\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class SystemMessageController extends Controller
{

    public $systemMessage;
    public $request;
    public $apiUser;
    public function __construct(SystemMessage $systemMessage, Request $request)
    {
        $this->request = $request;
        $this->systemMessage = $systemMessage;
        $this->middleware(function ($request, $next) {
            $apiUser = $request->get('apiUser');
            $this->apiUser = $apiUser?$apiUser->tokenToUser:'';
            return $next( $request );
        });
    }


    /*
     * 消息列表
     */
    public function notice()
    {
        $data = trimValue($this->request->all());
        $data['userid'] = $this->apiUser->id;
        $validator = Validator::make(
            $data,[
            'userid'=>'required',
            ],[
            'userid.required'=>'用户信息不存在',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }

        $res = $this->systemMessage->getNoticeList( $data );
        responseData(\StatusCode::SUCCESS,'通知信息',$res);
    }

    /**
     * 读取消息
     */
    public function readNotice()
    {
        $data = trimValue($this->request->all());
        $data['userid'] = $this->apiUser->id;
        $data['companyid'] = $this->apiUser->companyid;
        $validator = Validator::make(
            $data,[
                'userid'=>'required',
                'id'=>'sometimes|required'
            ],[
              'userid.required'=>'用户信息不存在',
              'id.required'=>'消息ID不能为空',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->systemMessage->readNotice( $data );
        if ($res)
        {
            Cache::tags(['NoticeList'.$data['userid']])->flush();
            responseData(\StatusCode::SUCCESS,'读取成功');
        }
        responseData(\StatusCode::ERROR,'读取失败');

    }

    /**
     * -------------------------------------------------
     *
     *   极光消息
     *
     * -------------------------------------------------
     */


    /**
     * 极光初始化
     */
    public function getJmessageInIt()
    {
        $Jmessages = new JmessageBusiness();
        $res = $Jmessages->getJmessageInIt();
        responseData(\StatusCode::SUCCESS,'初始化信息',$res);
    }

    /**
     * 极光注册
     */
    public function jmessageRegister()
    {
        $userid = $this->apiUser->id;
        $Jmessages = new JmessageBusiness();
        $userName = username($userid);
        $user =  $Jmessages->userRegister( $userName,'',$this->apiUser->nickname,['faceimg'=>$this->apiUser->faceimg]);
        if ( !array_key_exists("error", $user["body"][0]) )
        {
            $userInfo = User::where(['id'=>$userid,'companyid'=>$this->apiUser->companyid])->first();
            $userInfo->jguser = $user["body"][0]["username"];
            $userInfo->save();

            $obj = new \stdClass();
            $obj->username = $userInfo->jguser;
            $obj->pass = config('jmessage.defaultpwd');
            responseData(\StatusCode::SUCCESS,'注册成功',$obj);

       }else
       {
           responseData(\StatusCode::ERROR,'注册失败');
       }
    }

    /**
     * 极光好友列表
     */
    public function jmessageFriendList()
    {
        //$companyid = $this->apiUser->companyid;
        $Jmessages = new JmessageBusiness();
        $res = $Jmessages->friendListAll($this->apiUser->jguser);
        $arr = [];
        $userName = array_pluck($res['body'],'username');
        $img = User::whereIn('jguser',$userName)->pluck('faceimg', 'jguser');
        foreach ( $img as $jguser=>$faceimg )
        {
            foreach ( $res['body'] as $row )
            {
                if( $row['username'] == $jguser )
                {
                    $obj = new \stdClass();
                    $obj->username = $row['username'];
                    $obj->nickname = $row['nickname'];
                    $obj->faceimg = $faceimg?$faceimg:"../../../images/uhead.png";
                    $arr[] = $obj;
                }
            }
        }
        responseData(\StatusCode::SUCCESS,'好友列表',$arr);
    }

    /**
     * 添加好友
     */
    public function jmessageFriendAdd()
    {
        $username = $this->apiUser->jguser;
        $friends = $this->request->input('username');
        $Jmessages = new JmessageBusiness();
        $Jmessages->friendAdd($username,[$friends]);
    }


    /**
     * 好友信息
     */
    public function jmessageGetUserInfo()
    {
        $username = $this->request->input('username');
        $Jmessages = new JmessageBusiness();
        $user = $Jmessages->userShow($username);
        var_dump($user);
    }


    /**
     * 检测对方在线不
     */
    public function jmessageUserTesting()
    {
        $friends = $this->request->input('username');
        $content = $this->request->input('content');
        $createuserid = $this->request->input('createuserid');
        $Jmessages = new JmessageBusiness();
        $res = $Jmessages->userStat($friends);
        if( array_has($res,'body'))
        {
            if(  $res['body']['login'] != true &&  $res['body']['online'] != true)
            {
                //对方不在线发送微信消息
                $user = $this->apiUser;
                $wchat = new WeChatPublicNumberBusiness();
                $event['sourceid'] = 1;//发送留言信息对的是个人
                $event['createuserid'] = $createuserid;//发送留言信息对的是个人
                $event['name'] = $user->nickname;
                $event['content'] = $content;
                $wchat->processingData($user->companyid, 2, $event );
            }
        }
    }

}