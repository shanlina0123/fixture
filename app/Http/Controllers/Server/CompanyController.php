<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\CompanyBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CompanyController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $company;

    /**
     * 创建新的控制器实例
     *
     * @param UserRepository $users
     * @return void
     */
    public function __construct(CompanyBusiness $company)
    {

        $this->company = $company;
    }

    public function companySetting(Request $request)
    {
        if( $request->method() === 'POST' )
        {
            $request->validate([
                'name' => 'required',
            ]);
            $data = trimValue(array_except($request->all(),['_token']));
            $res = $this->company->setCompany($data);
            if( $res->ststus == 1 )
            {
                $userInfo = session('userInfo');
                Cache::forget('CompanyInfo'.$userInfo->companyid);
                if( $data['returnUrl'] )
                {
                    return redirect($data['returnUrl']);
                }else
                {
                    return redirect()->route('company-setting')->with('msg',$res->msg);
                }
            }else
            {
                return redirect()->route('company-setting')->with('msg',$res->msg);
            }

        }else
        {
            $data = $this->company->getCompany();
            return view('server.company.setting',compact('data'));
        }
    }
}
