<?php
use Illuminate\Support\Facades\Cache;
use \App\Http\Model\Sms\History;
class Sms
{
    //定义发送短信的url
    /**
     * @param $phone 电话号码
     * @param $conent 短信内容
     * @return bool 返回真或者假
     */
    function  GetSms($phone,$conent)
    {
        $post_data = array();
        $post_data['account'] = iconv('GB2312', 'GB2312',"VIP_ljw");
        $post_data['pswd'] = iconv('GB2312', 'GB2312',"sxDXlijia521");
        $post_data['mobile'] =trim($phone);
        $post_data['msg']=mb_convert_encoding("$conent",'UTF-8', 'auto');
        $url='';
        $o="";
        foreach ($post_data as $k=>$v)
        {
            $o.= "$k=".urlencode($v)."&";
        }
        $post_data=substr($o,0,-1);
        return file_get_contents($url.$post_data);
    }

    /**
     * @param int $pw_length
     * @return string
     */
    static function create_code()
    {
        return rand(1000,9999);
    }

    /**
     * @param $phone
     * @param $conent
     * @return int
     * 发送短信
     */
    static function SendSms( $phone, $conent )
    {
        return 1;

    }


    /**
     * @param $phone
     * @param $type
     * @return mixed
     *  发送短信公共方法
     */
    static function getCode( $phone, $type )
    {
        $reg = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/';
        if( preg_match($reg, $phone)  == false )
        {
            responseData(StatusCode::ERROR,'手机号码验证失败');
        }

        $time = date("Y-m-d H:i");
        $count = History::whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i') = ?",array($time))->count();
        if( $count >= config('configure.sms_count') )
        {
            Sms::SendSms(config('configure.manage_phone'),'温馨提示：一分钟内发送短信超过'.config('configure.sms_count').'条');
            responseData(StatusCode::ERROR,'发送失败...');

        }else
        {
            $rowCount =  History::whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i') = ? and phone = ? ",array( $time, $phone))->count();
            if( $rowCount > config('configure.sms_Icount') )
            {
                responseData(StatusCode::ERROR,'频繁操作导致发送失败...');
            }else
            {
                $code = Sms::create_code();
                Cache::put('tel_'.$phone,$code,config('configure.sms_cache'));
                switch ( $type )
                {
                    case "1":
                        $content = "温馨提示:您注册验证码为：" . $code . "请勿向他人泄露！";
                        break;
                    case "2":
                        $content = "温馨提示:您修改手机号码的验证码为：" . $code . "请勿向他人泄露！";
                        break;
                    case "3":
                        $content = "温馨提示:您修改密码的验证码为：" . $code . "请勿向他人泄露！";
                        break;
                    case "4":
                        $content = "温馨提示:您登陆的验证码为：" . $code . "请勿向他人泄露！";
                        break;
                }
                $res = Sms::SendSms( $phone, $content );
                if( $res )
                {
                    $user = session('userInfo');
                    $sms = new History();
                    $sms->companyid = $user?$user->companyid:0;
                    $sms->userid = $user?$user['id']:0;
                    $sms->type = 1;
                    $sms->content = $content;
                    $sms->code = $code;
                    $sms->phone = $phone;
                    $sms->created_at = date("Y-m-d H:i:s");
                    $sms->save();
                    responseData(StatusCode::SUCCESS,'发送成功');

                }else
                {
                    responseData(StatusCode::ERROR,'发送失败...');
                }
            }
        }
    }
}


