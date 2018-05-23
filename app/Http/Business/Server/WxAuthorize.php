<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 11:26
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class WxAuthorize extends ServerBase
{

    public $appid;
    public $extAppid;
    public $secret;
    public $url;
    public $component_access_token;

    public function __construct()
    {
        $this->appid = config('wxconfig.appId');
        $this->extAppid = config('wxconfig.extAppid');
        $this->secret = config('wxconfig.secret');
        $this->url = config('wxconfig.url');
        $this->component_access_token = $this->getAccessToken();
    }


    /**
     * @return string
     * 获取全局token
     */
    public function getAccessToken()
    {
        if( Cache::has('component_access_token') )
        {
            $access_token = Cache::get('component_access_token');

        }else
        {

            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
            $post['component_appid'] = $this->appid;
            $post['component_appsecret'] = $this->secret;
            $post['component_verify_ticket'] = Cache::get('ticket');
            $data = wxPostCurl( $url, $post );
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'component_access_token') )
                {
                    Cache::put('component_access_token',$data['component_access_token'],$data['expires_in']/60);
                    $access_token = $data['component_access_token'];
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


    /**
     * --------------------------------------------------------------------
     *
     *  授权前发起页面跳转
     *
     * --------------------------------------------------------------------
     */

    /**
     * @return string
     * 预授权code
     * $ID 用户id
     */
    public function preAuthCode( $ID )
    {

        if( Cache::has('pre_auth_code'.$ID) )
        {
            $pre_auth_code = Cache::get('pre_auth_code'.$ID);

        }else
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token='.$this->component_access_token;
            $post['component_appid'] = $this->appid;
            $data = wxPostCurl( $url, $post );
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'pre_auth_code') )
                {
                    Cache::put('pre_auth_code'.$ID ,$data['pre_auth_code'],$data['expires_in']/60);
                    $pre_auth_code = $data['pre_auth_code'];

                }else
                {
                    $pre_auth_code = '';
                }
            }else
            {
                $pre_auth_code = '';
            }
        }
        return $pre_auth_code;
    }

    /**
     * @param $code
     * @return string
     * 生成二微码
     */
    public function QRCodeUrl( $code )
    {
        return 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid='.$this->appid.'&pre_auth_code='.$code.'&redirect_uri='.$this->url;
    }




    /**
     * --------------------------------------------------------------------
     *
     *  授权后用户同意之后
     *
     * --------------------------------------------------------------------
     */


    /**
     * @param $data
     * @param $info
     * @param $setUrl
     * @param $code
     * @return bool
     * 授权回调
     */
    public function WxAuthorizeBack( $code )
    {
        try{

            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token='.$this->component_access_token;
            $post['component_appid'] = $this->appid;
            $post['authorization_code'] = $code;
            $data = wxPostCurl( $url, $post );
            if( $data )
            {
                $data = json_decode($data,true);
                if( array_has( $data,'authorization_info') )
                {
                    $data = $data['authorization_info'];
                    //用户信息
                    $info = $this->wxInfo( $data['authorizer_appid'] );
                    //设置小程序地址
                    $setUrl = $this->setUrl( $data['authorizer_access_token']  );
                    //提交代码
                    $upCode = $this->upCode( $data['authorizer_appid'], $data['authorizer_access_token'] );
                    //写入数据库
                    $wx = SmallProgram::where(['authorizer_appid'=>$data['authorizer_appid']])->first();
                    if( !$wx )
                    {
                        $companyID = session('userInfo')->companyid;
                        $wx = new SmallProgram();
                        $wx->companyid = $companyID;
                    }
                    $wx->authorization_info = json_encode($data);
                    $wx->authorizer_appid = $data['authorizer_appid'];
                    $wx->authorizer_access_token = $data['authorizer_access_token'];
                    $wx->expires_in = time()+(int)$data['expires_in'];
                    $wx->authorizer_refresh_token = $data['authorizer_refresh_token'];
                    $wx->func_info = json_encode($data['func_info']);
                    $wx->status = 0;
                    //用户信息
                    if( $info )
                    {
                        $wx->authorizer_info = json_encode($info);
                        $wx->nick_name =  $info['nick_name'];
                        $wx->head_img = array_has($info,'head_img')?$info['head_img']:'';
                        $wx->qrcode_url = array_has($info,'qrcode_url')?$info['qrcode_url']:'';
                        $wx->verify_type_info =  $info['verify_type_info']['id'];
                        $wx->user_name =  $info['user_name'];
                        $wx->principal_name = $info['principal_name'];
                    }
                    $wx->seturl = $setUrl?1:0;

                    //提交审核
                    if( $upCode == true )
                    {
                        $wx->uploadcode = 1;
                        $sourcecode = $this->upCodeLine( $data['authorizer_access_token'] );
                        //代码推送
                        if( $sourcecode->status == 1 )
                        {
                            $wx->sourcecode = 2;
                            $wx->auditid = $sourcecode->auditid;
                            $wx->errmsg = $sourcecode->msg;

                        }else
                        {
                            $wx->sourcecode = 0;
                            $wx->errmsg = $sourcecode->msg;
                        }

                    }else
                    {
                        $wx->uploadcode = 0;
                        $wx->sourcecode = 0;
                        $wx->errmsg = '代码提交失败';
                    }
                    return $wx->save();
                }else
                {
                    return false;
                }
            }else
            {
               return false;
            }
        }catch ( Exception $e )
        {
            return false;
        }
    }


    /**
     * 小程序信息
     */
    public function wxInfo( $authorizer_appid )
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token='.$this->component_access_token;
        $post['component_appid'] = $this->appid;
        $post['authorizer_appid'] = $authorizer_appid;
        $data = wxPostCurl( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( !array_has( $data,'authorizer_info') )
            {
                $data = false;
            }
            return $data['authorizer_info'];
        }
        return false;
    }


    /**
     * 设置小程序地址
     */
    public function setUrl( $acctoken )
    {
        $url = 'https://api.weixin.qq.com/wxa/modify_domain?access_token='.$acctoken;
        $post['action'] = 'set';
        $post['requestdomain'] = config('wxconfig.requestdomain');
        $post['wsrequestdomain'] = config('wxconfig.wsrequestdomain');
        $post['uploaddomain'] = config('wxconfig.uploaddomain');
        $post['downloaddomain'] = config('wxconfig.downloaddomain');
        $data = wxPostCurl( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( $data['errcode'] == 0 )
            {
                return true;
            }
            return false;
        }
        return false;
    }


    /**
     * ---------------------------------------------------------
     *
     *  发布代码
     *
     * ---------------------------------------------------------
     *
     */

    /**
     * 上传代码
     * $appid 授权用户的appid
     */
    public function upCode( $appid, $token=null, $anual=false )
    {
        if( !$token )
        {
            $token = $this->getUserAccessToken($appid);
            $anual = true;
        }
        $url = 'https://api.weixin.qq.com/wxa/commit?access_token='.$token;
        $ext_json['extAppid'] = $this->extAppid;
        $ext_json['ext'] = ['appid'=> $appid ];
        $post['template_id'] = config('wxconfig.template_id'); //模板id
        $post['ext_json'] = json_encode($ext_json,JSON_FORCE_OBJECT);
        $post['user_version'] = config('wxconfig.version');
        $post['user_desc'] = config('wxconfig.desc');
        $data = wxPostCurl( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( $data['errcode'] == 0 )
            {
                if( $anual )
                {
                     return $this->setCodeStatus( $appid );
                }
                return true;
            }
            return false;
        }
        return false;
    }


    /**
     * @param $token
     * 发布代码
     */
    public function upCodeLine( $token, $appid=null, $anual=false )
    {
        //$appid为真就表示手动提交的
        if( $appid )
        {
            $token = $this->getUserAccessToken($appid);
            $anual = true;
        }
        $obj = new \stdClass();
        $item = $this->getWxUserCategory( $token );
        if( $item == false || count($item) == 0 )
        {
            $obj->status = 0;
            $obj->msg = '请完善小程序用户信息';
            return $obj;
        }
        $url = 'https://api.weixin.qq.com/wxa/submit_audit?access_token='.$token;
        $post['item_list'] = [
                ['address'=>config('wxconfig.address'),
                'tag'=>config('wxconfig.tag'),
                'first_class'=>$item[0]['first_class'],
                'second_class'=>$item[0]['second_class'],
                'first_id'=>$item[0]['first_id'],
                'second_id'=>$item[0]['second_id'],
                'title'=>config('wxconfig.title')
                 ]
        ];
        $data = wxPostCurl($url,$post);
        if( $data )
        {
            $data = json_decode($data,true);
            if($data['errcode'] == 0 )
            {
                //$anual为真就表示手动提交的
                if( $anual )
                {
                    $obj->status = 1;
                    $obj->msg = '提交成功';
                    SmallProgram::where('authorizer_appid',$appid)->update(['sourcecode'=>2,'errmsg'=>'审核中','auditid'=>$data['auditid']]);
                    return $obj;
                }
                $obj->status = 1;
                $obj->auditid = $data['auditid'];
                $obj->msg = '审核中';
                return $obj;
            }else
            {
                $obj->status = 0;
                switch ( (int)$data['errcode'] )
                {
                    case -1:
                         $obj->msg = '系统繁忙';
                         break;
                    case 85009:
                         $obj->msg = '已经有正在审核的版本';
                         break;
                    case 85077:
                         $obj->msg = '小程序类目信息失效（类目中含有官方下架的类目，请重新选择类目）';
                         break;
                    case 86002:
                        $obj->msg = '小程序还未设置昵称、头像、简介。请先设置完后再重新提交。';
                        break;
                    case 85085:
                        $obj->mg = '近7天提交审核的小程序数量过多，请耐心等待审核完毕后再次提交';
                        break;
                    default:
                        $obj->msg = '发布失败';
                        break;
                }
                if( $anual )
                {
                    SmallProgram::where('authorizer_appid',$appid)->update(['errmsg'=>$obj->msg]);
                }
                return $obj;
            }
        }
        $obj->status = 0;
        $obj->msg = '发布失败';
        return $obj;
    }
    /**
     * 修改代码状态
     */
    public function setCodeStatus( $appid )
    {
        $res = SmallProgram::where('authorizer_appid',$appid)->first();
        if( $res )
        {
            $res->uploadcode = 1;
            if( $res->save() )
            {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * @param $appid
     * @param $sourcecode
     * @param $msg
     * @return bool
     * 审核结果
     */
    public function wxExamine( $appid,$sourcecode,$msg )
    {
        $res = SmallProgram::where('authorizer_appid',$appid)->first();
        if( $res )
        {
            $res->sourcecode = $sourcecode;
            $res->errmsg = $msg;
            if( $res->save() )
            {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * @param $token
     * @return bool
     * 小程序类目
     */
    public function getWxUserCategory( $token )
    {
        $url = 'https://api.weixin.qq.com/wxa/get_category?access_token='.$token;
        $data = getCurl($url);
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        //var_dump($body);
        if( $body )
        {
            $body = json_decode($body,true);

            if($body['errcode'] == 0 )
            {
               return $body['category_list'];
            }
        }
        return false;
    }



    /**
     * --------------------------------------------------------------------------
     *
     *  刷新用户token
     *
     * --------------------------------------------------------------------------
     */

    /**
     * 获取用户最新的accesstokne
     * $appID appid
     * $conmpanyID 公司id
     */
    public function getUserAccessToken( $appID=null, $conmpanyID=null )
    {
        //appid 查询
        if( $appID )
        {
            $where['authorizer_appid'] = $appID;
        }
        //公司id查询
        if( $conmpanyID )
        {
            $where['companyid'] = $conmpanyID;
        }
        if( empty($where) )
        {
            return false;
        }
        $res = SmallProgram::where($where)->select('authorizer_appid','expires_in','authorizer_refresh_token','authorizer_access_token')->first();
        if( $res )
        {
            if( $res->expires_in <= time() )
            {
                //刷新token
                return $this->refreshUserToken( $res->authorizer_appid,$res->authorizer_refresh_token );
            }
            return $res->authorizer_access_token;
        }
        return false;
    }

    /**
     * @param $appid
     * @param $refresh_token
     * @return bool
     * 刷新最新的token
     */
    public function refreshUserToken( $appid, $refresh_token )
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token='.$this->component_access_token ;
        $post['component_appid'] = config('wxconfig.appId');
        $post['authorizer_appid'] = $appid;
        $post['authorizer_refresh_token'] = $refresh_token;
        $data = wxPostCurl( $url, $post );
        if( $data )
        {
            $data = json_decode($data,true);
            if( array_has( $data,'authorizer_access_token') )
            {
                //更新数据库
                $res = SmallProgram::where('authorizer_appid',$appid)->first();
                $res->authorizer_access_token = $data['authorizer_access_token'];
                $res->authorizer_refresh_token = $data['authorizer_refresh_token'];
                $res->expires_in = time()+(int)$data['expires_in'];
                $res->save();
                $authorizer_access_token = $data['authorizer_access_token'];

            }else
            {
                $authorizer_access_token = false;
            }
        }else
        {
            $authorizer_access_token = false;
        }
        return $authorizer_access_token;
    }


}