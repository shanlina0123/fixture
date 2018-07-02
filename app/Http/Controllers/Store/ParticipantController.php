<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 10:17
 */

namespace App\Http\Controllers\Store;


use App\Http\Business\Common\WxAlone;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Business\Store\ParticipantBusiness;
use App\Http\Controllers\Common\StoreBaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class ParticipantController extends StoreBaseController
{

    public $participant;
    public function __construct( ParticipantBusiness $participant )
    {
        parent::__construct();
        $this->participant = $participant;

    }

    /**
     * 参与者列表
     */
    public function participantList()
    {
        $user = $this->apiUser;
        $where['companyid'] = $user->companyid;
        $siteid = $this->request->input('siteid');
        if( $siteid )
        {
            //查询关联
            $where['siteid'] = $siteid;
            $res = $this->participant->participantToInvitation( $where );
        }else
        {
            $res = $this->participant->participantList( $where );
        }
        responseData(\StatusCode::SUCCESS,'参与者列表',$res);
    }

    /**
     * 职位
     */
    public function  positionList()
    {
        $where['status'] = 1;
        $where['companyid'] = $this->apiUser->companyid;
        $res = $this->participant->positionList( $where );
        responseData(\StatusCode::SUCCESS,'职位列表',$res);
    }

    /**
     * 二维码
     */
    public function code()
    {
        //1单独部署
        if( config('wxtype.type') == 1 )
        {
            $wx = new WxAlone();
        }else
        {
            $wx = new WxAuthorize();
        }
        $companyid = $this->request->input('companyid');
        $uid = $this->request->input('uid');
        $participant = $this->request->input('participant');
        $siteid = $this->request->input('siteid');
        $type = 'allow';
        //u代表邀请者id   p代表职位id   t代表类型 1为邀请2为绑定  因为此字段长度限制为32位所有简写
        $scene = http_build_query(['u'=>$uid,'p'=>$participant,'s'=>$siteid,'t'=>1]);
        $wx->createWxappCode($companyid,$type, $scene,'400');
    }

    /**
     * 添加成员
     */
    public function  addParticipant()
    {
        $data = trimValue( $this->request->all());
        $validator = Validator::make(
            $data, [
            'name' => 'bail|required|max:20',
            'positionid' => 'bail|required',

            ],[
                'name.required' => '请填写姓名',
                'positionid.required' => '请选择职位',
            ]
        );
        $data['companyid'] = $this->apiUser->companyid;
        $data['userid'] = $this->apiUser->id;
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->participant->addParticipant( $data );
        if( $res )
        {
            Cache::forget('companyParticipant'.$data['companyid']);
            responseData(\StatusCode::SUCCESS,'添加成功');
        }
        responseData(\StatusCode::ERROR,'添加失败');
    }

    /**
     * 删除成员
     */
    public function delParticipant()
    {
        $data = trimValue( $this->request->all());
        $validator = Validator::make(
            $data, [
            'siteid' => 'required',
            'joinuserid' => 'required',
            ],
            [
            'siteid.required' => '项目ID不能为空',
            'joinuserid.required' => '参与者ID不能为空',
            ]);
        $where['companyid'] = $this->apiUser->companyid;
        $where['siteid'] = $data['siteid'];
        $where['joinuserid'] = $data['joinuserid'];
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        $res = $this->participant->delParticipant( $where );
        if( $res == true )
        {
            responseData(\StatusCode::SUCCESS,'删除成功');
        }
        responseData(\StatusCode::ERROR,'删除失败');
    }


}