<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Common\ClientBaseController;
use App\Http\Model\Company\Company;
use Illuminate\Support\Facades\Cache;

class ClientCompanyController extends ClientBaseController
{
    public function __construct( )
    {
        parent::__construct();
    }


    /**
     * 公司信息
     */
    public function companyInfo()
    {
        $user = $this->apiUser;
        $where['id'] = $user->companyid;
        if( Cache::get('CompanyInfo'.$user->companyid) )
        {
            $res = Cache::get('CompanyInfo'.$user->companyid);
        }else
        {
            $res = Company::where($where)->select('name','fullname','phone','fulladdr','resume','logo','covermap')->first();
            $res->applicationName = config('configure.applicationName');
            Cache::put('CompanyInfo'.$user->companyid,$res,config('configure.sCache'));
        }
        if( !$res )
        {
            responseData(\StatusCode::ERROR,'查询失败');
        }
        responseData(\StatusCode::SUCCESS,'公司信息',$res);
    }


}