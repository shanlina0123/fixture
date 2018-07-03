<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:10
 */
namespace App\Http\Business\Common;

use App\Http\Model\Company\CompanyParticipant;
use App\Http\Model\Filter\FilterRoleFunction;
use App\Http\Model\Site\Site;
use App\Http\Model\Site\SiteInvitation;
use App\Http\Model\Site\SiteParticipant;
use App\Http\Model\User\User;
use App\Http\Model\User\UserToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
                $uToken->type = $res->type;
                $uToken->token = str_random(60);
                $uToken->expiration = time()+17280000;//200天
                $uToken->userid = $res->id;
                $uToken->save();
            }

            $res->nickname = $nickname;
            $res->faceimg = $faceimg;
            $res->save();

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
                $uToken->type = $user->type;
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
     * @param $openid
     * @param $companyid
     * @param $nickname
     * @param $faceimg
     * @param $scene 携带的参数
     * 变更用户身份
     */
    public function userChangeType( $openid, $companyid,$nickname,$faceimg, $scene )
    {
        //u代表用户id   p代表职位id   t代表类型 1为邀请2为绑定  因为此字段长度限制为32位所有简写
        parse_str($scene,$arr);
        switch ( (int)$arr['t'] )
        {
            case 1://邀请参与
                $res = User::where(['wechatopenid'=>$openid,'companyid'=>$companyid])->first();
                if( $res )
                {
                    //查询到了用户
                    if( $res->type == 0 )
                    {
                        if( $res->isadminafter == 1 )
                        {
                            responseData(\StatusCode::ERROR,"您已经绑定了管理者不能再次绑定");
                        }else
                        {
                            responseData(\StatusCode::ERROR,"您已是成员不能重复绑定");
                        }
                    }else
                    {
                        //C端的用户变为成员
                        try{
                            DB::beginTransaction();
                            //查询成员信息
                            $participant = CompanyParticipant::where(['companyid'=>$companyid,'id'=>$arr['p']])->first();
                            //1修改用户表
                            $res->type = 0;
                            $res->isinvitationed = 1;
                            $res->positionid = $participant->positionid;
                            $user = $res->save();
                            //判断是不是添加了
                            $Invitation = SiteInvitation::where(['companyid'=>$companyid,'siteid'=>$arr['s']])->first();
                            if( $Invitation )
                            {
                                responseData(\StatusCode::ERROR,"您已是此项目成员");
                            }
                            //工地对应区域
                            $site = Site::where(['companyid'=>$companyid,'id'=>$arr['s']])->first();


                            //添加工地成员表
                            $siteInvitation = new SiteInvitation();
                            $siteInvitation->uuid = create_uuid();
                            $siteInvitation->companyid = $companyid;
                            $siteInvitation->storeid = $site->storeid;
                            $siteInvitation->cityid = $site->cityid;
                            $siteInvitation->siteid = $arr['s'];
                            $siteInvitation->participantid = $arr['p'];//成员信息id
                            $siteInvitation->userid = $arr['u'];
                            $siteInvitation->joinuserid = $res->id;
                            $siteInvitation->created_at = date("Y-m-d H:i:s");
                            $siteInvitation->save();
                            if( $user && $siteInvitation->id )
                            {
                                DB::commit();
                                return $this->userLogin( $openid, $companyid,$nickname,$faceimg );
                            }
                            DB::rollBack();
                            responseData(\StatusCode::ERROR,"邀请失败");
                        }catch ( Exception $e )
                        {
                            DB::rollBack();
                            responseData(\StatusCode::ERROR,"邀请失败");
                        }
                    }
                }else
                {
                    //注册成邀请的用户
                    try{
                        DB::beginTransaction();
                        //查询成员信息
                        $participant = CompanyParticipant::where(['companyid'=>$companyid,'id'=>$arr['p']])->first();
                        //用户表
                        $user = new User();
                        $user->uuid = create_uuid();
                        $user->companyid = $companyid;
                        $user->positionid = $participant->positionid;
                        $user->wechatopenid = $openid;
                        $user->isadmin = 0;
                        $user->isadminafter = 0;
                        $res->type = 0;
                        $res->isinvitationed = 1;
                        $user->status = 1;
                        $user->nickname = $nickname;
                        $user->faceimg = $faceimg;
                        $user->save();

                        //判断是不是添加了
                        $Invitation = SiteInvitation::where(['companyid'=>$companyid,'siteid'=>$arr['s']])->first();
                        if( $Invitation )
                        {
                            responseData(\StatusCode::ERROR,"您已是此项目成员");
                        }
                        //工地对应区域
                        $site = Site::where(['companyid'=>$companyid,'id'=>$arr['s']])->first();
                        //查询成员信息

                        //添加工地成员表
                        $siteInvitation = new SiteInvitation();
                        $siteInvitation->uuid = create_uuid();
                        $siteInvitation->companyid = $companyid;
                        $siteInvitation->storeid = $site->storeid;
                        $siteInvitation->cityid = $site->cityid;
                        $siteInvitation->siteid = $arr['s'];
                        $siteInvitation->participantid = $res->id;//成员信息id
                        $siteInvitation->userid = $arr['p'];
                        $siteInvitation->joinuserid = $res->id;
                        $siteInvitation->created_at = date("Y-m-d H:i:s");
                        $siteInvitation->save();
                        if( $user->id && $siteInvitation->id )
                        {
                            DB::commit();
                            return $this->userLogin( $openid, $companyid,$nickname,$faceimg );
                        }
                        DB::rollBack();
                        responseData(\StatusCode::ERROR,"邀请失败");
                    }catch ( Exception $e )
                    {
                        DB::rollBack();
                        responseData(\StatusCode::ERROR,"邀请失败");
                    }
                }
                break;
            case 2://绑定用户
                $res = User::where(['id'=>$arr['u'],'companyid'=>$arr['c']])->first();
                if( $res )
                {
                    try{
                        DB::beginTransaction();
                        //查看有无其他身份
                        $other = User::where(['companyid'=>$arr['c'],'wechatopenid'=>$openid])->first();
                        if( $other )
                        {
                            if( $other->isadminafter == 1 && $other->type == 0 )
                            {
                                responseData(\StatusCode::ERROR,"您的账号已绑定不能再次绑定");
                            }else
                            {
                                //清除用户的token
                                $uToken = UserToken::where('userid',$other->id)->first();
                                Cache::forget($uToken->token);
                                $uToken->delete();

                                //存在其他身份
                                $res->wechatopenid = $openid;
                                $res->oid = $other->id;
                                $upRes = $res->save();
                                //暂时清除其他身份
                                $other->wechatopenid = '';
                                $upOther = $other->save();
                                if( $upOther && $upRes)
                                {
                                    DB::commit();
                                    return $this->userLogin( $openid, $companyid,$nickname,$faceimg );
                                }
                            }
                        }else
                        {
                            //不存在其他身份
                            $res->wechatopenid = $openid;
                            if($res->save())
                            {
                                DB::commit();
                                return $this->userLogin( $openid, $companyid,$nickname,$faceimg );
                            }

                        }
                        DB::rollBack();
                        responseData(\StatusCode::ERROR,"绑定失败");
                    }catch ( Exception $e )
                    {
                        DB::rollBack();
                        responseData(\StatusCode::ERROR,"绑定失败");
                    }
                }
                responseData(\StatusCode::ERROR,"绑定失败");
                break;
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
        $routeController = $current["controller"];//当前访问的控制器
        $routeMethod = $current["method"];//当前访问的方法
        //权限控制的控制器
        $confController=array_keys(config("apiallow"));
        //权限控制的方法
        $confUserAllow=config("apiallow.".$routeController.".user");
        $confInvitationAllow=config("apiallow.".$routeController.".invitation");
        //权限控制的视野栏目
        $confFuncid=config("apiallow.".$routeController.".funcid");//菜单id,对应表filter_function中pid=0的菜单中主键id

        //检测是否需要进行权限控制
        if(in_array($routeController,$confController))
        {
            //检测PC用户是否有权限isadminafter=1 | 检查邀请的成员是否有权限isadminafter=0
            if($user->isadminafter==1)
            {
                //非管理员
                if($user->isadmin==0)
                {
                    //访问权限
                    if(!in_array($routeMethod,$confUserAllow)){return  false; }
                    //视野权限
                    $islook=FilterRoleFunction::where("roleid",$user->roleid)->where("functionid",$confFuncid)->value("islook");//权限视野
                    if(!$islook) {return false;}
                    $user->islook=$islook;
                }else{
                    //视野权限
                    $user->islook=1;//所有
                }
            }else{
                //邀请者，B端成员访问权限
                if(!in_array($routeMethod,$confInvitationAllow)){return false;}
                //视野权限
                $user->islook=5;//自己 参与者的视野，看自己参与的
            }
        }else
        {
            //视野权限 无视野，其他模块正常显示，不进行权限操作
            $user->islook=0;//
        }
        return $user;

    }

}