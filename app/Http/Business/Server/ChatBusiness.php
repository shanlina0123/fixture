<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\JmessageBusiness;
use App\Http\Business\Common\ServerBase;

class ChatBusiness extends ServerBase
{

    public $jmessage;
    public function __construct()
    {
        $this->jmessage =  new JmessageBusiness();
    }


    /***
     * 获取用户信息+好友列表
     */
    public function index($userid)
    {
        //极光账号
        $username=username($userid);

        //检查极光账号是否登录
        $this->jmessage->userStat(username($userid));

        //用户信息
        $list["user"]=$this->jmessage->userShow();
        //好友列表
        $list["friends"]=$this->jmessage->friendListAll($username);
        return $list;
    }




}