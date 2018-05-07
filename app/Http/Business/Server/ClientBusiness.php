<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Client\Client;
use App\Http\Model\Client\ClientFollow;
use App\Http\Model\Data\ClientFollowStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClientBusiness extends ServerBase
{


    /**
     * @param $user
     * @param $request
     * @return mixed
     * 模板列表
     */
    public function getClientList( $user,$request )
    {
        $tag = 'client'.$user->companyid;
        Cache::tags([$tag])->flush();
        $where = $tag.$request->input('page').$request->input('k').$request->input('status');
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $user, $request ){
            if( $user->isadmin == 2 )
            {
                $swhere['companyid'] = $user->companyid;

            }else
            {
                $swhere['companyid'] =  $user->companyid;
                $swhere['storeid'] =  $user->storeid;
            }
            $sql = Client::where( $swhere )->orderBy('id','desc')->with('clientToStatus','clientToSource');
            //判断查询
            $k = trim($request->input('k'));
            if( $k )
            {
                if( is_numeric($k) )
                {
                    $sql->where('phone','like','%'.$k.'%');
                }else
                {
                    $sql->where('name','like','%'.$k.'%');
                }
            }
            //状态
            $status = $request->input('status');
            if( $status )
            {
                $sql->where('followstatusid',$status);
            }

            $data = $sql->paginate(config('configure.sPage'));
            return $data;
        });
        return $value;
    }

    /**
     * @return mixed
     * 获取状态
     */
    public function getClientStatus()
    {
        if( Cache::has('clientStatus') )
        {
            $data = Cache::get('clientStatus');
        }else
        {
            $data = ClientFollowStatus::where('status',1)->select('id','name')->get();
            Cache::put('clientStatus',$data,config('configure.sCache'));
        }
        return $data;
    }


    /**
     * @param $user
     * @param $id
     * @return mixed
     * 查询
     */
    public function editClient( $user, $id )
    {
        if( $user->isadmin == 2 )
        {
            $swhere['uuid'] = $id;
            $swhere['companyid'] = $user->companyid;

        }else
        {
            $swhere['uuid'] =  $id;
            $swhere['companyid'] = $user->companyid;
            $swhere['storeid'] =  $user->storeid;
        }
       return Client::where($swhere)->with('clientToClientFollow')->first();
    }

    /**
     * @param $data
     * @param $user
     * @param $id
     * @return bool
     * 修改
     */
    public function updateClient( $data, $user, $id  )
    {
        if( $user->isadmin == 2 )
        {
            $swhere['uuid'] = $id;
            $swhere['companyid'] = $user->companyid;

        }else
        {
            $swhere['uuid'] =  $id;
            $swhere['companyid'] = $user->companyid;
            $swhere['storeid'] =  $user->storeid;
        }
        try{
            $res = Client::where($swhere)->first();
            if( $res )
            {
                DB::beginTransaction();
                $res->followstatusid = $data['followstatusid'];
                $res->followcontent = $data['followcontent'];
                //记录表
                $arr['uuid'] = create_uuid();
                $arr['client_id'] = $res->id;
                $arr['remarks'] = $data['followcontent'];
                $arr['followstatus_id'] = $data['followstatusid'];
                $arr['follow_username'] = $user->nickname;
                $arr['follow_userid'] = $user->id;
                $arr['created_at'] = date("Y-m-d H:i:s");
                ClientFollow::insert( $arr );
                DB::commit();
                return true;
            }else
            {
                return false;
            }
        }catch (\Exception $e)
        {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param $companyId
     * @param $id
     * @return bool
     * 删除用户
     */
    public function destroyClient( $user, $id )
    {
        if( $user->isadmin == 2 )
        {
            $swhere['uuid'] = $id;
            $swhere['companyid'] = $user->companyid;

        }else
        {
            $swhere['uuid'] =  $id;
            $swhere['companyid'] = $user->companyid;
            $swhere['storeid'] =  $user->storeid;
        }
        $res = Client::where($swhere)->delete();
        if( $res )
        {
            return true;
        }else
        {
            return false;
        }
    }
}