<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 9:33
 */

namespace App\Http\Business\Client;


use App\Http\Model\Activity\Activity;
use App\Http\Model\Client\Client;
use App\Http\Model\Site\Site;

class ClientAppointment
{
    public function Appointment( $data )
    {
        $client = new Client();
        //工地
        if( array_has($data,'siteid') )
        {
            $site = Site::where('id',$data['siteid'])->select('cityid','storeid')->first();
            $data['storeid'] = $site->storeid;
            $data['cityid'] = $site->cityid;
        }
        //活动
        if( array_has($data,'activityid') )
        {
            $activity = Activity::where('id',$data['activityid'])->select('storeid','cityid')->first();
            $data['storeid'] = $activity->storeid;
            $data['cityid'] = $activity->cityid;
        }
        $client->uuid = create_uuid();
        $client->companyid = $data['companyid'];
        $client->storeid = array_has($data,'storeid')?$data['storeid']:0;
        $client->cityid =array_has($data,'cityid')?$data['cityid']:0;
        $client->sourcecateid = $data['sourcecateid'];
        $client->sourceid = $data['sourceid'];
        $client->phone = $data['phone'];
        $client->name = $data['name'];
        $client->area = array_has($data,'uarea')?$data['uarea']:0;
        $client->content = $data['content'];
        $client->clientcity = array_has($data,'clientcity')?$data['clientcity']:'';
        $client->wechatopenid = $data['wechatopenid'];
        $client->created_at = date("Y-m-d H:i:s");
        return $client->save();
    }
}