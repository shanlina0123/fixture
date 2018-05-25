<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Business\Client\ClientSiteInvitation;
use App\Http\Controllers\Common\ClientBaseController;
class ClientSiteInvitationController extends ClientBaseController
{
    public $clientSiteInvitation;
    public function __construct( ClientSiteInvitation $clientSiteInvitation )
    {
        parent::__construct();
        $this->clientSiteInvitation = $clientSiteInvitation;
    }


    /**
     * 我的装修
     */
    public function siteInvitation()
    {
        $user = $this->apiUser;
        $where['companyid'] = $user->companyid;
        $where['userid'] = $user->id;
        $res = $this->clientSiteInvitation->siteInvitation( $where, $this->request );
        responseData(\StatusCode::SUCCESS,'我的装修',$res);
    }


}