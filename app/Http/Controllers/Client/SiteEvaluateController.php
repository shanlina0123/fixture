<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/21
 * Time: 13:52
 */

namespace App\Http\Controllers\Client;


use App\Http\Business\Client\SiteEvaluate;
use App\Http\Business\Common\WxAlone;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Controllers\Common\ClientBaseController;
use Illuminate\Support\Facades\Validator;
class SiteEvaluateController extends ClientBaseController
{

    public $siteEvaluate;
    public function __construct( SiteEvaluate $siteEvaluate )
    {
        parent::__construct();
        $this->siteEvaluate = $siteEvaluate;
    }

    /**
     * 业主评价
     */
    public function ownerEvaluate()
    {
        $data = trimValue($this->request->all());
        $validator = Validator::make(
            $data,
            [
                'siteid'=>'bail|required',//工地id
                'sitestageid'=>'bail|required',//工地阶段id
                'sitestagename'=>'bail|required',//工地阶段名称
                'score'=>'bail|required',//评分
                'content'=>'bail|required|max:300',//评价内容
            ],[
                'siteid.required'=>'请选择评论的工地',
                'sitestageid.required'=>'请选择阶段',
                'sitestagename.required'=>'请选择阶段名称',
                'score.required'=>'请评价星级',
                'content.required'=>'请填写评价内容',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,$messages);
        }
        $res = $this->siteEvaluate->ownerEvaluate( $data, $this->apiUser );
        if( $res === true )
        {
            responseData(\StatusCode::SUCCESS,'评价成功');
        }else
        {
            responseData(\StatusCode::ERROR,'评价失败');
        }
    }

    /**
     * 评价信息
     */
    public function evaluateInfo()
    {
        $data = trimValue($this->request->all());
        $res = $this->siteEvaluate->evaluateInfo( $data, $this->apiUser );
        responseData(\StatusCode::SUCCESS,'评价信息',$res);
    }

    /**
     * 删除评价
     */
    public function evaluateDestroy()
    {
        $data = trimValue($this->request->all());
        $res = $this->siteEvaluate->evaluateDestroy( $data, $this->apiUser );
        if( $res )
        {
            responseData(\StatusCode::SUCCESS,'删除成功',$res);

        }else
        {
            responseData(\StatusCode::SUCCESS,'删除失败',$res);
        }
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
        $siteid = $this->request->input('siteid');
        $type = 'evaluate';
        $scene = $siteid;
        $companyid = $this->request->input('companyid');
        $wx->createWxappCode($companyid,$type,$scene,500);
    }
}