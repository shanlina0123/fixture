<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29
 * Time: 11:36
 * 小程序模板配置
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\WxAlone;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Model\Company\CompanyWxTemplet;
use App\Http\Model\User\User;
use Illuminate\Support\Facades\Log;

class WxTempletBusiness
{
    public function getTempletInfo()
    {
        //得到模板关键字
        //$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx676c383c431ecc6e&secret=650c2c8f0409';
        //$data = getCurl($url,0);
         //dd( $data );
        //token 11_Qd2XyTAGGbKhiZeSrtYMrCGxkYsRrusKEp192wfe32yvLt3InaJ9pH5i4H6JYqbUNCJ5_GNsM5kfMW-8XX77djlAC7AUh_SR9BFIAdgQssACaz75ejBERxzXY1wuTWuvH3UpiGEXcKmoWBMwCJJhAGAYFF
        //根据模板取得关键字
       // $kurl = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token=11_Qd2XyTAGGbKhiZeSrtYMrCGxkYsRrusKEp192wfe32yvLt3InaJ9pH5i4H6JYqbUNCJ5_GNsM5kfMW-8XX77djlAC7AUh_SR9BFIAdgQssACaz75ejBERxzXY1wuTWuvH3UpiGEXcKmoWBMwCJJhAGAYFF';
       // $kData = wxPostCurl($kurl,['id'=>'AT0463']);
        //dd($kData);
        //[{"keyword_id":1,"name":"套餐名称","example":"198元精品套餐"},
        //{"keyword_id":2,"name":"服务地址","example":"国际酒店808室"},
        //{"keyword_id":3,"name":"客户电话","example":"13503711234"},
        //{"keyword_id":4,"name":"下单时间","example":"2017年6月3日 11:07"},
        //{"keyword_id":5,"name":"预约时间","example":"2017-08-08 10:00"},
        //{"keyword_id":6,"name":"人数","example":"1人"},
        //{"keyword_id":7,"name":"项目名称","example":"声乐"},
        //{"keyword_id":8,"name":"商品名","example":"小吃三人组"},
        //{"keyword_id":9,"name":"客服姓名","example":"张三"},
        //{"keyword_id":10,"name":"预约车型","example":"2016款k5 2.0L 手动两驱"},
        //{"keyword_id":11,"name":"QQ号码","example":"1111111111"},
        //{"keyword_id":12,"name":"预约美容师","example":"某某某"},
        //{"keyword_id":13,"name":"客户名称","example":"客户名称"},
        //{"keyword_id":14,"name":"订单号","example":"453201710020001"},
        //{"keyword_id":15,"name":"预约类型","example":"预约安装"},
        //{"keyword_id":16,"name":"姓名","example":"请输入姓名"},
        //{"keyword_id":17,"name":"手机号码","example":"请输入手机号码"},
        //{"keyword_id":18,"name":"项目地址","example":"请输入项目地址"},
        //{"keyword_id":19,"name":"项目面积","example":"请输入项目面积"},
        //{"keyword_id":20,"name":"备注","example":"备注信息"},
        //{"keyword_id":21,"name":"预约店铺","example":"XX店铺"},
        //{"keyword_id":22,"name":"店铺电话","example":"0311-85851255"},
        //{"keyword_id":23,"name":"店铺地址","example":"桥东区中山东路125号"},
        //{"keyword_id":24,"name":"项目城市","example":"杭州"},
        //{"keyword_id":25,"name":"货物采购时间","example":"2018年1月1日"},
        //{"keyword_id":26,"name":"科室","example":"儿科"},
        //{"keyword_id":27,"name":"专家","example":"赵医生"},
        //{"keyword_id":28,"name":"客户来源","example":"微信公众号报名"},
        //{"keyword_id":29,"name":"报名时间","example":"2018-03-12"},
        //{"keyword_id":30,"name":"楼盘地址","example":"罗马景福城"},
        //{"keyword_id":31,"name":"小区名称","example":"罗马景福城"},
        //{"keyword_id":32,"name":"预约门店","example":"秀文路店"},
        //{"keyword_id":33,"name":"预约技师","example":"张珊珊"},
        //{"keyword_id":34,"name":"床位号","example":"1002"},
        //{"keyword_id":35,"name":"服务设施","example":"艾灸舱"},
        //{"keyword_id":36,"name":"预约单号","example":"WX201801010001"}]
    }

    /**
     * 添加模板
     */
    public function addTemplet( $companyid )
    {
        //1单独部署
        if( config('wxtype.type') == 1 )
        {
            $wx = new WxAlone();
            $access_token = $wx->getAccessToken($companyid);
        }else
        {
            $wx = new WxAuthorize();
            $access_token = $wx->getUserAccessToken('',$companyid);
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token='.$access_token;
        //客户预约通知
        $data = wxPostCurl($url,['id'=>'AT0463','keyword_id_list'=>[13,5,3,32,20]]);
        $data = json_decode($data,true);
        if( $data['errcode'] == 0 )
        {
            $obj = new CompanyWxTemplet;
            $obj->wid = 'AT0463';
            $obj->name = '客户预约通知';
            $obj->companyid = $companyid;
            $obj->templateid = $data['template_id'];
            $obj->content = '客户名称,预约时间,客户电话,预约类型,备注';
            $obj->type = 1;
            $obj->created_at = date("Y-m-d H:i:s");
            $obj->save();
        }
    }

    /**
     * 发送模板消息
     */
    public function sendTemplet( $data,$companyid, $type )
    {
        //1单独部署
        if( config('wxtype.type') == 1 )
        {
            $wx = new WxAlone();
            $access_token = $wx->getAccessToken($companyid);
        }else
        {
            $wx = new WxAuthorize();
            $access_token = $wx->getUserAccessToken('',$companyid);
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        $res = CompanyWxTemplet::where(['companyid'=>$companyid,'type'=>$type])->first();
        switch ( (int)$type )
        {
            case 1://客户预约通知 客户名称,预约时间,客户电话,预约类型,备注
                $openid = User::where(['companyid'=>$companyid,'isadmin'=>1])->value('wechatopenid');
                $time = date("Y年m月d日");
                $post = array(
                    'touser'=>$openid,
                    'template_id'=>$res->templateid,
                    "form_id"=> "{$data['formId']}",
                    //'page'=>'client/client',
                    'data'=>array(
                        'keyword1'=>['value'=>$data['name']],//客户姓名
                        'keyword2'=>['value'=>$time],//预约时间
                        'keyword3'=>['value'=>$data['phone']],//客户电话
                        'keyword4'=>['value'=>$data['title']],//预约类型
                        'keyword5'=>['value'=>'客户预约信息进入查看更多'],
                    )
                );
                wxPostCurl($url,$post);
                break;
        }
    }
}