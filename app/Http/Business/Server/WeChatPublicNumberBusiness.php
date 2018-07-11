<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/11
 * Time: 9:43
 */

namespace App\Http\Business\Server;


use App\Http\Business\Common\ServerBase;
use App\Http\Model\Company\CompanyMpTemplate;
use App\Http\Model\User\UserMpTemplate;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Support\Facades\Cache;

class WeChatPublicNumberBusiness extends ServerBase
{
    private static $send_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?';
    private static $token_url = 'https://api.weixin.qq.com/cgi-bin/token?';

    /**
     * 发送模板消息
     */
    private function sendMessage( $data )
    {

        $url = self::$send_url.'access_token='.$data->access_token;
        $content = $data->content;
        $b = wxPostCurl( $url, $content );
        var_dump( $b );

    }


    /**
     * 发送之前数据处理
     * type 模板类型
     * data 数据
     * $companyId 公司id
     */
    public function processingData( $companyId, $type, $data )
    {
        //1.查询
        if( $data['sourceid'] != 1 )
        {
            //发给默认的管理员
            $res = UserMpTemplate::where(['isdefault'=>1,'datatemplateid'=>$type])->with('userToCompanyTemplate')->first();
        }else
        {
            //发给对应的添加人员
            $res = UserMpTemplate::where(['userid'=>$data['createuserid'],'datatemplateid'=>$type])->with('userToCompanyTemplate')->first();
            if( $res == false )
            {
                $res = UserMpTemplate::where(['isdefault'=>1,'datatemplateid'=>$type])->with('userToCompanyTemplate')->first();
            }
        }
        if( $res )
        {
            //开启通知且有接收人才能收到消息
            if( $res->mpstatus == 1 && $res->mpopenid )
            {
                switch ( (int)$type )
                {
                    case 1://客户预约通知
                        $this->customerReservation($res,$companyId, $data );
                        break;
                }
            }
        }
    }

    /**
     * @param $res
     * @param $data
     * 客户预约通知
     */
    private function customerReservation( $res, $companyId, $data )
    {
        try{

            $time = date('Y-m-d H:i');
            $obj = new \stdClass();
            $obj->access_token = $this->getAccessToken($companyId);
            $obj->content = array(
                'touser'=>$res->mpopenid,
                'template_id'=>$res->userToCompanyTemplate->mptemplateid,
                'data'=>array(
                    'first'=>['value'=>$data['title'].'消息提示',"color"=>"#173177"],
                    'keyword1'=>['value'=>$data['name']?$data['name']:'未填写姓名'],//客户姓名
                    'keyword2'=>['value'=>$data['phone']],//客户电话
                    'keyword3'=>['value'=>$time],
                    'keyword4'=>['value'=>$data['title']],
                    'remark'=>['value'=>array_has($data,'uarea')?'住房面积'.$data['uarea'].'㎡，选择城市，'.$data['clientcity']:'选择城市，'.$data['clientcity']],
                )
            );
            //发送
            $this->sendMessage($obj);
        }catch (\Exception $e)
        {
            return false;
        }
    }


    /**
     * 获取全局token
     */
    private function getAccessToken( $companyId )
    {

        if( Cache::get('mp_access_token'.$companyId) )
        {
            $access_token = Cache::get('mp_access_token'.$companyId);

        }else
        {
            $res = SmallProgram::where('companyid',$companyId)->select('union_wechat_mp_appid','union_wechat_mp_appsecret')->first();
            $url = self::$token_url.'grant_type=client_credential&appid='.$res->union_wechat_mp_appid.'&secret='.decrypt($res->union_wechat_mp_appsecret);
            $data = getCurl($url,0);
            if( $data )
            {
                $data = json_decode($data,true);
                if( !array_has($data,'errcode') )
                {
                    Cache::put('mp_access_token'.$companyId,$data['access_token'],$data['expires_in']/60);
                    $access_token = $data['access_token'];
                }else
                {
                    $access_token = '';
                }
            }else
            {
                $access_token = '';
            }
        }
        return $access_token;
    }
}