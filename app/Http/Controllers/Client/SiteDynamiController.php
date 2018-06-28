<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Business\Client\SiteDynamic;
use App\Http\Controllers\Common\ClientBaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class SiteDynamiController extends ClientBaseController
{
    public $dynamic;
    public function __construct(SiteDynamic $dynamic)
    {
        parent::__construct();
        $this->dynamic = $dynamic;
    }


    /**
     * 动态列表
     */
    public function getDynamicList()
    {
        $sitetid = $this->request->input('sitetid');
        $user = $this->apiUser;
        //判断用户信息如果是B端只显示当前店铺的动态
        if( $user->type == 0 )
        {
            if( $user->isinvitationed != 1 )
            {
                //B端用户
                switch ( (int)$user->islook )
                {
                    case 1:
                        //全部
                        break;
                    case 2:
                        //城市
                        $where['cityid'] = $user->cityid;
                        break;
                    case 3:
                        //门店
                        $where['storeid'] = $user->storeid;
                        break;
                }
            }
        }else
        {
            //C端用户全部展示
            if(  $sitetid )
            {
                //有工地ID
                $where['sitetid'] = $sitetid;
            }
        }
        $where['companyid'] = $this->apiUser->companyid;
        $res = $this->dynamic->DynamicList( $where, $this->request,$user );
        responseData(\StatusCode::SUCCESS,'动态信息',$res);
    }

    /**
     * 删除动态
     */
    public function destroyDynamic()
    {
        $data = $this->request->all();
        $user = $this->apiUser;
        $validator = Validator::make(
            $data,
            [
                'id' => 'bail|required',
            ], [
                'id.required' => 'ID不能为空',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM, '验证失败', '', $messages);
        }
        $where['id'] = $data['id'];
        $where['companyid'] = $user->companyid;
        if( $user->isadmin != 1 )
        {
            $where['createuserid'] = $user->id;
            $where['storeid'] = $user->storeid;
        }
        $res = $this->dynamic->destroyDynamic( $where );
        if( $res )
        {
            Cache::tags(['DynamicList'.$user->companyid,'DynamicListPc'.$user->companyid])->flush();
            responseData(\StatusCode::SUCCESS,'删除成功');
        }
        responseData(\StatusCode::ERROR,'删除失败',$res);
    }

    /**
     * 修改动态
     */
    public function dynamicUp()
    {
        $data = $this->request->all();
        $user = $this->apiUser;
        if( $this->request->method() === 'POST' )
        {
            $validator = Validator::make(
                $data,
                [
                    'id' => 'bail|required',
                    'content'=>'required|max:300',
                    'img'=>'present',
                    'delimg'=>'present',
                ], [
                    'id.required' => 'ID不能为空',
                    'content.required' => '内容不能为空',
                    'content.max' => '内容不能超过300个字',
                    'img.present' => '图片缺少',
                    'delimg.present' => '图片缺少',
                ]
            );
            if ($validator->fails())
            {
                $messages = $validator->errors()->first();
                responseData(\StatusCode::CHECK_FORM, '验证失败', '', $messages);
            }
            $where['id'] = $data['id'];
            $where['companyid'] = $user->companyid;
            $res = $this->dynamic->dynamicUp($where,$data);
            if(  $res == true )
            {
                Cache::tags(['DynamicList'.$user->companyid,'DynamicListPc'.$user->companyid])->flush();
                responseData(\StatusCode::SUCCESS,'修改成功');
            }
            responseData(\StatusCode::ERROR,'修改失败');
        }else
        {
           $where['id'] = $data['id'];
           $where['companyid'] = $user->companyid;
           $res = $this->dynamic->dynamicInfo($where);
           responseData(\StatusCode::SUCCESS,'动态收据',$res);
        }
    }
}