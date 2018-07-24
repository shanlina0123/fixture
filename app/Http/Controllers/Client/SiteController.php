<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20
 * Time: 16:44
 */

namespace App\Http\Controllers\Client;


use App\Http\Business\Client\Site;
use App\Http\Controllers\Common\ClientBaseController;

class SiteController extends ClientBaseController
{
    public $site;
    public function __construct( Site $site )
    {
        parent::__construct();
        $this->site = $site;
    }

    /**
     * 工地筛选条件
     */
    public function siteScreeningConditions()
    {
        $companyId = $this->apiUser->companyid;
        $data = $this->site->siteScreeningConditions( $companyId );
        responseData(\StatusCode::SUCCESS, '工地筛选条件',$data);

    }
    /**
     * C端工地列表
     */
    public function siteList()
    {
        $where = trimValue($this->request->all());
        $where['companyid'] = $this->apiUser->companyid;
        $data = $this->site->siteList( $where );
        responseData(\StatusCode::SUCCESS, '列表信息',$data);
    }
}