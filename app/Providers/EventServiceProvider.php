<?php

namespace App\Providers;

use App\Http\Business\Server\WxTempletBusiness;
use App\Http\Model\Company\Company;
use App\Http\Model\Log\Notice;
use App\Http\Model\Site\Site;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //手动注册的事件

        /**
         * 消息日志记录
         */
        Event::listen('log.notice', function ($type,$user,$event,$notice_type=false) {

            if( $notice_type )
            {
                if( $event['createuserid'] = $user->id )
                {
                    return true;
                }
            }
            $obj = new Notice;
            $obj->uuid = create_uuid();
            $obj->companyid = $user->companyid;
            $obj->nickname = $user->nickname;
            $obj->faceimg = $user->faceimg;
            $obj->isread = 0;
            switch ( (int)$type )
            {
                //1关注 、2赞、3评论、4客户预约
                case 2:
                    $obj->userid = $notice_type?$event['createuserid']:$user->id;
                    $obj->typeid = 2;
                    $obj->iscreate = 1;
                    $obj->typename = '赞';
                    $obj->content = str_replace('【用户微信昵称】', $obj->nickname,config('template.12'));
                    $obj->content = str_replace('【标题】',$event['name'],$obj->content);
                    $obj->siteid = $event['siteid'];
                    $obj->dynamicid = $event['dynamicid'];
                    break;
                case 3:
                    $obj->userid = $notice_type?$event['createuserid']:$user->id;
                    $obj->typeid = 3;
                    $obj->iscreate = $notice_type && $event['replyuserid']?1:0;
                    $obj->typename = '评论';
                    $obj->content = str_replace('【用户微信昵称】', $obj->nickname,config('template.11'));
                    $obj->content = str_replace('【评论内容前10个字】', str_limit($event['content'],10),$obj->content);
                    $obj->content = str_replace('【标题】', $event['name'],$obj->content);
                    $obj->siteid = $event['siteid'];
                    $obj->dynamicid = $event['dynamicid'];
                    break;
                case 4:
                    $obj->userid = $notice_type?'':$user->id;
                    $obj->typeid = 4;
                    $obj->iscreate = 1;
                    $obj->typename = '客户预约';
                    //1预约参观2免费量房3我要报名4装修报价5抽奖活动
                    $name = Company::where( 'id', $obj->companyid)->value('fullname');
                    switch (  (int)$event['sourceid'] )
                    {
                        case 1:
                            $site = Site::where('id',$event['siteid'])->select('cityid','storeid')->first();
                            $obj->title = '预约参观';
                            $obj->content = $notice_type?str_replace('【客户姓名】',$event['name'],config('template.7')):str_replace('【公司简称】',$name,config('template.3'));
                            $obj->content = str_replace('【工地】',$event['sname'],$obj->content);
                            $obj->siteid = $event['siteid'];
                            $obj->cityid = $site->cityid;
                            $obj->storeid = $site->storeid;
                            $event['title'] = $obj->title;
                            break;
                        case 2:
                            $obj->title = '免费量房';
                            $obj->content = $notice_type?str_replace('【客户姓名】',$event['name'],config('template.5')):str_replace('【公司简称】',$name,config('template.1'));
                            $obj->siteid = 0;
                            $event['title'] = $obj->title;
                            break;
                        case 4:
                            $obj->title = '快速报价';
                            $obj->content = $notice_type?str_replace('【客户姓名】',$event['name'],config('template.6')):str_replace('【公司简称】',$name,config('template.2'));
                            $obj->siteid = 0;
                            $event['title'] = $obj->title;
                            break;
                        case 5:
                            break;
                    }
                    if( array_has($event,'formId') )
                    {
                        //发送小程序消息
                        $temple = new WxTempletBusiness;
                        $temple->sendTemplet($event,$user->companyid,1);
                    }
                    break;
            }
            $obj->save();
            if($notice_type){
                Cache::tags(['NoticeList'.$event['createuserid']])->flush();
            }else{
                Cache::tags(['NoticeList'.$user->id])->flush();
            }
        });

        /**
         * 关注和浏览统计
         */
        Event::listen('site.statistics', function ($res,$event) {
            $res->$event = $res->$event+1;
            $res->save();
        });
    }
}
