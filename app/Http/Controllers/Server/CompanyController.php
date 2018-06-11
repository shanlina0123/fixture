<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\CompanyBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

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
            //验证规则
            $validator = Validator::make($request->all(),[
                "name"=>'required|max:100|min:0',
                "fullname"=>'max:255|min:0',
                "addr"=>'max:255|min:0',
                "resume"=>'max:300|min:0',
            ],['name.required'=>'公司名称不能为空','name.max'=>'公司名称长度不能大于100个字符','name.min'=>'公司名称不能小于0个字符',
                'fullname.max'=>'公司简称长度不能大于255个字符','fullname.min'=>'公司简称不能小于0个字符',
                'addr.max'=>'公司详细地址长度不能大于255个字符','addr.min'=>'公司详细地址不能小于0个字符',
                'resume.max'=>'公司介绍长度不能大于300个字符','resume.min'=>'公司介绍不能小于0个字符',
                'phone.max'=>'公司电话长度不能大于30个字符','phone.min'=>'公司电话不能小于0个字符']);

            //进行验证
            if ($validator->fails()) {
                return redirect()->route('company-setting')->with('errormsg',$validator->errors()->first());
            }

            $data = trimValue(array_except($request->all(),['_token']));
            $res = $this->company->setCompany($data);
            if( $res->ststus == 1 )
            {
                $userInfo = session('userInfo');
                Cache::forget('CompanyInfo'.$userInfo->companyid);
                Cache::tags(['site'.$userInfo->companyid])->flush();
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
