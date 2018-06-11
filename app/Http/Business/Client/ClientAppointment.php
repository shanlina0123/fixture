<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 9:33
 */

namespace App\Http\Business\Client;


use App\Http\Model\Client\Client;

class ClientAppointment
{
    public function Appointment( $data )
    {
        $client = new Client();
        $client->uuid = create_uuid();
        $client->companyid = $data['companyid'];
        $client->storeid = array_has($data,'storeid')?$data['storeid']:0;
        $client->sourcecateid = $data['sourcecateid'];
        $client->sourceid = $data['sourceid'];
        $client->phone = $data['phone'];
        $client->name = $data['name'];
        $client->area = array_has($data,'area')?$data['area']:0;
        $client->content = $data['content'];
        $client->wechatopenid = $data['wechatopenid'];
        $client->created_at = date("Y-m-d H:i:s");
        return $client->save();
    }
}