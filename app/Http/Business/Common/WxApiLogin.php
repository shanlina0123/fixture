<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:10
 */
namespace App\Http\Business\Common;
use App\Http\Model\Filter\FilterFunction;
use App\Http\Model\User\User;
use App\Http\Model\User\UserToken;
use App\Model\Roles\RoleFunction;
use Illuminate\Support\Facades\Cache;
class WxApiLogin
{
    /**
     * @param $openid
     * openid登陆
     */
    public function userLogin( $openid, $companyid,$nickname,$faceimg )
    {
        if( !$openid || !$companyid )
        {
            responseData(\StatusCode::PARAM_ERROR,"参数错误");
        }
        $res = User::where(['wechatopenid'=>$openid,'companyid'=>$companyid])->first();
        if( $res )
        {
            //直接登陆
            if( $res->status != 1 )
            {
                responseData(\StatusCode::ERROR,"用户被锁定");
            }

            $uToken = UserToken::where('userid',$res->id)->first();
            if( $uToken )
            {
                Cache::forget($uToken->token);
                $uToken->token = str_random(60);
                $uToken->expiration = time()+17280000;//200天
                $uToken->save();
            }else
            {
                $uToken = new UserToken();
                $uToken->uuid = create_uuid();
                $uToken->token = str_random(60);
                $uToken->expiration = time()+17280000;//200天
                $uToken->userid = $res->id;
                $uToken->save();
            }
            $res->Authorization = $uToken->token;
            $res->expiration = $uToken->expiration;
            return $res;
        }else
        {
            //注册成c端客户
            $user = new User();
            $user->uuid = create_uuid();
            $user->companyid = $companyid;
            $user->wechatopenid = $openid;
            $user->isadmin = 0;
            $user->isadminafter = 0;
            $user->type = 1;
            $user->status = 1;
            $user->nickname = $nickname;
            $user->faceimg = $faceimg;
            if( $user->save() )
            {
                $uToken = new UserToken();
                $uToken->uuid = create_uuid();
                $uToken->token = str_random(60);
                $uToken->expiration = time()+17280000;//200天
                $uToken->userid = $user->id;
                $uToken->type = $user->type;
                if( $uToken->save() )
                {
                    $user->Authorization = $uToken->token;
                    $user->expiration = $uToken->expiration;
                    return $user;
                }
            }
            responseData(\StatusCode::ERROR,"登陆失败");
        }
    }

    /**
     * 获取openid
     */
    public function Openid( $appID, $code )
    {
        //1单独部署
        if( config('wxtype.type') == 1 )
        {
            $wx = new WxAlone();
            return $wx->getOpenid( $appID, $code );
        }else
        {
            $wx = new WxAuthorize();
            return $wx->getOpenid( $appID, $code );
        }
    }


    /**
     * @param $data
     * 修改用户昵称
     */
    public function setUserInfo( $data )
    {
        $res = User::where('id',$data['id'])->first();
        if ($res)
        {
            $res->nickname = $data['nickname'];
            $res->faceimg = $data['faceimg'];
            return $res->save();
        }

        return false;
    }


    /****
     * 获取用户视野
     */
    public  function  checkAuth($user)
    {
        //当前访问的控制器和方法
        $current=getCurrentAction();
        //当前访问控制器
        $routeController = $current["controller"];
        $routeMethod = $current["method"];

        //权限控制的控制器
        $confController=array_keys(config("apiallow"));

        //检查那些控制器需要进行权限验证
        if(in_array($routeController,$confController))
        {
            //检测PC用户是否有权限isadminafter=1 | 检查邀请的成员是否有权限isadminafter=0
            if($user->isadminafter==1)
            {
                //非管理员
                if($user->isadmin==0)
                {
                    //访问权限
                    if(!in_array($routeMethod,config("apiallow.SiteController.user")))
                    {
                        return  false;
                    }
                    //视野权限
                    $islook=RoleFunction::where("roleid",$user["roleid"])->where("functionid",2)->value("islook");//权限视野
                    if(!$islook)
                    {
                        return false;
                    }
                    $user->islook=$islook;
                }else{
                    //视野权限
                    $user->islook=1;//所有
                }

            }else{
                //邀请者，B端成员访问权限
                if(!in_array($routeMethod,config("apiallow.SiteController.invitation")))
                {
                    return false;
                }
                //视野权限
                $user->islook=5;//自己 参与者的视野，看自己参与的
            }
        }else{
            //视野权限
            $user->islook=0;//无视野，其他模块正常显示，不进行权限操作
        }
        return $user;

    }

}